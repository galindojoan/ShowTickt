@extends('layouts.master')

@section('title', 'Login')

@section('content')

<div class="promotorBody">
    @if(session('key'))
        <div class="button-container">
            <a href="{{ route('crear-esdeveniment') }}" class="custom-button">Crear Esdeveniment</a>
        </div>
    @endif
</div>
@endsection