@extends('layouts.app')
@section('title', 'Pengaduan')
@section('content')
    @if(Auth::user()->isClient())
        @include('layouts.headers.main')
    @else
        @include('layouts.headers.ticket-card')
    @endif
<div class="container-fluid mt--7">
    @cannot('create-ticket')
        <div class="alert alert-warning" role="alert">
            Hanya dapat membuat lima pengaduan dalam sehari.
        </div>
    @endcannot
    <div class="row">
        <div class="col">
            @can('manage')
                <div class="card shadow mb-4" data-turbo="false">
                    <div class="card-header">Filter</div>
                    <div class="card-body">
                        <form id="filter" action="" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="w-100">
                                    <label class="form-control-label" for="view">Terlihat</label>
                                        <select class="custom-select" name="view" autocomplete="off">
                                            <option value="all" @if(! request('view') || request('view') === 'all') selected @endif>Semua</option>
                                            <option value="yes" @if(request('view') === 'yes') selected @endif>Terlihat</option>
                                            <option value="no" @if(request('view') === 'no') selected @endif>Baru</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="w-100">
                                    <label class="form-control-label" for="status">Status</label>
                                        <select class="custom-select" name="status" autocomplete="off">
                                            <option value="all" @if(! request('status') || request('status') === 'all') selected @endif>Semua</option>
                                            <option value="closed" @if(request('status') === 'closed') selected @endif>Closed</option>
                                            <option value="active" @if(request('status') === 'active') selected @endif>Open</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="w-100">
                                    <label class="form-control-label" for="answer">Komentar Admin</label>
                                        <select class="custom-select" name="answer" autocomplete="off">
                                            <option value="all" @if(! request('answer') || request('answer') === 'all') selected @endif>Semua</option>
                                            <option value="yes" @if(request('answer') === 'yes') selected @endif>Ada</option>
                                            <option value="no" @if(request('answer') === 'no') selected @endif>Tidak Ada</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-secondary" form="filter" type="reset">Reset</button>
                        <button class="btn btn-primary" form="filter" type="submit">Apply</button>
                    </div>
                </div>
            @endcan
        </div>
    </div>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h3 class="mb-0"> Pengaduan </h3>
                            </div>
                            <div class="col">
                                <ul class="nav nav-pills justify-content-end">
                                    <li class="nav-item">
                                        @if(Auth::user()->isClient())
                                            @can('create-ticket')
                                                <a href="{{ route('tickets.create') }}" class="btn btn-primary">Buat Pengaduan Baru</a>
                                            @else
                                                <button class="btn btn-primary" disabled>Buat Pengaduan baru</button>
                                            @endcan
                                        @endif
                                    </li>
                            </div>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text"><strong>Success!</strong> {{session('success')}}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @if($tickets->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table tablesorter table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Judul</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Pada</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tickets as $ticket)
                                        <tr>
                                            <td><a href="{{ route('tickets.show', $ticket) }}">{{ $ticket->theme }}</a></td>
                                            <td>{{ $ticket->location['loc'] ?? 'Belum ditentukan' }}</td>
                                            <td>{{ $ticket->getStatusLabel() }}</td>
                                            <td>{{ $ticket->created_at->diffForHumans() }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        {{ $tickets->links() }}
                    </div>
                    @else
                        <p class="text-center">Tidak Ada Pengaduan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
