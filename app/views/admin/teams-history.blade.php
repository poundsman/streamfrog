@extends('layouts.admin')

@section('content')
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-primary">
 				<div class="panel-heading">{{ Lang::get('admin.history.heading', ['object' => $team->name]) }}</div>
 				@if ($team->edits->count())
	 				<table class="table table-bordered table-striped">
		 				<thead>
		 					<tr>
						        <th>{{ Lang::get('admin.history.id') }}</th>
						        <th>{{ Lang::get('admin.history.by') }}</th>
						        <th>{{ Lang::get('admin.history.action') }}</th>
						        <th>{{ Lang::get('admin.history.date') }}</th>
					        </tr>
				        </thead>
				        <tbody>
							@foreach ($team->edits->sortByDesc('created_at') as $edit)
				        		<tr><td>{{ $edit->id }}</td><td>{{ Sentry::findUserById($edit->by)->username }}</td><td>{{ $edit->description() }}</td><td>{{ $edit->created_at }}</td></tr>
				        	@endforeach
						</tbody>
					</table>
				@else
					<div class="panel-body">
						<p class="text-center"><strong>{{ Lang::get('admin.no_edits') }}</strong></p>
					</div>
				@endif
 			</div>
 		</div>
 	</div>
@endsection