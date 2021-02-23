@extends('layouts.app')
@section('title', 'Buat Pengaduan')
@section('content')
@include('layouts.headers.main')
    @include('tickets._create-form', [
        'route' => route('tickets.store'),
    ])
@endsection

