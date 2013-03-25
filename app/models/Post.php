<?php

use dflydev\markdown\MarkdownParser;

class Post extends Eloquent
{
	public function thread()
	{
		return $this->belongsTo('Thread');
	}
}