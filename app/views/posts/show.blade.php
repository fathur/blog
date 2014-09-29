@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h2>{{$post->title}}</h2>
		<div>{{$post->content}}</div>
	</div>
</div>
@stop