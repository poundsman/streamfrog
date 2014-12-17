<?php

class Edit extends \Eloquent {
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
	 * Local: team_id -> Team
	 * 
	 * @return Team
	 */
    public function team()
    {
        return $this->belongsTo('Team');
    }

	/**
	 * Creates the description for an Edit
	 * 
	 * @return string
	 */
	public function description() 
	{
		$this->cleanEdit();
		return "Change <strong>" . $this->attribute . "</strong> from <em>" . $this->old . "</em> to <em>" . $this->new . "</em>";
	}

	/**
	 * Cleans up an edit string (ready for showing)
	 * 
	 * @return boolean
	 */
	private function cleanEdit() 
	{
		if ($this->old == '')
		{
			$this->old = 'nothing';
		}

		if ($this->new == '')
		{
			$this->new = 'nothing';
		}  

		if ($this->attribute == 'team_id')
		{
			$this->old = $this->old . " (" . (Team::find($this->old) ? Team::find($this->old)->name : "Deleted") . ")";
			$this->new = $this->new . " (" . (Team::find($this->new) ? Team::find($this->new)->name : "Deleted") . ")";
		}

		return true;
	}
}