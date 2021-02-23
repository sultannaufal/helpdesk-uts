@extends('layouts.app')

@section('title', 'Edit Komentar')

@section('content')
    <h1 class="my-md-5">Edit Komentar</h1>

    @include('comments._edit-form', [
        'route' => route('comments.update', compact('ticket', 'comment')),
        'comment' => $comment,
    ])
@endsection
