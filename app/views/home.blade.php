@extends('layout')

@section('content')

<div class="center aligned ui grid">
            <img src="{{asset('images/yoda-med.png')}}">
        </div>

        <h1 class="quote"> Login to my site to read my quotes.. </h1>

<div class="ui grid center aligned">
    <a href="{{$url}}" class="ui facebook button">
        Login with facebook
    </a>
</div>



@stop