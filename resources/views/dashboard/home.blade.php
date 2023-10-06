@extends('layouts.app')

@section('content')
    @if (session('type') == 'admin')
        @include('../home.admin')
    @elseif(session('type') == 'vas')
        @include('../home.vas')
    @elseif(session('type') == 'agent')
        @include('../home.agent')
    @endif
@endsection
