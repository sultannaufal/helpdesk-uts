@extends('layouts.app')

@section('title', 'Buat Komentar')

@section('content')
    <h1 class="my-md-5">Komentar Baru</h1>

    @include('comments._create-form', ['route' => route('comments.store', $ticket)])
@endsection
