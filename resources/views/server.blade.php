@extends('layouts.layout')

@section('content')
<script type="text/javascript" src="/js/server.js"></script>
server :)
<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />

@stop
