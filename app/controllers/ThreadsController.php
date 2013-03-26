<?php

class ThreadsController extends BaseController {

	public function threadsList()
	{
		$threads = Thread::all();
		return View::make('threads.list', array('threads' => $threads));
	}

	public function threadView(Thread $thread)
	{
		// var_dump($thread->posts);
		$view_data = array(
			"thread" => $thread
		);
		return View::make('threads.view', $view_data);
	}

	public function createThread()
	{
		$thread = new Thread();
		$thread->topic = Input::get('topic');

		$user = Session::get('user');

		$user->threads()->save($thread);

		$post = new Post();
		$post->content = Input::get('content');
		$post->posted_by = $user->id;

		$thread->posts()->save($post);

		return Redirect::to('discussion/'.$thread->id);
	}

	public function createThreadForm()
	{
		return View::make('threads.create');
	}

	public function replyToThread(Thread $thread)
	{
		$post = new Post();

		$post->content = Input::get('content');
		$post->posted_by = Session::get('user')->id;

		$thread->posts()->save($post);

		return Redirect::route('viewDiscussion', array($thread->id));
	}

}