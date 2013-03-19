<?php

class ThreadsController extends BaseController {

	public function threadsList()
	{
		$threads = Thread::all();
		return View::make('threads.list', array('threads' => $threads));
	}

	public function threadView(Thread $thread)
	{

	}

	public function createThread()
	{

	}

	public function createThreadForm()
	{
		return View::make('threads.create');
	}

	public function replyToThread(Thread $thread)
	{

	}

}