@extends('layouts.master')

@section('header')
<div class="container-fluid">
	<div class="row">
		<div class="jumbotron">
			Fathur Rohman
		</div>
	</div>
</div>
@stop

@section('content')
<div class="row">
	<div class="col-md-12">
		<ul class="list-unstyled">
			
			@foreach ($posts as $post)
			<li>
				<h2>{{HTML::linkRoute('posts.show', $post->title, $post->slug)}}</h2>
				<div class="col-md-12">{{substr($post->content, 0, 500)}}</div>
				
				@if (Sentry::check() )
				<div class="col-md-12">
					<div class="btn-group">
					{{HTML::linkRoute('posts.create', 'Create', null, ['class'=>'btn btn-info btn-xs'])}}
					{{HTML::linkRoute('posts.edit', 'Edit', $post->slug, ['class'=>'btn btn-warning btn-xs'])}}
					{{Form::button('Delete', [
						'class'			=> 'btn btn-danger btn-xs delete', 
						'data-slug'		=> $post->slug,
						'data-token'	=> csrf_token()
					])}}
					</div>
				</div>
				@endif
			</li>
			@endforeach
			
			{{--Form::open(['route'=>['posts.destroy',$post->],'method'=>'DELETE'])}}
			{{Form::close()}}

			{{Form::token()--}}
		</ul>
	</div>
</div>
@stop

@section('script')
<script>
$('.delete').click(function() {
	var $del = $(this);
	var slug = $del.data('slug');
	var token = $del.data('token');

	$.post('{{{ URL::to("/") }}}/posts/'+slug,{
		'_method'	: 'DELETE',
		'_token'	: token
	},function(resp) {
		console.log(resp);
	});
});
</script>
@stop