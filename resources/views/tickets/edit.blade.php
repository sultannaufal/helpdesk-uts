@extends('layouts.app')
@section('title', 'Edit Pengaduan')
@section('content')
@include('layouts.headers.main')
@include('tickets._edit-form', [
    'route' => route('tickets.update', $ticket),
])
@endsection
