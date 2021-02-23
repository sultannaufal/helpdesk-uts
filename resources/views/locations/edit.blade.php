@extends('layouts.app')

@section('title', 'Edit Lokasi')

@section('content')
@include('layouts.headers.main')

    @include('locations._edit-form', [
        'route' => route('locations.update', $location),
    ])
@endsection
