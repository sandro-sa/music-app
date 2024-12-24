@extends('layouts.app')

@section('content')
@csrf
<music-list token_crsf="{{ @csrf_token() }}"></music-list>

@endsection
