@extends('layouts.app')

@section('content')
    <div class="container">
        <music-list token_crsf="{{ @csrf_token() }}"></music-list>
    </div>
@endsection
