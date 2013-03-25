<h1>{{ $thread->topic }}</h1>

@foreach ($thread->posts as $post)
	<h2>Post</h2>
    <div>{{ $post->content }}</div>
@endforeach