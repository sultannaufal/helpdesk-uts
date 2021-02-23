@extends('layouts.app')
@section('title', 'Lokasi')
@section('content')
@include('layouts.headers.main')
<div class="container-fluid mt--7">
    <div class="card shadow">
        <div class="card-header border-0">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0"> Lokasi </h3>
                </div>
                <div class="col text-right">
                    <a href="{{ route('locations.create') }}" class="btn btn-primary">Tambah Lokasi</a>
                </div>
            </div>
            @if(session('success'))
                <div class="alert alert-success" style="hidden;">
                    {{ session('success') }}
                </div>
            @endif
        </div>

        @if($location->isNotEmpty())
        <div class="card-body">
        <div class="table-responsive">
            <table class="table tablesorter table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th>Lokasi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($location as $item)
                        <tr>
                            <td>{{ $item->loc }}</td>
                            
                            <td class="text-right"><li aria-haspopup="true" class="dropdown dropdown dropdown">
                                    <a role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-sm btn-icon-only text-light"><i class="fas fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <a href="{{ route('locations.edit', $item) }}" class="dropdown-item">Edit</a>
                                        <form action="{{ route('locations.destroy', $item) }}" method="POST" id="form">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Yakin hapus?')" class="dropdown-item">Hapus</button>
                                        </form>
                                    </ul>
                                </li>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $location->links() }}
        </div>
    </div>
        @else
            <p class="text-center">Tidak ada lokasi</p>
        @endif
</div>
@endsection