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
}