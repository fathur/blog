@extends('layouts.master')

@section('styles')
{{HTML::style('packages/summernote/summernote.css')}}
{{HTML::style('css/font-awesome.min.css')}}
@stop

{{-- Content Area --}}
@section('content')
<div class="row">
	<div class="col-md-12">
		{{ HTML::ul($errors->all()) }}
		{{Form::open(['route'=>'posts.store','role'=>'form'])}}
			<div class="form-group">
				{{Form::text('title', '', ['class'=>'form-control input-lg', 'placeholder'=>'Title'])}}
			</div>
			<div class="form-group">
				{{Form::textarea('content', '', ['id'=>'createpost'])}}
			</div>
			{{Form::submit('Save', ['class'=>'btn btn-default btn-block'])}}
		{{Form::close()}}
	</div>
</div>
@stop

{{-- Additional Scripts Lib --}}
@section('scripts')
{{HTML::script('packages/summernote/summernote.min.js')}}
@stop

{{-- Executed script --}}
@section('script')
<script>
$('#createpost').summernote({
	onkeyup: function(e) {
		var $htmlcontent = $(this).html();
		$('#createpost').html($htmlcontent);
	}
});
</script>
@stop