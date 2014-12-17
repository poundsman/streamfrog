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
 				<div class="panel-heading">{{ Lang::get('admin.team.edit') }}</div>
 				<div class="panel-body">
					{{ Form::open(array('role' => 'form')) }}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
								    {{ Form::label('name', Lang::get('admin.team.name') . " (" . Lang::get('admin.no_edit_allowed') . ")") }}
								    <p class="form-control-static">{{ $team->name }}</p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('apikey') ? 'has-error' : '' }}">
								    {{ Form::label('apikey', Lang::get('admin.team.apikey') . " (" . Lang::get('admin.no_edit_allowed') . ")") }}
								    <p class="form-control-static">{{ $team->apikey }}</p>
								</div>
							</div>
						</div>
						<div class="form-group {{ $errors->has('logo') ? 'has-error' : '' }}">
						    {{ Form::label('logo', Lang::get('admin.team.logo')) }}
						    {{ Form::text('logo', $team->logo, array('class' => 'form-control')) }}
						    {{ $errors->first('logo', '<p class="text-danger">:message</p>') }}
						</div>
						<div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
						    {{ Form::label('url', Lang::get("admin.team.url") . ' (' . Lang::get("admin.team.url_help") . ')') }}
						    {{ Form::text('url', $team->url, array('class' => 'form-control')) }}
						    {{ $errors->first('url', '<p class="text-danger">:message</p>') }}
						</div>
						<div class="form-group {{ $errors->has('hashtag') ? 'has-error' : '' }}">
						    {{ Form::label('hashtag', Lang::get("admin.team.hashtag") . ' (' . Lang::get("admin.team.hashtag_help") . ')') }}
						    {{ Form::text('hashtag', $team->hashtag, array('class' => 'form-control')) }}
						    {{ $errors->first('hashtag', '<p class="text-danger">:message</p>') }}
						</div>
						<div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
						    {{ Form::label('tags', Lang::get("admin.additional_tags") . ' (' . Lang::get("admin.team.additional_tags_help") . ')') }}
						    {{ Form::text('tags', $team->getAdditionalTags(), array('class' => 'form-control')) }}
						    {{ $errors->first('tags', '<p class="text-danger">:message</p>') }}
						</div>
						{{ Form::hidden('team', $team->id) }}
						{{ Form::submit(Lang::get("admin.team.edit_submit"), array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
				</div>
 			</div>
 		</div>
 	</div>
@endsection