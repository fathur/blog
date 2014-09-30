@extends('layouts.master')

{{-- Header Area --}}
@section('header')
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<input class="form-control input-lg" type="text"></input>
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
				<div class="col-md-12">{{$post->content}}</div>
				<div class="col-md-12">
					<div class="btn-group">
					{{HTML::linkRoute('posts.create', 'Create', null, ['class'=>'btn btn-info btn-xs'])}}
					{{HTML::linkRoute('posts.edit', 'Edit', $post->slug, ['class'=>'btn btn-warning btn-xs'])}}
					{{-- HTML::linkRoute('posts.create', 'Delete', null, []) --}}
					{{Form::button('Delete', [
						'class'			=> 'btn btn-danger btn-xs delete', 
						'data-slug'		=> $post->slug,
						'data-token'	=> csrf_token()
					])}}
					</div>
				</div>
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