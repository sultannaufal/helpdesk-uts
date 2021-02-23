@extends('layouts.app')

@section('title', 'Tambah Lokasi')

@section('content')
@include('layouts.headers.main')

    @include('locations._create-form', [
        'route' => route('locations.store'),
    ])
@endsection