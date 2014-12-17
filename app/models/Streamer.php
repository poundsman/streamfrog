<?php

class Streamer extends \Eloquent {
	protected $fillable = [];

	/**
	 * Local: team_id -> Team
	 * 
	 * @return Team
	 */
	public function team()
    {
        return $this->belongsTo('Team');
    }

    /**
     * Edit: streamer_id -> Local
     * 
     * @return Edit
     */
    public function edits()
    {
        return $this->hasMany('Edit');
    }

    /**
     * Stream: streamer_id -> Local
     * 
     * @return Stream
     */
    public function streams()
    {
        return $this->hasMany('Stream');
    }

    /**
     * Get the streamers live streams
     * 
     * @return Stream
     */
    public function liveStreams()
    {
        return Stream::where('streamer_id', '=', $this->id)->whereStatus('live')->get();
    }

    /**
     * Get the streamers finished streams
     * 
     * @return Stream
     */
    public function endedStreams()
    {
        return Stream::where('streamer_id', '=', $this->id)->whereStatus('ended')->get();
    }

    /**
     * Gets the status of a streamer as a word
     * 
     * @return string
     */
	public function getStatus() 
	{
		switch ($this->status) 
		{
			case 2:
				return Lang::get('public.status.replay');
				break;
			case 1:
				return Lang::get('public.status.online');
				break;
			default:
				return Lang::get('public.status.offline');
		}
	}

	/**
	 * Gets the class of the status of a streamer for styling
	 * 
	 * @return string
	 */
	public function getStatusClass() 
	{
		switch ($this->status) {
			case 2:
				return Lang::get('public.status.class_replay');
				break;
			case 1:
				return Lang::get('public.status.class_online');
				break;
			default:
				return Lang::get('public.status.class_offline');
		}
	}

	/**
	 * Creates the HTML for the status indication on the front page
	 * 
	 * @return string
	 */
	public function makeStatusLiveIndication() {
		return '<span class="label pull-right label-' . $this->getStatusClass() . ' live-indication">' . $this->getStatus() . '</span>';
	}

	/**
	 * Creates the tags for a streamer with optional custom tags
	 * 
	 * @param  string   $tags
	 * @return boolean
	 */
	public function createTags($tags = "") 
	{
		$tag_elements = [
			$this->apikey,
			$this->name,
			$this->team_id,
			$this->team->name,
			$this->type,
			(($this->type == "mlg") ? $this->mlg : $this->twitch),
			$this->twitter
		];

		$this->tags = $this->id;

		foreach ($tag_elements as $tag_element) 
		{
			$this->tags .= "|" . $tag_element;
		}

		if ($tags != "")
		{
			$this->customtags = static::cleanTags($tags);
		}

		return $this->save();
	}

	/**
	 * Cleans up a tag-string and formats it properly for DB insertion
	 * 
	 * @param  string $tags
	 * @return string
	 */
	private static function cleanTags($tags) {
		$tags = trim($tags, "|"); 

		if (str_contains($tags, ','))
		{
			$tags = str_replace(', ', ',', $tags);
			$tags = str_replace(',', '|', $tags);
		}

		return $tags;
	}

	/**
	 * Gets a streamers custom tags as a comma seperated list
	 * 
	 * @return string
	 */
	public function getAdditionalTags() {
		return str_replace('|', ', ', $this->customtags);
	}

}