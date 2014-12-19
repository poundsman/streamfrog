@extends('layouts.admin')

@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			@if (Session::has('message'))
	            <div class="alert alert-{{ Session::get('type') }} alert-dismissible" role="alert">
	              	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">{{ Lang::get('admin.close') }}</span></button>
	                {{ Session::get('message') }}
	            </div>
	        @endif
			<div class="panel panel-primary">
 				<div class="panel-heading">{{ Lang::get('admin.streamer.edit') }}</div>
 				<div class="panel-body">
					{{ Form::open(array('role' => 'form')) }}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
								    {{ Form::label('name', Lang::get('admin.streamer.name') . " (" . Lang::get('admin.no_edit_allowed') . ")") }}
								    <p class="form-control-static">{{ $streamer->name }}</p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('apikey') ? 'has-error' : '' }}">
								    {{ Form::label('apikey', Lang::get('admin.streamer.apikey') . " (" . Lang::get('admin.no_edit_allowed') . ")") }}
								    <p class="form-control-static">{{ $streamer->apikey }}</p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('team') ? 'has-error' : '' }}">
								    {{ Form::label('team', Lang::get('admin.streamer.team')) }}
								    {{ Form::select('team', Team::all()->lists('name', 'id'), $streamer->team_id, array('class' => 'form-control')) }}
								    {{ $errors->first('team', '<p class="text-danger">:message</p>') }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
								    {{ Form::label('type', Lang::get('admin.streamer.type')) }}
								    {{ Form::select('type', ['mlg' => Lang::get("admin.streamer.platform.mlg"), 'twitch' => Lang::get("admin.streamer.platform.twitch")], $streamer->type, array('class' => 'form-control')) }}
								    {{ $errors->first('type', '<p class="text-danger">:message</p>') }}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('twitch') ? 'has-error' : '' }}">
								    {{ Form::label('twitch', Lang::get('admin.streamer.twitch')) }}
								    {{ Form::text('twitch', $streamer->twitch, array('class' => 'form-control')) }}
								    {{ $errors->first('twitch', '<p class="text-danger">:message</p>') }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('mlg') ? 'has-error' : '' }}">
								    {{ Form::label('mlg', Lang::get('admin.streamer.mlg')) }}
								    {{ Form::text('mlg', $streamer->mlg, array('class' => 'form-control')) }}
								    {{ $errors->first('mlg', '<p class="text-danger">:message</p>') }}
								</div>
							</div>
						</div>
						<div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
						    {{ Form::label('url', Lang::get("admin.streamer.url") . ' (' . Lang::get("admin.streamer.url_help") . ')') }}
						    {{ Form::text('url', $streamer->url, array('class' => 'form-control')) }}
						    {{ $errors->first('url', '<p class="text-danger">:message</p>') }}
						</div>
						<div class="form-group {{ $errors->has('twitter') ? 'has-error' : '' }}">
						    {{ Form::label('twitter', Lang::get("admin.streamer.twitter") . ' (' . Lang::get("admin.streamer.twitter_help") . ')') }}
						    {{ Form::text('twitter', $streamer->twitter, array('class' => 'form-control')) }}
						    {{ $errors->first('twitter', '<p class="text-danger">:message</p>') }}
						</div>
						<div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
						    {{ Form::label('tags', Lang::get("admin.additional_tags") . ' (' . Lang::get("admin.streamer.additional_tags_help") . ')') }}
						    {{ Form::text('tags', $streamer->getAdditionalTags(), array('class' => 'form-control')) }}
						    {{ $errors->first('tags', '<p class="text-danger">:message</p>') }}
						</div>
						{{ Form::hidden('streamer', $streamer->id) }}
						{{ Form::submit(Lang::get("admin.streamer.edit_submit"), array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
				</div>
 			</div>
 		</div>
 	</div>
@endsection