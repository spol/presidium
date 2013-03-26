<h1>{{ $thread->topic }}</h1>

@foreach ($thread->posts as $post)
    <h2>Post</h2>
    <div class="author">
	{{ $post->author->name }}
	<img src="{{ $post->author->profile_image }}" alt="">
    </div>
    <div class="meta">
	{{ $post->created_at }}
    </div>
    <div>{{ $post->html }}</div>
@endforeach

{{ Form::open(array('route' => array('replyToDiscussion', $thread->id))) }}

{{ Form::textarea('content') }}

{{ Form::button("Reply") }}

{{ Form::close() }}