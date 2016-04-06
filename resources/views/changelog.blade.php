@extends('layouts.layout')

@section('content')

@foreach ($changelogs as $changelog)
	<div class="panel panel-{{ $changelog->seen ? 'info' : 'success' }}">
	  <div class="panel-heading">
	    <h3 class="panel-title">v{{ $changelog->version }}</h3>
	  </div>
	  <div class="panel-body">
	  	{!! nl2br(($changelog->text)) !!}
	  </div>
	</div>
@endforeach

@stop
