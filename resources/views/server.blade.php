@extends('layouts.layout')

@section('content')
<script type="text/javascript" src="/js/server.js"></script>
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />


@foreach ($servers as $server)
	<div class="panel panel-{{ $server->state === 'ok' ? 'success' : ($server->state === 'ko' ? 'danger': 'warning')}} server" data-id="{{ $server->id_server }}">
	    <div class="panel-heading">
	      <h3 class="panel-title">{{ $server->name }}</h3>
	    </div>
	    <div class="panel-body">
	      	<div class="map">{{ $server->map }}</div>
	    	<div class="is_sotf">{{ $server->is_sotf }}</div>
	    	<div class="state">{{ $server->state }}</div>
	    	<div class="ip">{{ $server->ip }}</div>
	    	<div class="path">{{ $server->path }}</div>
	    	<div class="port">{{ $server->port }}</div>
	    </div>
	</div>
@endforeach


@stop
