@extends('layouts.app')

@section('content')
    <div class="center iumbotron">
        <div class="text-center">
            <h1>Welcom to the Microposts</h1>
            {!! link_to_route('signup.get','Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
        </div>
    </div>
@endsection'