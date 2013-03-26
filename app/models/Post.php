<?php

use dflydev\markdown\MarkdownParser;
use Carbon\Carbon;

class Post extends Eloquent
{
	public function thread()
	{
		return $this->belongsTo('Thread');
	}

	public function author()
	{
		return $this->belongsTo('User', 'posted_by');
	}

	public function setContentAttribute($value)
	{
		$this->attributes['markdown'] = $value;
		$markdownParser = new MarkdownParser;
		$this->attributes['html'] = $markdownParser->transformMarkdown($value);
	}

	public function getCreatedAtAttribute($value)
	{
		return new Carbon($value);
	}
}