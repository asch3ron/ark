@extends('layouts.layout')

@section('content')
<script type="text/javascript" src="/js/configuration.js"></script>

<table class="table table-responsive table-hover" data-server-id="{{ $id_server }}">
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Type</th>
      <th>Default</th>
      <th style="width: 15%;">Value</th>
      <th>Comment</th>
    </tr>
  </thead>
  <tbody>

@foreach ($configurations as $configuration)
	<tr data-id="{{ $configuration->id }}">
      <td>{{ $configuration->id }}</td>
      <td>{{ $configuration->name }}</td>
      <td>{{ $configuration->type }}</td>
      <td>{{ $configuration->default }}</td>
      	<td>
      		@if ($configuration->type === 'boolean')
			    <select class="form-control">
		          <option {{ $configuration->value === 'True' ? 'selected="selected"' : '' }}>True</option>
		          <option {{ $configuration->value === 'False' ? 'selected="selected"' : '' }}>False</option>
		        </select>
			@elseif ($configuration->type === 'integer')
			  <input class="form-control input-sm" type="text" value="{{ $configuration->value }}" />
			@else
			  <input class="form-control input-sm" type="text" value="{{ $configuration->value }}" />
			@endif
		</td>
      <td>{{ $configuration->comment }}</td>
    </tr>
@endforeach
</tbody>
</table>

<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />

@stop
