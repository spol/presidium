<?php

class User extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';


	public function threads()
	{
		return $this->HasMany('Thread', 'created_by');
	}

	public function posts()
	{
		return $this->HasMany('Post', 'posted_by');
	}
}