@extends('layouts.app')

@section('content')
    @if (session('type') == 'admin')
        @include('dashboard.home.admin')
    @elseif(session('type') == 'vas')
        @include('dashboard.home.vas')
    @elseif(session('type') == 'agent')
        @include('dashboard.home.agent')
    @endif
@endsection
