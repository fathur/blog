@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-4 col-md-offset-4">
		{{Form::open(['url' => 'auth/login', 'role' => 'form', 'class' => 'form-signin'])}}
			
			{{Form::email('email', '', [
				'class'=>'form-control',
				'placeholder'=>'Email Address',
				'required'=>'required',
				'autofocus'=>'autofocus'
			])}}

			{{Form::password('password', [
				'class'=>'form-control',
				'placeholder'=>'Password',
				'required'=>'required'
			])}}
			
			<label class="checkbox">
				{{Form::checkbox('remember', 'remember-me', false)}} Remember Me
			</label>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		{{Form::close()}}
	</div>
</div>
@stop