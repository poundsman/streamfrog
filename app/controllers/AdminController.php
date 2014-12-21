<?php

class AdminController extends BaseController {

	/**
	 * Shared validation rules
	 * 
	 * @var array
	 */
	protected $shared_rules = [
		'url' => ['required', 'regex:/^([a-zA-Z0-9]+)(\.)([a-zA-Z0-9]+)(\/)([a-zA-Z0-9_-]+)$/']

	];

	/**
	 * Streamer creation validation rules
	 * 
	 * @var array
	 */
	protected $streamer_creation_rules = [
		'name'   => 'required|unique:streamers'
	];

	/**
	 * Streamer validation rules
	 * 
	 * @var array
	 */
	protected $streamer_rules = [
		'team'    => 'required|integer|min:1',
		'type'    => 'required',
		'twitch'  => 'required_if:type,twitch',
		'mlg'     => 'integer|required_if:type,mlg',
		'twitter' => 'required'
	];

	/**
	 * Team creation validation rules
	 * 
	 * @var array
	 */
	protected $team_creation_rules = [
		'name'   => 'required|unique:teams'
	];

	/**
	 * Team validation rules
	 * 
	 * @var array
	 */
	protected $team_rules = [
		'logo'    => 'required',
		'hashtag' => 'required'
	];

	/**
	 * Login validation rules
	 * 
	 * @var array
	 */
	protected $login_rules = [
		'username' => 'required',
		'password' => 'required'
	];

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() 
	{
		$this->beforeFilter('csrf', ['on' => 'post']);
		$this->beforeFilter('auth', ['except' => ['getLogin', 'postLogin', 'getRegisterDefault']]);

		$teams = Team::orderBy('created_at', 'desc');
		if (Input::has('filter'))
		{
		   	$teams = $teams->where('tags', 'LIKE', '%' . Input::get('filter') . '%');
			$teams = $teams->orWhere('customtags', 'LIKE', '%' . Input::get('filter') . '%');
		}
		$teams = $teams->paginate(7);

		$streamers = Streamer::orderBy('created_at', 'desc');
		if (Input::has('filter'))
		{
		   	$streamers = $streamers->where('tags', 'LIKE', '%' . Input::get('filter') . '%');
			$streamers = $streamers->orWhere('customtags', 'LIKE', '%' . Input::get('filter') . '%');
		}
		$streamers = $streamers->paginate(7);

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
		return View::make('admin.index');
	}

	/**
	 * Loads view at /teams
	 * 
	 * @return View
	 */
	public function getTeams()
	{
		return View::make('admin.teams');
	}

	/**
	 * Loads view at /streamers
	 * 
	 * @return View
	 */
	public function getStreamers()
	{
		return View::make('admin.streamers');
	}

	/**
	 * Loads view at /login
	 * 
	 * @return View
	 */
	public function getLogin()
	{
		return View::make('admin.login');
	}

	/**
	 * Deletes a streamer at /streamers-delete/$id
	 * 
	 * @param  integer $id
	 * @return Redirect
	 */
	public function getStreamersDelete($id)
	{
		$streamer = Streamer::find($id);
		return View::make('admin.streamers-delete')->withStreamer($streamer);
	}

	/**
	 * Deletes a team at /teams-delete/$id
	 * 
	 * @param  integer $id
	 * @return Redirect
	 */
	public function getTeamsDelete($id)
	{
		$team = Team::find($id);
		return View::make('admin.teams-delete')->withTeam($team);

	}

	/**
	 * Loads view at /streamers-edit/$id
	 * 
	 * @param  integer $id
	 * @return View
	 */
	public function getStreamersEdit($id)
	{
		$streamer = Streamer::find($id);
		return View::make('admin.streamers-edit')->withStreamer($streamer);
	}

	/**
	 * Loads view at /teams-edit/$id
	 * 
	 * @param  integer $id
	 * @return View
	 */
	public function getTeamsEdit($id)
	{
		$team = Team::find($id);
		return View::make('admin.teams-edit')->withTeam($team);
	}

	/**
	 * Loads view at /streamers-history/$id
	 * 
	 * @param  integer $id
	 * @return View
	 */
	public function getStreamersHistory($id)
	{
		$streamer = Streamer::find($id);
		return View::make('admin.streamers-history')->withStreamer($streamer);
	}

