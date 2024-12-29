@extends('layouts.app')

@section('content')
@csrf
    <show-music token_crsf="{{ @csrf_token() }}" :music="{{$music}}"></show-music>
@endsection
