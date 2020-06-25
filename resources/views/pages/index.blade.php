@extends("layouts.app")

@section("content")
@foreach($posts as $post)
    <h1>{{$post->imd}}</h1>
    @endforeach

    @endsection