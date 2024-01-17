@extends('layouts.master')

@section('title', 'Tauler')

@section('content')

<div>
    @if(session('key'))
        <p>Tauller d'administració</p>
    @endif
</div>
@endsection