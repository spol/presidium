@extends('layouts.master')

@section('main')
    <h1>Start a new discussion</h1>

    {{ Form::open(array('route'=>'startDiscussionSubmit', 'method'=>'post')) }}

    {{ Form::text('topic') }}

    {{ Form::textarea('content') }}

    {{ Form::button("Start", array('class' => 'btn btn-primary', 'type' => 'submit')) }}

    {{ Form::close() }}
@stop
