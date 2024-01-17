@extends('layouts.master')

@section('title', 'Home')

@section('content')

<div>
    @if(session('key'))
        <div class="button-container">
            <a href="{{ route('crear-esdeveniment') }}" class="custom-button">Crear Esdeveniment</a>
        </div>
    @endif
</div>
@endsection