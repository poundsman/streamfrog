@extends('layouts.admin')

@section('content')
	<div class="row">
		<div class="col-md-6">
			@if (Session::has('message'))
	            <div class="alert alert-{{ Session::get('type') }} alert-dismissible" role="alert">
	              	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{{ Lang::get('admin.close') }}</span></button>
	                {{ Session::get('message') }}
	            </div>
	        @endif
			<div class="panel panel-primary">
 				<div class="panel-heading">Teams</div>
 				<div class="panel-body text-center">
 					{{ Form::open(array('role' => 'form', 'method' => 'GET')) }}
						{{ Form::text('filter', Input::has('filter') ? Input::get('filter') : null, array('placeholder' => Lang::get('admin.filter_placeholder'), 'class' => 'form-control')) }}
					{{ Form::close() }}
				</div>
				<div class="list-group">
					@forelse ($teams as $team)
						<div class="list-group-item popover-info" data-toggle="popover" title="{{ Lang::get('admin.team.information', ['object' => $team->name]) }}" 
							data-content='
								<div class="col-md-12">
									<dl class="dl-horizontal">
										<dt>{{ Lang::get("admin.team.id") }}</dt>
									  	<dd>{{ $team->id }}</dd>

									  	<dt>{{ Lang::get("admin.team.name") }}</dt>
									  	<dd>{{ $team->name }}</dd>

									  	<dt>{{ Lang::get("admin.team.apikey") }}</dt>
									  	<dd>{{ $team->apikey }}</dd>

										<dt>{{ Lang::get("admin.team.logo") }}</dt>
										<dd>{{ $team->logo }}</dd>

										<dt>{{ Lang::get("admin.team.url") }}</dt> 
										<dd>{{ $team->url }}</dd>

										<dt>{{ Lang::get("admin.team.hashtag") }}</dt> 
										<dd>{{ "#" . $team->hashtag }}</dd>

										<dt>{{ Lang::get("admin.team.member_count") }}</dt> 
										<dd>{{ $team->streamers->count() }}</dd>

										<dt>{{ Lang::get("admin.created_at") }}</dt> 
										<dd>{{ $team->created_at }} ({{ Date::parse($team->created_at)->ago() }})</dd>

										<dt>{{ Lang::get("admin.updated_at") }}</dt> 
										<dd>{{ $team->updated_at }} ({{ Date::parse($team->updated_at)->ago() }})</dd>

										<dt>{{ Lang::get("admin.additional_tags") }}</dt> 
										<dd>{{ $team->getAdditionalTags() }}</dd>

										<dt>{{ Lang::get("admin.last_edit_by") }}</dt> 
										@if ($team->edits->count())
											<dd>{{ Sentry::findUserById($team->edits->last()->by)->username }}</dd>
										@else
											<dd>{{ Lang::get("admin.no_edits") }}</dd>
										@endif

										<dt>{{ Lang::get("admin.last_edit_action") }}</dt>
										@if ($team->edits->count())
											<dd>{{ $team->edits->last()->description() }}</dd>
										@else
											<dd>{{ Lang::get("admin.no_edits") }}</dd>
										@endif
									</dl>
								</div>
							'>
							<div class="row">
								<div class="col-md-8">
									<h4 class="list-group-item-heading">{{ $team->name }} <small>
									@if ($team->edits->count()) 
										({{ Lang::get('admin.last_edit_small', ['when' => Date::parse($team->edits->last()->created_at)->ago(), 'by' => Sentry::findUserById($team->edits->last()->by)->username]) }})
									@else 
										({{ Lang::get("admin.no_edits") }})
									@endif
									</small></h4>
					    			<p class="list-group-item-text">{{ Lang::choice('admin.team.subtitle', $team->streamers->count(), ['members' => $team->streamers->count(), 'hashtag' => '#' . $team->hashtag]) }}</p>
								</div>
								<div class="col-md-4 text-right">
									<div class="btn-group">
									  	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									    	{{ Lang::get('admin.options.label') }} <span class="caret"></span>
									  	</button>
									  	<ul class="dropdown-menu" role="menu">
										    <li>{{ HTML::link('admin/teams-edit/' . $team->id, Lang::get('admin.options.edit')) }}</li>
										    <li>{{ HTML::link('admin/teams-delete/' . $team->id, Lang::get('admin.options.delete')) }}</li>
										    <li class="divider"></li>
										    <li>{{ HTML::link('admin/teams-history/' . $team->id, Lang::get('admin.options.history')) }}</li>
										    <li class="divider"></li>
										    <li>{{ HTML::link('api/teams/' . $team->apikey, Lang::get('admin.options.api_call'), array('target' => '_blank')) }}</li>
									  	</ul>
									</div>
								</div>
							</div>
					  	</div>
					@empty
						<div class="panel-body text-center">
	 						<span class="text-muted">{{ Lang::get('admin.no_teams_found') }}</span>
	 					</div>
					@endforelse
					@if ($teams->links() != '')
						<div class="panel-body text-center">
							{{ $teams->appends(array('filter' => Input::get('filter')))->links() }}
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-primary">
 				<div class="panel-heading">Add new team</div>
 				<div class="panel-body">
					{{ Form::open(array('role' => 'form')) }}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
								    {{ Form::label('name', Lang::get("admin.team.name")) }}
								    {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
								    {{ $errors->first('name', '<p class="text-danger">:message</p>') }}
						</div>
							</div>
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('apikey') ? 'has-error' : '' }}">
								    {{ Form::label('apikey', Lang::get("admin.team.apikey")) }}
								    {{ Form::text('apikey', Input::old('apikey'), array('class' => 'form-control')) }}
								    {{ $errors->first('apikey', '<p class="text-danger">:message</p>') }}
								</div>
							</div>
						</div>
						<div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
						    {{ Form::label('logo', Lang::get("admin.team.logo")) }}
						    {{ Form::text('logo', Input::old('logo'), array('class' => 'form-control')) }}
						    {{ $errors->first('logo', '<p class="text-danger">:message</p>') }}
						</div>
						<div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
						    {{ Form::label('url', Lang::get("admin.team.url") . ' (' . Lang::get("admin.team.url_help") . ')') }}
						    {{ Form::text('url', Input::old('url'), array('class' => 'form-control')) }}
						    {{ $errors->first('url', '<p class="text-danger">:message</p>') }}
						</div>
						<div class="form-group {{ $errors->has('hashtag') ? 'has-error' : '' }}">
						    {{ Form::label('hashtag', Lang::get("admin.team.hashtag") . ' (' . Lang::get("admin.team.hashtag_help") . ')') }}
						    {{ Form::text('hashtag', Input::old('hashtag'), array('class' => 'form-control')) }}
						    {{ $errors->first('hashtag', '<p class="text-danger">:message</p>') }}
						</div>
						<div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
						    {{ Form::label('tags', Lang::get("admin.additional_tags") . ' (' . Lang::get("admin.team.additional_tags_help") . ')') }}
						    {{ Form::text('tags', Input::old('tags'), array('class' => 'form-control')) }}
						    {{ $errors->first('tags', '<p class="text-danger">:message</p>') }}
						</div>
						{{ Form::submit(Lang::get("admin.team.add_new_submit"), array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop