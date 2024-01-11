@extends('layouts.master')

@section('title', 'crear')

@section('content')
<div>
    @if(session('key'))
        <p>Bienvenido, {{ session('key') }}</p>
    @endif
  </div>
@endsection