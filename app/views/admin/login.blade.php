@extends('layouts.admin')

@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			@if (Session::has('message'))
	            <div class="alert alert-{{ Session::get('type') }} alert-dismissible" role="alert">
	              	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                {{ Session::get('message') }}
	            </div>
	        @endif
			<div class="panel panel-primary">
 				<div class="panel-heading">Login</div>
 				<div class="panel-body">
 					{{ Form::open(array('role' => 'form')) }}
						<div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
						    {{ Form::label('username', 'Username') }}
						    {{ Form::text('username', Input::old('username'), array('class' => 'form-control')) }}
						    {{ $errors->first('username', '<p class="text-danger">:message</p>') }}
						</div>
						<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
						    {{ Form::label('password', 'Password') }}
						    {{ Form::password('password', array('class' => 'form-control')) }}
						    {{ $errors->first('password', '<p class="text-danger">:message</p>') }}
						</div>
						{{ Form::submit('Sign in', array('class' => 'btn btn-primary')) }}
					{{ Form::close() }}
 				</div>
 			</div>
 		</div>
 	</div>
@endsection