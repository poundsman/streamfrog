<?php

class Stream extends \Eloquent {
	protected $fillable = [];

	/**
	 * Local: streamer_id -> Streamer
	 * 
	 * @return Streamer
	 */
    public function streamer()
    {
        return $this->belongsTo('Streamer');
    }

    /**
     * Stat: stream_id -> Local
     * 
     * @return Stat
     */
    public function stats()
    {
        return $this->hasMany('Stat');
    }

    /**
	 * Gets the class of the status of a stream for styling
	 * 
	 * @return string
	 */
	public function getStatusClass() 
	{
		switch ($this->status) {
			case 'live':
				return Lang::get('public.status.class_online');
				break;
			case 'ended':
				return Lang::get('public.status.class_offline');
				break;
			default:
				return Lang::get('public.status.class_replay');
		}
	}
}