	/**
	 * Loads view at /teams-history/$id
	 * 
	 * @param  integer $id
	 * @return View
	 */
	public function getTeamsHistory($id)
	{
		$team = Team::find($id);
		return View::make('admin.teams-history')->withTeam($team);
	}

	/**
	 * Handles data posted to /streamers-delete/$id (streamer deletion)
	 * 
	 * @return Redirect
	 */
	public function postStreamersDelete()
	{
		$streamer = Streamer::find(Input::get('streamer'));

		if ($streamer->delete()) 
		{
			return Redirect::to('admin/streamers')->withMessage(Lang::get('messages.streamer_deleted'))->withType(Lang::get('messages.class_success'));
		}

	}

	/**
	 * Handles data posted to /teams-delete/$id (team deletion)
	 * 
	 * @return Redirect
	 */
	public function postTeamsDelete()
	{
		$team = Team::find(Input::get('team'));

		if ($team->delete()) 
		{
			return Redirect::to('admin/teams')->withMessage(Lang::get('messages.team_deleted'))->withType(Lang::get('messages.class_success'));
		}

	}

	/**
	 * Handles data posted to /teams (team creation)
	 * 
	 * @return Redirect
	 */
	public function postTeams()
	{
		$rules = array_merge($this->team_creation_rules, $this->team_rules, $this->shared_rules);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			Input::flash();
		    return Redirect::to('admin/teams')->withErrors($validator);
		}

		$team = new Team;
		$team->name = Input::get('name');
		$team->apikey = Input::get('apikey');
		$team->logo = Input::get('logo');
		$team->url = Input::get('url');
		$team->hashtag = Input::get('hashtag');

