<h1>Current Discussions</h1>

<a href="{{ URL::route('startDiscussion') }}">Start new discussion</a>

@foreach ($threads as $thread)

<div class="thread">
	{{ $thread->topic }}
</div>

@endforeach