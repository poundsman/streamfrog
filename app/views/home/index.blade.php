@extends('layouts.home')

@section('content')
    <div class="row" id="streamsContainer">
    	@foreach ($teams as $team)
    		@if ($team->streamers->count())
	    		<div class="col-md-3 col-sm-4 col-xs-12" id="streamContainer">
		    		<div class="panel panel-primary">
		    			<div class="panel-heading">
						    <h3 class="panel-title">{{ $team->name }} <span class="label label-default label-flair pull-right"><span class="flair flair-label flair-{{ $team->logo }}"></span></span></h3>
						</div>
					  	<div class="list-group">
					  		@foreach ($team->streamers as $streamer)
					  			<a target="_blank" href="http://{{ $streamer->url }}" class="list-group-item"><span class="flair flair-{{ $streamer->type }}"></span> {{ $streamer->name }} {{ $streamer->makeStatusLiveIndication() }}</a>
					  		@endforeach
						</div>
					</div>
		    	</div>
		    @endif
    	@endforeach
    </div>
@stop