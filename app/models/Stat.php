<?php

class Stat extends \Eloquent {
	protected $fillable = [];

    /**
	 * Local: stream_id -> Stream
	 * 
	 * @return Stream
	 */
    public function stream()
    {
        return $this->belongsTo('Stream');
    }
}