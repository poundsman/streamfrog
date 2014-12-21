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
 				<div class="panel-heading">{{ Lang::get('admin.streamers') }}</div>
 				<div class="panel-body text-center">
 					{{ Form::open(array('role' => 'form', 'method' => 'GET', 'enctype' => 'multipart/form-data')) }}
						{{ Form::text('filter', Input::has('filter') ? Input::get('filter') : null, array('placeholder' => Lang::get('admin.filter_placeholder'), 'class' => 'form-control')) }}
					{{ Form::close() }}
				</div>
				<div class="list-group">
					@forelse ($streamers as $streamer)
						<div class="list-group-item popover-info" data-toggle="popover" title="{{ Lang::get('admin.streamer.information', ['object' => $streamer->name]) }}" 
							data-content='
								<div class="col-md-12">
									<dl class="dl-horizontal">
										<dt>{{ Lang::get("admin.streamer.id") }}</dt>
									  	<dd>{{ $streamer->id }}</dd>

									  	<dt>{{ Lang::get("admin.streamer.name") }}</dt>
									  	<dd>{{ $streamer->name }}</dd>

									  	<dt>{{ Lang::get("admin.streamer.apikey") }}</dt>
									  	<dd>{{ $streamer->apikey }}</dd>

										<dt>{{ Lang::get("admin.streamer.team") }}</dt>
										@if ($streamer->team)
											<dd>{{ $streamer->team->name }}</dd>
										@else
											<dd class="text-danger">{{ Lang::get("admin.streamer.team_deleted") }}</dd>
										@endif

										<dt>{{ Lang::get("admin.streamer.type") }}</dt> 
										<dd>{{ $streamer->type }}</dd>

										<dt>{{ Lang::get("admin.streamer.twitch") }}</dt> 
										<dd>{{ $streamer->twitch ? $streamer->twitch : "-" }}</dd>

										<dt>{{ Lang::get("admin.streamer.mlg") }}</dt> 
										<dd>{{ $streamer->mlg ? $streamer->mlg : "-" }}</dd>

										<dt>{{ Lang::get("admin.streamer.url") }}</dt> 
										<dd>{{ $streamer->url }}</dd>

										<dt>{{ Lang::get("admin.streamer.twitter") }}</dt> 
										<dd>{{ "@" . $streamer->twitter }}</dd>

										<dt>{{ Lang::get("admin.streamer.status") }}</dt> 
										<dd class="text-{{ $streamer->getStatusClass() }}">{{ $streamer->getStatus() }}</dd>

										<dt>{{ Lang::get("admin.streamer.viewers") }}</dt> 
										@if ($streamer->viewers == null)
											<dd>0</dd>
										@else
											<dd>{{ $streamer->viewers }}</dd>
										@endif

										<dt>{{ Lang::get("admin.created_at") }}</dt> 
										<dd>{{ $streamer->created_at }} ({{ Date::parse($streamer->created_at)->ago() }})</dd>

										<dt>{{ Lang::get("admin.updated_at") }}</dt> 
										<dd>{{ $streamer->updated_at }} ({{ Date::parse($streamer->updated_at)->ago() }})</dd>

										<dt>{{ Lang::get("admin.additional_tags") }}</dt> 
										<dd>{{ $streamer->getAdditionalTags() }}</dd>

										<dt>{{ Lang::get("admin.streamer.last_live") }}</dt>
										@if ($streamer->last_live == "0000-00-00 00:00:00")
											<dd>{{ Lang::get("admin.streamer.never_live") }}</dd>
										@else
											<dd>{{ $streamer->last_live }} ({{ Date::parse($streamer->last_live)->ago() }})</dd>
										@endif

										<dt>{{ Lang::get("admin.last_edit_by") }}</dt> 
										@if ($streamer->edits->count())
											<dd>{{ Sentry::findUserById($streamer->edits->last()->by)->username }}</dd>
										@else
											<dd>{{ Lang::get("admin.no_edits") }}</dd>
										@endif

										<dt>{{ Lang::get("admin.last_edit_action") }}</dt>
										@if ($streamer->edits->count())
											<dd>{{ $streamer->edits->last()->description() }}</dd>
										@else
											<dd>{{ Lang::get("admin.no_edits") }}</dd>
										@endif
									</dl>
								</div>
							'>
							<div class="row">
								<div class="col-md-8">
									<h4 class="list-group-item-heading">{{ $streamer->name }} <small>
									@if ($streamer->edits->count()) 
										({{ Lang::get('admin.last_edit_small', ['when' => Date::parse($streamer->edits->last()->created_at)->ago(), 'by' => Sentry::findUserById($streamer->edits->last()->by)->username]) }})
									@else 
										({{ Lang::get("admin.no_edits") }})
									@endif
									</small></h4>
									@if ($streamer->team)
										<p class="list-group-item-text">{{ Lang::get('admin.streamer.subtitle', ['team' => $streamer->team->name, 'type' => $streamer->type, 'twitter' => '@' . $streamer->twitter]) }}</p>
									@else
										<p class="list-group-item-text text-danger">{{ Lang::get('admin.streamer.on_deleted_team') }}</p>
									@endif
								</div>
								<div class="col-md-4 text-right">
									<div class="btn-group">
									  	<button type="button" class="btn btn-{{ $streamer->getStatusClass() }} dropdown-toggle" data-toggle="dropdown">
									    	{{ Lang::get('admin.options.label') }} <span class="caret"></span>
									  	</button>
									  	<ul class="dropdown-menu" role="menu">
										    <li>{{ HTML::link('admin/streamers-edit/' . $streamer->id, Lang::get('admin.options.edit')) }}</li>
										    <li>{{ HTML::link('admin/streamers-delete/' . $streamer->id, Lang::get('admin.options.delete')) }}</li>
										    <li class="divider"></li>
										    <li>{{ HTML::link('admin/streamers-history/' . $streamer->id, Lang::get('admin.options.history')) }}</li>
										    <li class="divider"></li>
										    <li>{{ HTML::link('api/streamers/' . $streamer->apikey, Lang::get('admin.options.api_call'), array('target' => '_blank')) }}</li>
									  	</ul>
									</div>
								</div>
							</div>
					  	</div>
					@empty
						<div class="panel-body text-center">
	 						<span class="text-muted">{{ Lang::get('admin.no_streamers_found') }}</span>
	 					</div>
					@endforelse
					@if ($streamers->links() != '')
						<div class="panel-body text-center">
							{{ $streamers->appends(array('filter' => Input::get('filter')))->links() }}
						</div>
					@endif
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-primary">
 				<div class="panel-heading">{{ Lang::get('admin.streamer.add_new') }}</div>
 				<div class="panel-body">
					{{ Form::open(array('role' => 'form', 'enctype' => 'multipart/form-data')) }}
						<div class="row">
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
								    {{ Form::label('name', Lang::get("admin.streamer.name")) }}
								    {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
								    {{ $errors->first('name', '<p class="text-danger">:message</p>') }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('apikey') ? 'has-error' : '' }}">
								    {{ Form::label('apikey', Lang::get("admin.streamer.apikey")) }}
								    {{ Form::text('apikey', Input::old('apikey'), array('class' => 'form-control')) }}
								    {{ $errors->first('apikey', '<p class="text-danger">:message</p>') }}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('team') ? 'has-error' : '' }}">
								    {{ Form::label('team', Lang::get("admin.streamer.team")) }}
								    {{ Form::select('team', Team::all()->lists('name', 'id'), null, array('class' => 'form-control')) }}
								    {{ $errors->first('team', '<p class="text-danger">:message</p>') }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('type') ? 'has-error' : '' }}">
								    {{ Form::label('type', Lang::get("admin.streamer.type")) }}
								    {{ Form::select('type', array('mlg' => Lang::get("admin.streamer.platform.mlg"), 'twitch' => Lang::get("admin.streamer.platform.twitch")), null, array('class' => 'form-control')) }}
								    {{ $errors->first('type', '<p class="text-danger">:message</p>') }}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('twitch') ? 'has-error' : '' }}">
								    {{ Form::label('twitch', Lang::get("admin.streamer.twitch")) }}
								    {{ Form::text('twitch', Input::old('twitch'), array('class' => 'form-control')) }}
								    {{ $errors->first('twitch', '<p class="text-danger">:message</p>') }}
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group {{ $errors->has('mlg') ? 'has-error' : '' }}">
								    {{ Form::label('mlg', Lang::get("admin.streamer.mlg")) }}
								    {{ Form::text('mlg', Input::old('mlg'), array('class' => 'form-control')) }}
								    {{ $errors->first('mlg', '<p class="text-danger">:message</p>') }}
								</div>
							</div>
						</div>
						<div class="form-group {{ $errors->has('url') ? 'has-error' : '' }}">
						    {{ Form::label('url', Lang::get("admin.streamer.url") . ' (' . Lang::get("admin.streamer.url_help") . ')') }}
						    {{ Form::text('url', Input::old('url'), array('class' => 'form-control')) }}
						    {{ $errors->first('url', '<p class="text-danger">:message</p>') }}
						</div>
						<div class="form-group {{ $errors->has('twitter') ? 'has-error' : '' }}">
						    {{ Form::label('twitter', Lang::get("admin.streamer.twitter") . ' (' . Lang::get("admin.streamer.twitter_help") . ')') }}
						    {{ Form::text('twitter', Input::old('twitter'), array('class' => 'form-control')) }}
						    {{ $errors->first('twitter', '<p class="text-danger">:message</p>') }}
						</div>
						<div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
						    {{ Form::label('tags', Lang::get("admin.additional_tags") . ' (' . Lang::get("admin.streamer.additional_tags_help") . ')') }}
						    {{ Form::text('tags', Input::old('tags'), array('class' => 'form-control')) }}
						    {{ $errors->first('tags', '<p class="text-danger">:message</p>') }}
						</div>
						<div class="form-group {{ $errors->has('image_url') ? 'has-error' : '' }}">
						    {{ Form::label('image_path', Lang::get("admin.image_url") . ' (' . Lang::get("admin.streamer.image_url_help") . ')') }}
						    {{ Form::file('image_path', Input::old('image_path'), array('class' => 'form-control')) }}
						    {{ $errors->first('image_path', '<p class="text-danger">:message</p>') }}
						</div>
						{{ Form::submit(Lang::get("admin.streamer.add_new_submit"), array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
@stop
