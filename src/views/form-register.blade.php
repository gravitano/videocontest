@extends('Videocontest::template')

@section('main')

<h3>Register</h3>

{{ 
	Form::open(
		array(
			'url'	=>	URL::full()
		)
	)
}}

{{ Form::label('fullname', 'Full Name :') }}
{{ Form::text('fullname') }}
{{ $errors->first('fullname','<span class="error">:message</span>') }}

{{ Form::label('username', 'User Name :') }}
{{ Form::text('username', Videocontest::getTwitter('screen_name')) }}
{{ $errors->first('username','<span class="error">:message</span>') }}

{{ Form::label('email', 'Email :') }}
{{ Form::text('email') }}
{{ $errors->first('email','<span class="error">:message</span>') }}

{{ Form::label('address', 'Address :') }}
{{ Form::textarea('address') }}
{{ $errors->first('address','<span class="error">:message</span>') }}

{{ Form::label('city', 'City :') }}
{{ Form::text('city') }}
{{ $errors->first('city','<span class="error">:message</span>') }}

{{ Form::label('phone', 'Phone :') }}
{{ Form::text('phone') }}
{{ $errors->first('phone','<span class="error">:message</span>') }}

<div>
	<button class="btn btn-success">
		Register
	</button>
</div>

{{ Form::close() }}
@stop