@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<ul class="list-unstyled">
			
			@foreach ($posts as $post)
			<li>
				<h2>{{HTML::linkRoute('posts.show', $post->title, $post->slug)}}</h2>
				<div>{{$post->content}}</div>
			</li>
			@endforeach
			
		</ul>
	</div>
</div>
@stop