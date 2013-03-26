<?php

use dflydev\markdown\MarkdownParser;

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
}