<?php

class HomeController extends BaseController {

	/**
	 * Constructor
	 *
	 * @return void 
	 */
	public function __construct() 
	{
		$teams = Team::all();
		$streamers = Streamer::all();

		View::share('teams', $teams);
		View::share('streamers', $streamers);
	}

	/**
	 * Loads view at /index (is also the default view)
	 * 
	 * @return View
	 */
	public function getIndex()
	{
		$live = Streamer::whereStatus(1)->get();
		return View::make('home.index')->withLive($live);
	}

}
