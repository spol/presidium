<h1>Current Discussions</h1>

<a href="{{ URL::route('startDiscussion') }}">Start new discussion</a>

@foreach ($threads as $thread)

<div class="thread">
	<a href="{{ URL::route('viewDiscussion', array($thread->id)) }}">{{ $thread->topic }}</a>
</div>

@endforeach