@extends('layouts.admin')

@section('content')
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-primary">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">{{ Lang::get('admin.teams') }}</h3>
			  	</div>
			  	<div class="panel-body">
			  		{{ Lang::choice('admin.stats.teams_total', Team::all()->count(), ['amount' => Team::all()->count()]) }}
			  	</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-primary">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">{{ Lang::get('admin.streamers') }}</h3>
			  	</div>
			  	<div class="panel-body">
			    	{{ Lang::choice('admin.stats.streamers_total', Streamer::all()->count(), ['amount' => Streamer::all()->count()]) }}
			  	</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-primary">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">{{ Lang::get('admin.live_right_now') }}</h3>
			  	</div>
			  	<div class="panel-body">
			    	{{ Lang::choice('admin.stats.live_total', Streamer::whereStatus(1)->count(), ['amount' => Streamer::whereStatus(1)->count()]) }}
			  	</div>
			</div>
		</div>
	</div>
@stop