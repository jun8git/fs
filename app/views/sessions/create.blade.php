{{Form::open(array('route' => "sessions.store"))}}

{{Form::label('email', "Email: ")}}
{{Form::text('email')}}

{{Form::label('password', "Password: ")}}
{{Form::password('password')}}

{{Form::submit()}}


{{Form::close()}}