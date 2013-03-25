<h1>Start a new discussion</h1>

{{ Form::open(array('route'=>'startDiscussionSubmit', 'method'=>'post')) }}

{{ Form::text('topic') }}

{{ Form::textarea('content') }}

{{ Form::button("Start") }}

{{ Form::close() }}