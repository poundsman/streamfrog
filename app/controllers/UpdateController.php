<?php

	class UpdateController extends BaseController {
		private function handleOfflineTwitchStreamer($twitchStream) {
			if($twitchStream->status == 0)
				return;
			
			$stream = Stream::find($twitchStream->stream_id);
			$stream->status = "ended";
			$stream->ended_at = new DateTime;
			if ($stream->save()) {
				$twitchStream->stream_id = null;
			} 
			$twitchStream->status = 0;
			$twitchStream->save();
		}
		
		private function shouldPostTweetFor($twitchStream, $previouslyLive) {
			if(!$previouslyLive) {
				return true;
			}
		
			$currentDateTime = new DateTime;
			$nextTweetable = new DateTime($twitchStream->last_live);
			$nextTweetable->add(new DateInterval('PT6H'));
			
			return $nextTweetable < $currentDateTime;
		}
		
		public function uploadMedia($parameters = array()) {
			if(!array_key_exists('media', $parameters) && !array_key_exists('media_data', $parameters)) {
				throw new \Exception('Parameter required missing: media or media_data');
			}
			
			if(!array_key_exists('status', $parameters)) {
				$parameters["status"] = "Combined.";
			}
			if(!array_key_exists('trim_users', $parameters)) {
				$parameters["trim_users"] = 1;
			}
			
			Twitter::set_new_config(array('host' => 'upload.twitter.com'));
			$result = Twitter::query('media/upload.json', 'POST', $parameters, true);
			Twitter::set_new_config(array());
			
			return $result;
		}
		
		private function tweetFor($twitchStream) {
			$tweetParams = array();
			$tweetParams['status'] = '.@' . $twitchStream->twitter . ' is now LIVE on @Twitch! ' . $twitchStream->url;
			$tweetParams['format'] = 'json';
			$streamerImgPath = $twitchStream->image_path;
			if($streamerImgPath != null && file_exists($streamerImgPath)) {
				$streamerImg = file_get_contents($streamerImgPath);
				$uploadParams = array('media' => $streamerImg);
				$uploadResponse = $this->uploadMedia($uploadParams);
				$tweetParams['media_ids'] = $uploadResponse->media_id_string;
			}
			return Twitter::postTweet($tweetParams);;
		}
		
		private function getStreamerStatus($streamerName, $twitchStatusJSON) {
			foreach($twitchStatusJSON->streams as $stream) {
				if($stream->channel->name == $streamerName) {
					return $stream;
				}
			}
			return null;
		}
		
		private function handleTwitchStreamer($twitchStream, $twitchStatusJSON) {
			$streamerStatus = $this->getStreamerStatus($twitchStream->twitch, $twitchStatusJSON);
			$isCurrentlyOnline = $streamerStatus != null;
			
			// If the streamer isn't online, do the bare
			// minimum and get out.
			if(!$isCurrentlyOnline) {
				$this->handleOfflineTwitchStreamer($twitchStream);
				return;
			}
			
			$hasPreviouslyBeenOnline = $twitchStream->last_live != '0000-00-00 00:00:00';
			
			// If previously this streamer was offline.
			if($twitchStream->status == 0) {
				$stream = new Stream;
				$stream->streamer_id = $twitchStream->id;
				$stream->status = "live";
				$stream->type = "twitch";
		
				if($this->shouldPostTweetFor($twitchStream, $hasPreviouslyBeenOnline)) {
					$this->tweetFor($twitchStream);
					$twitchStream->last_live = new DateTime;
				}
				
				if ($stream->save()) {
					$twitchStream->stream_id = $stream->id;
				} 
			}
				
			$twitchStream->status = $isCurrentlyOnline ? 1 : 0;
			$twitchStream->viewers = $isCurrentlyOnline ? $streamerStatus->viewers : 0;
			
			$stat = new Stat;
			$stat->stream_id = $twitchStream->stream_id;
			$stat->viewers = $twitchStream->viewers;
			$stat->save();
			
			if($twitchStream->save()) {
				$twitchStream->touch();
			}
		}
		
		private function getTwitchStreamStatusUrlFor($streamerNameCSV) {
			return "https://api.twitch.tv/kraken/streams?channel=" . $streamerNameCSV;
		}
		
		private function handleTwitchStreamers() {
			$twitchStreamers = Streamer::where('type', '=', 'twitch')->get();
			
			$streamerNameCSV = "";
			foreach($twitchStreamers as $twitchStream) {
				$streamerNameCSV = $streamerNameCSV . $twitchStream->twitch .',';
			}
			$streamerNameCSV = trim($streamerNameCSV, ',');
			
			$statusURL = $this->getTwitchStreamStatusUrlFor($streamerNameCSV);
			$twitchResponse = file_get_contents($statusURL);
			$twitchStatusJSON = json_decode($twitchResponse);
			
			foreach($twitchStreamers as $twitchStream) {
				$this->handleTwitchStreamer($twitchStream, $twitchStatusJSON);
			}
		}
		
		public function getIndex() 
		{
			$this->handleTwitchStreamers();
		}
	}

?>