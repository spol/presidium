<?php

class Thread extends Eloquent
{

	public function created_by()
	{
		return $this->belongsTo('User', 'created_by');
	}

	public function posts()
	{
		return $this->hasMany('Post', 'thread_id');
	}
}