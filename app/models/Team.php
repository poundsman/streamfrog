<?php

class Team extends \Eloquent {
	protected $fillable = ['name'];

	/**
     * Streamer: team_id -> Local
     * 
     * @return Streamer
     */
	public function streamers()
    {
        return $this->hasMany('Streamer');
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
	 * Creates the tags for a team with optional custom tags
	 * 
	 * @param  string   $tags
	 * @return boolean
	 */
	public function createTags($tags = "") 
	{
		$tag_elements = [
			$this->apikey,
			$this->name,
			$this->logo,
			$this->url,
			$this->hashtag
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
	 * Gets a teams custom tags as a comma seperated list
	 * 
	 * @return string
	 */
	public function getAdditionalTags() {
		return str_replace('|', ', ', $this->customtags);
	}
}