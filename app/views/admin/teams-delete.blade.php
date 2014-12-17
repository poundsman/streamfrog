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
 				<div class="panel-heading">{{ Lang::get('admin.team.delete') }}</div>
 				<div class="panel-body">
					{{ Form::open(array('role' => 'form')) }}
						{{ Form::hidden('team', $team->id) }}
						<div class="row">
							<div class="col-md-9">
								{{ Form::submit(Lang::choice('admin.team.delete_confirmation', $team->streamers->count(), ['team' => $team->name, 'members' => $team->streamers->count()]), array('class' => 'btn btn-danger form-control')) }}
							</div>
							<div class="col-md-3">
								{{ HTML::link('admin/teams', Lang::get('admin.cancel'), ['class' => 'btn btn-primary form-control']) }}
							</div>
						</div>
					{{ Form::close() }}
				</div>
 			</div>
 		</div>
 	</div>
@endsection