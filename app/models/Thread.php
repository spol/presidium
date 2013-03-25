<?php

class Thread extends Eloquent
{

	public function created_by()
	{
		return $this->belongsTo('User');
	}

	public function posts()
	{
		return $this->hasMany('Post', 'thread_id');
	}
}