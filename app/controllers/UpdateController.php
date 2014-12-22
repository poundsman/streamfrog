<?php

class UpdateController extends BaseController {

	public function uploadMedia($parameters = array())
	{
		if(!array_key_exists('media', $parameters) && !array_key_exists('media_data', $parameters))
		{
			throw new \Exception('Parameter required missing : media or media_data');
		}
		$parameters["status"] = "Combined.";
		$parameters["trim_users"] = 1;
		Twitter::set_new_config(array('host' => 'upload.twitter.com'));	
		$result = Twitter::query('media/upload.json', 'POST', $parameters, true);
		Twitter::set_new_config(array());

		return $result;
	}

	/**
	 * Updates streams at /index (is also the default action) [CALLED BY CRONJOB]
	 * 
	 * @return void
	 */
	public function getIndex() 
	{
		$twitchKey = $_ENV['TWITCH_KEY'];

		$twitchStreams = Streamer::where('type', '=', 'twitch')->get();
		$mlgStreams = Streamer::where('type', '=', 'mlg')->get();

		foreach ($twitchStreams as $twitchStream) 
		{
			$twitchResponse = file_get_contents("https://api.twitch.tv/kraken/streams/" . $twitchStream->twitch . "?client_id=" . $twitchKey);
			$twitchJSON = json_decode($twitchResponse);

			$twitchStreamer = Streamer::find($twitchStream->id);

			if ($twitchJSON->stream)
			{
				if ($twitchStreamer->status != 1)
				{
					$tweetParams = array();
					$tweetParams['status'] = '@' . $twitchStreamer->twitter . ' is now live on @Twitch ' . $twitchStreamer->url;
					$tweetParams['format'] = 'json';

					$streamerImgPath = $twitchStreamer->image_path;
					if($streamerImgPath != null && file_exists($streamerImgPath)) {
						$streamerImg = file_get_contents($streamerImgPath);
						$uploadParams = array('media' => $streamerImg);
						$uploadResponse = $this->uploadMedia($uploadParams);
						$tweetParams['media_ids'] = $uploadResponse->media_id_string;
					}

					$tweetResult = Twitter::postTweet($tweetParams);
					$twitchStreamer->status = 1;


					$stream = new Stream;
					$stream->streamer_id = $twitchStreamer->id;
					$stream->status = "live";
					$stream->type = "twitch";
					if ($stream->save())
					{
						$twitchStreamer->stream_id = $stream->id;
					}  
				}

				$twitchStreamer->viewers = $twitchJSON->stream->viewers;

				if ($twitchStreamer->stream_id != null)
				{
					$stat = new Stat;
					$stat->stream_id = $twitchStreamer->stream_id;
					$stat->viewers = $twitchStreamer->viewers;
					$stat->save();
				}  
			}  else {
				if ($twitchStreamer->status == 1)
				{
					echo "Offline";
					$twitchStreamer->status = 0;
					$twitchStreamer->viewers = 0;

					if ($twitchStreamer->stream_id != null)
					{
						$stream = Stream::find($twitchStreamer->stream_id);
						$stream->status = "ended";
						$stream->ended_at = new DateTime;
						if ($stream->save())
						{
							$twitchStreamer->stream_id = null;
						} 
					}  
				}
			}
			if ($twitchStreamer->save())
			{
				$twitchStreamer->touch();
			} 
		}

		$mlgResponse = file_get_contents("http://streamapi.majorleaguegaming.com/service/streams/all");
		$mlgJSON = json_decode($mlgResponse);

		foreach ($mlgStreams as $mlgStream) 
		{
			$mlgStreamer = Streamer::find($mlgStream->id);

			foreach ($mlgJSON->data->items as $mlgItem) 
			{
				if($mlgItem->channel_id == $mlgStream->mlg) 
				{
					$mlgStatus = $mlgItem->status;
					break;
				} else {
					$mlgStatus = null;
				}
			}

			if (!is_null($mlgStatus))
			{
				if ($mlgStreamer->status != 1 && $mlgStatus == 1)
				{
					Twitter::postTweet(['status' => '. @' . $mlgStreamer->twitter . ' is now live on @MLG ' . $mlgStreamer->url, 'format' => 'json']);

					$stream = new Stream;
					$stream->streamer_id = $mlgStreamer->id;
					$stream->status = "live";
					$stream->type = "mlg";
					if ($stream->save())
					{
						$mlgStreamer->stream_id = $stream->id;
					}  
				}

				if ($mlgStreamer->status == 1 && $mlgStatus != 1)
				{
					if ($mlgStreamer->stream_id != null)
					{
						$stream = Stream::find($mlgStreamer->stream_id);
						$stream->status = "ended";
						$stream->ended_at = new DateTime;
						if ($stream->save())
						{
							$mlgStreamer->stream_id = null;
						}  
					} 
				}

				$mlgStreamer->status = $mlgStatus;
			}  else {
				$mlgStreamer->status = $mlgStatus;
			}

			if ($mlgStreamer->save())
			{
				$mlgStreamer->touch();
			}
		}
	}

}
