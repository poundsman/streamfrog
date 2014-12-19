<?php

class ApiController extends BaseController {

	/**
	 * Shows all streamers
	 * 
	 * @return Json|Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function showAllStreamers()
	{
		$streamers = Streamer::all();

		if ($streamers->count())
		{ 
    		return $streamers;
    	} else {
    		throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException(Lang::get('api.no_streamers_found'));
    	}
	}

	/**
	 * Shows all teams
	 * 
	 * @return Json|Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function showAllTeams()
	{
		$teams = Team::all();

		if ($teams->count())
		{ 
    		return $teams;
    	} else {
    		throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException(Lang::get('api.no_teams_found'));
    	}
	}

	/**
	 * Shows all streams
	 * 
	 * @return Json|Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function showAllStreams()
	{
		$streams = Stream::all();

		if ($streams->count())
		{ 
    		return $streams;
    	} else {
    		throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException(Lang::get('api.no_streams_found'));
    	}
	}

	/**
	 * Shows all stats
	 * 
	 * @return Json|Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function showAllStats()
	{
		$stats = Stat::all();

		if ($stats->count())
		{ 
    		return $stats;
    	} else {
    		throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException(Lang::get('api.no_stats_found'));
    	}
	}

	/**
	 * Shows all streamers that are live
	 * 
	 * @return Json|Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function showLiveStreamers()
	{
		$streamers = Streamer::whereStatus(1)->get();

		if ($streamers->count())
		{ 
    		return $streamers;
    	} else {
    		throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException(Lang::get('api.no_streamers_found'));
    	}
	}

	/**
	 * Shows all streamers that are live or replaying
	 * 
	 * @return Json|Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function showLiveReplayStreamers()
	{
		$streamers = Streamer::whereStatus(1)->orWhereStatus(2)->get();

		if ($streamers->count())
		{ 
    		return $streamers;
    	} else {
    		throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException(Lang::get('api.no_streamers_found'));
    	}
	}

	/**
	 * Show streamers that are specified
	 * 
	 * @return Json|Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function showStreamers($names) {
		$names = explode(',', $names);

    	$streamers = Streamer::whereIn('apikey', $names)->get();

    	if ($streamers->count()) {
    		return $streamers;
    	} else {
    		throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException(Lang::get('api.no_streamers_found'));
    	}
	}

	/**
	 * Show teams that are specified
	 * 
	 * @return Json|Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function showTeams($names) {
		$names = explode(',', $names);

    	$teams = Team::whereIn('apikey', $names)->get();

    	if ($teams->count()) {
    		return $teams;
    	} else {
    		throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException(Lang::get('api.no_teams_found'));
    	}
	}

	/**
	 * Show streams that are specified
	 * 
	 * @return Json|Symfony\Component\HttpKernel\Exception\NotFoundHttpException
	 */
	public function showStreams($ids) {
		$ids = explode(',', $ids);

    	$streams = Stream::whereIn('id', $ids)->get();

    	if ($streams->count()) {
    		return $streams;
    	} else {
    		throw new Symfony\Component\HttpKernel\Exception\NotFoundHttpException(Lang::get('api.no_streams_found'));
    	}
	}

}
