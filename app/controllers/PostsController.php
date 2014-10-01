<?php

class PostsController extends \BaseController {

	/**
	 * Display a listing of posts
	 *
	 * @return Response
	 */
	public function index()
	{
		$posts = Post::all();

		return View::make('posts.index', compact('posts'));
	}

	/**
	 * Show the form for creating a new post
	 *
	 * @return Response
	 */
	public function create()
	{
		if (Sentry::check()) {
			
			return View::make('posts.create');

		} else {

			return "404";
		}
	}

	/**
	 * Store a newly created post in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (Sentry::check()) {

			$validator = Validator::make($data = Input::all(), Post::$rules);

			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}

			//Post::create($data);
			$post = new Post;
			$post->title = Input::get('title');
			$post->slug = Str::slug(Input::get('title'));
			$post->content = Input::get('content');
			$post->save();

			return Redirect::route('posts.index');
		}
	}

	/**
	 * Display the specified post.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$post = Post::where('slug','=',$slug)->firstOrFail();

		return View::make('posts.show', compact('post'));
	}

	/**
	 * Show the form for editing the specified post.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($slug)
	{
		if (Sentry::check()) {
			
			$post = Post::where('slug','=',$slug)->firstOrFail();

			return View::make('posts.edit', compact('post'));
		} else {
			# code...
		}
	}

	/**
	 * Update the specified post in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($slug)
	{
		if (Sentry::check()) {
			$post = Post::where('slug','=',$slug)->firstOrFail();

			$validator = Validator::make($data = Input::all(), Post::$rules);

			if ($validator->fails())
			{
				return Redirect::back()->withErrors($validator)->withInput();
			}

			$post->update($data);

			return Redirect::route('posts.index');
		}
	}

	/**
	 * Remove the specified post from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($slug)
	{
		if (Sentry::check()) {
			$id = Post::where('slug','=',$slug)->firstOrFail()->id;
			Post::destroy($id);
		}
		//return Redirect::route('posts.index');
	}

}
