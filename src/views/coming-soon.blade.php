@extends('Videocontest::template')

@section('main')

<h1>Coming Soon!</h1>

<p>
This event will be started on {{ Config::get('Videocontest::app.startdate') }}	
</p>

@stop