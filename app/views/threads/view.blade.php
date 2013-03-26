@extends('layouts.master')

@section('main')
    <h1>{{ $thread->topic }}</h1>

    <style>
	.post {
	    padding: 10px 0;
	    border-bottom: 1px solid #ccc;
	}
	.author, .meta {
	    text-align: center;
	    width: 100px;
	    color: #666;
	}
	.author img {
	    display: block;
	    margin: 0 auto;
	}

	.reply-form {
	    margin-top: 30px;
	}
    </style>

    @foreach ($thread->posts as $post)
	<div class="media post">
	    <div class="pull-left">
		<div class="author">
		    <img src="{{ $post->author->profile_image }}" alt="">
		    {{ $post->author->name }}
		</div>
		<div class="meta">
		{{ $post->created_at->diffForHumans() }}
		</div>
	    </div>
	    <div class="media-body">{{ $post->html }}</div>
	</div>
    @endforeach

    <div class="reply-form">

    {{ Form::open(array('route' => array('replyToDiscussion', $thread->id))) }}

    {{ Form::textarea('content') }}

    {{ Form::button("Reply", array('class' => 'btn btn-primary', 'type' => 'submit')) }}

    {{ Form::close() }}
    </div>
@stop