		if ($team->save()) 
		{
			if ($team->createTags(Input::get('tags')))
			{
				return Redirect::to('admin/teams')->withMessage(Lang::get('messages.team_created'))->withType(Lang::get('messages.class_success'));
			} else {
				return Redirect::to('admin/teams')->withMessage(Lang::get('messages.error_creating_tags'))->withType(Lang::get('messages.class_error'));
			}
		}
	}

	/**
	 * Handles data posted to /streamers (streamer creations)
	 * 
	 * @return Redirect
	 */
	public function postStreamers()
	{
		$rules = array_merge($this->streamer_creation_rules, $this->streamer_rules, $this->shared_rules);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			Input::flash();
		    return Redirect::to('admin/streamers')->withErrors($validator);
		}

		$streamer = new Streamer;
		$streamer->name = Input::get('name');
		$streamer->apikey = Input::get('apikey');
		$streamer->team_id = Input::get('team');
		$streamer->type = Input::get('type');
		$streamer->twitch = Input::get('twitch');
		$streamer->mlg = Input::get('mlg');
		$streamer->url = Input::get('url');
		$streamer->twitter = Input::get('twitter');

		$img = Input::file('image_path');
		$imageStoragePath = public_path().'/img/streamers/';
		$img->move($imageStoragePath, $img->getClientOriginalName());
		$streamer->image_path = 'img/streamers/'.$img->getClientOriginalName();

		if ($streamer->save()) 
		{
			if ($streamer->createTags(Input::get('tags')))
			{
				return Redirect::to('admin/streamers')->withMessage(Lang::get('messages.streamer_created'))->withType(Lang::get('messages.class_success'));
			} else {
				return Redirect::to('admin/streamers')->withMessage(Lang::get('messages.error_creating_tags'))->withType(Lang::get('messages.class_error'));
			}
		}
	}

	/**
	 * Handles data posted to /login (authentication)
	 * 
	 * @return Redirect
	 */
	public function postLogin()
	{
		$rules = $this->login_rules;
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			Input::flash();
		    return Redirect::to('admin/login')->withErrors($validator);
		}

		try
		{
		    $credentials = [
		        'username'    => Input::get('username'),
		        'password' => Input::get('password'),
		    ];

		    $user = Sentry::authenticate($credentials, false);
		    return Redirect::to('admin/index');
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			return Redirect::to('admin/login')->withMessage(Lang::get('messages.login_required'))->withType(Lang::get('messages.class_error'));
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			return Redirect::to('admin/login')->withMessage(Lang::get('messages.password_required'))->withType(Lang::get('messages.class_error'));
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
			return Redirect::to('admin/login')->withMessage(Lang::get('messages.invalid_password'))->withType(Lang::get('messages.class_error'));
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return Redirect::to('admin/login')->withMessage(Lang::get('messages.invalid_login'))->withType(Lang::get('messages.class_error'));
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
			return Redirect::to('admin/login')->withMessage(Lang::get('messages.user_not_activated'))->withType(Lang::get('messages.class_error'));
		}
	}

	/**
	 * Handles data posted to /streamers-edit
	 * 
	 * @return Redirect
	 */
	public function postStreamersEdit()
	{
		Streamer::saving(function($model)
		{
		    foreach ($model->getDirty() as $attribute => $value)
		    {
		        $original = $model->getOriginal($attribute);

		        $edit = new Edit;
		        $edit->by = Sentry::getUser()->id;
		        $edit->attribute = $attribute;
		        $edit->old = $original;
		        $edit->new = $value;
		        $edit->streamer_id = $model->getKey();
		        if ($attribute != 'tags')
		        {
		        	if ($edit->save())
		        	{
		        		return true;
		        	} else {
		        		return Redirect::to('admin/streamers-edit/' . Input::get('streamer'))->withMessage(Lang::get('messages.error_creating_edit'))->withType(Lang::get('messages.class_error'));
		        	}
		        }
		    }
		});

		$rules = array_merge($this->streamer_rules, $this->shared_rules, ['streamer' => 'required|integer|min:1']);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			Input::flash();
		    return Redirect::to('admin/streamers-edit/' . Input::get('streamer'))->withErrors($validator);
		}

		$streamer = Streamer::find(Input::get('streamer'));
		$streamer->team_id = Input::get('team');
		$streamer->type = Input::get('type');
		$streamer->mlg = Input::get('mlg');
		$streamer->twitch = Input::get('twitch');
		$streamer->url = Input::get('url');
		$streamer->twitter = Input::get('twitter');

		if ($streamer->save()) 
		{
			if ($streamer->createTags(Input::get('tags')))
			{
				return Redirect::to('admin/streamers')->withMessage(Lang::get('messages.streamer_edited'))->withType(Lang::get('messages.class_success'));
			} else {
				return Redirect::to('admin/streamers-edit/' . Input::get('streamer'))->withMessage(Lang::get('messages.error_creating_tags'))->withType(Lang::get('messages.class_error'));
			}
		}
	}

	/**
	 * Handles data posted to /teams-edit
	 * 
	 * @return Redirect
	 */
	public function postTeamsEdit()
	{
		Team::saving(function($model)
		{
		    foreach ($model->getDirty() as $attribute => $value)
		    {
		        $original = $model->getOriginal($attribute);

		        $edit = new Edit;
		        $edit->by = Sentry::getUser()->id;
		        $edit->attribute = $attribute;
		        $edit->old = $original;
		        $edit->new = $value;
		        $edit->team_id = $model->getKey();
		        if ($attribute != 'tags')
		        {
		        	if ($edit->save())
		        	{
		        		return true;
		        	} else {
		        		return Redirect::to('admin/team-edit/' . Input::get('team'))->withMessage(Lang::get('messages.error_creating_edit'))->withType(Lang::get('messages.class_error'));
		        	}
		        }
		    }
		});

		$rules = array_merge($this->team_rules, $this->shared_rules, ['team' => 'required|integer|min:1']);
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			Input::flash();
		    return Redirect::to('admin/teams-edit/' . Input::get('team'))->withErrors($validator);
		}

		$team = Team::find(Input::get('team'));
		$team->logo = Input::get('logo');
		$team->url = Input::get('url');
		$team->hashtag = Input::get('hashtag');

		if ($team->save()) 
		{
			if ($team->createTags(Input::get('tags')))
			{
				return Redirect::to('admin/teams')->withMessage(Lang::get('messages.team_edited'))->withType(Lang::get('messages.class_success'));
			} else {
				return Redirect::to('admin/teams-edit/' . Input::get('team'))->withMessage(Lang::get('messages.error_creating_tags'))->withType(Lang::get('messages.class_error'));
			}
		}
	}
}
