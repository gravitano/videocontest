@extends('Videocontest::template')

@section('main')

{{ 
	Form::open(
		array(
			'url'	=>	URL::to('upload'),
			'files'	=> 	true
		)
	)
}}

{{ Form::label('url', 'Link Video :') }}
{{ Form::text('url') }}
{{ $errors->first('url','<span class="text-error">:message</span>') }}

{{ Form::label('caption', 'Caption :') }}
{{ Form::text('caption') }}
{{ $errors->first('caption','<span class="text-error">:message</span>') }}

{{ Form::label('desc', 'Desc :') }}
{{ Form::textarea('desc') }}
{{ $errors->first('desc','<span class="text-error">:message</span>') }}

<div>
	<button class="btn" type="submit">
		Upload
	</button>
</div>

{{ Form::close() }}
@stop