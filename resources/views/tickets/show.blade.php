@extends('layouts.app')
@section('title', 'Pengaduan')
@section('content')
@include('layouts.headers.main')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="card shadow border-0">
            <div class="card-header">
                <div class="row align-items-center">
                    <h1 class="ticket__theme col-md-7 my-5">
                        {{ $ticket->theme }}

                        @if($ticket->isInProgress())
                            <span class="badge badge-primary">{{ $ticket->getStatusLabel() }}</span>
                        @elseif($ticket->isClosed())
                            <span class="badge badge-success">{{ $ticket->getStatusLabel() }}</span>
                        @elseif($ticket->isNew())
                            <span class="badge badge-warning">{{ $ticket->getStatusLabel() }}</span>
                        @endif
                    </h1>

                    <div class="col-md-5 d-flex flex-wrap justify-content-end">
                        @can('manage')
                            @if(! $ticket->isClosed() && ! $ticket->hasManager())
                                <form action="{{ route('tickets.assign', $ticket) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-primary ml-1 mb-1">Tangani</button>
                                </form>
                            @endif
                        @endcan
                        @can('edit-ticket', $ticket)
                            @if(! $ticket->isClosed())
                                <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-secondary ml-1 mb-1">Edit</a>

                                <form action="{{ route('tickets.close', $ticket) }}" method="POST">
                                    @csrf
                                    <button onclick="return confirm('Yakin ubah status?')" class="btn btn-warning ml-1 mb-1">Close</button>
                                </form>
                            @else
                                @if(! $ticket->hasImage())
                                    <a class="btn btn-success ml-1 mb-1" href="{{ route('image.add', compact('ticket')) }}">
                                        Tambah Gambar Kondisi
                                    </a>
                                @endif                                
                            @endif

                            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger ml-1 mb-1">Hapus</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-5">
                    <div class="mb-4">{{ $ticket->content }}</div>

                    <div class="d-md-flex justify-content-md-between">
                        <div class="attachment">
                            @if ($ticket->attachment)
                                <a href="{{ asset('storage/' . $ticket->attachment) }}"
                                class="btn btn-outline-secondary"
                                target="_blank"
                                rel="nofollow noopener"
                                >Lihat File Terlampir</a>
                            @else
                                <p class="text-muted">Tidak ada file terlampir</p>
                            @endif
                        </div>
                            <p class="text-muted">Lokasi: {{ $ticket->location->loc ?? 'Belum ditentukan' }}</p>
                        @if($ticket->hasManager())
                            <p class="text-muted">Pengurus: {{ $ticket->manager->name }}</p>
                        @else
                            <p class="text-muted">Belum ada pengurus</p>
                        @endif
                    </div>
                </div>
            </div>
            @if($ticket->hasImage())
            <div class="card-footer text-left">
            <div class="col d-flex flex-wrap justify-content-top">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                Lihat Kondisi
                </button>
                @if(! Auth::user()->isClient())
                <form action="{{ route('images.destroy', compact('ticket', 'image')) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger ml-1 mb-1">Hapus Gambar</button>
                </form>
                @endif
            </div>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Gambar Kondisi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="nav-wrapper">
                                <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab" href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1" aria-selected="true"><i class="ni ni-bold-left mr-2"></i>Sebelum</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab" href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2" aria-selected="false">Sesudah <i class="ni ni-bold-right mr-2"></i></a>
                                    </li>
                                </ul>
                            </div>
                            
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel" aria-labelledby="tabs-icons-text-1-tab">
                                        <img class="img-fluid" src="{{ asset('storage/' . $ticket->image->before) }}" width="auto">
                                    </div>
                                    <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel" aria-labelledby="tabs-icons-text-2-tab">
                                        <img class="img-fluid" src="{{ asset('storage/' . $ticket->image->after) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
        

        <hr>

        <section class="mt-5">
            <h2 class="h4 mb-4">Komentar</h2>

            <ul class="list-unstyled mb-4">
                @forelse($comments as $comment)
                    <li class="card mb-3">
                        <div class="card-header d-md-flex justify-content-between">
                            <div>
                                <span class="h5">{{ $comment->user->name ?? '' }}</span>
                                @if($comment->user->isManager())
                                    <span class="badge badge-info">Admin</span>
                                @endif
                                <span style="display:inline-block;width:30px;"></span>
                                <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="d-flex">
                                @can('edit-comment', [$ticket, $comment])
                                    <a href="{{ route('comments.edit', compact('ticket', 'comment')) }}"
                                    class="btn btn-sm btn-secondary mr-1"
                                    >
                                        Edit
                                    </a>

                                    <form action="{{ route('comments.destroy', compact('ticket', 'comment')) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            <h3 class="h5">{{ $comment->theme }}</h3>
                            <div>
                                {{ $comment->content }}
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                @if($comment->attachment)
                                    <a href="{{ asset('storage/' . $ticket->attachment) }}"
                                    class="btn btn-sm btn-outline-secondary mt-3"
                                    target="_blank"
                                    rel="nofollow noopener"
                                    >Lihat File Terlampir</a>
                                @endif
                                @if($comment->updated_at->notEqualTo($comment->created_at))
                                    <small class="text-muted">Diedit {{ $comment->updated_at->diffForHumans() }}</small>
                                @endif
                            </div>
                        </div>
                    </li>
                @empty
                    <li>Tidak ada komentar</li>
                @endforelse
            </ul>

            @if($comments->isNotEmpty())
                {{ $comments->links() }}
            @endif

            @if(! $ticket->isClosed())
                <a href="{{ route('comments.create', $ticket) }}" class="btn btn-primary">Tambah komentar</a>
            @endif
        </section>
    
</div>
@endsection
