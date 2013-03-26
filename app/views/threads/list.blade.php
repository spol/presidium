@extends('layouts.master')

@section('main')
    <!-- Main component for a primary marketing message or call to action -->
    <div class="jumbotron">
      <h1>Welcome to the Presidium</h1>
      <p>
	  <a class="btn btn-large btn-primary" href="{{ URL::route('startDiscussion') }}">Start a new discussion</a>
      </p>
    </div>
    <style>

      .jumbotron {
	margin-top: 30px;
      }

      .reply-count, .last-reply {
	text-align: center;
      }

      .thread-headings h2, .thread-headings span{
	font-size: 16px;
	text-transform: uppercase;
	margin: 0 0 15px;
	line-height: 1;
      }

      .thread .reply-count, .thread .last-reply {
	color: #666;
      }

      .thread .topic a {
	font-weight: bold;
	color: #333;
      }

      .thread-headings
      {
	border-bottom: 2px solid #ddd;
      }

      .thread {
	padding: 16px 0;
	border-bottom: 1px solid #ddd;
      }

    </style>


    <div class="row thread-headings">
	<div class="span8">
	    <h2>Discussions</h2>
	</div>
	<div class="span2 reply-count">
	    <span>Replies</span>
	</div>
	<div class="span2 last-reply">
	    <span>Updated</span>
	</div>

    </div>

    @foreach ($threads as $thread)

    <div class="row thread">
	<div class="span8 topic">
	    <a href="{{ URL::route('viewDiscussion', array($thread->id)) }}">{{ $thread->topic }}</a>
	</div>
	<div class="span2 reply-count">
	    ?
	</div>
	<div class="span2 last-reply">
	    {{ $thread->updated_at->diffForHumans() }}
	</div>
    </div>

    @endforeach

    <div style="margin-top: 16px;">
	<a class="btn btn-large btn-primary" href="{{ URL::route('startDiscussion') }}">Start a new discussion</a>
    </div>

@stop

