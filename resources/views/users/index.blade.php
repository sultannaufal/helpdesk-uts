@extends('layouts.app')
@section('title', 'User')
@section('content')
@include('layouts.headers.user-card')
<div class="container-fluid mt--7">
    <div class="card shadow bg-default">
        <div class="card-header border-0 bg-transparent">
            <div class="row align-items-center">
                <div class="col">
                <h3 class="mb-0 text-white"> User </h3>
                </div>
                <div class="col text-right">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">Tambah User</a>
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

        @if($users->isNotEmpty())
        <div class="card-body">
            <table class="table tablesorter table align-items-center table-flush table-dark">
                <thead class="thead-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="list">
                    @foreach($users as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td class="text-right"><li aria-haspopup="true" class="dropdown dropdown dropdown">
                                    <a role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-sm btn-icon-only text-light"><i class="fas fa-ellipsis-v"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <form action="{{ route('users.destroy', $item) }}" method="POST" id="form">
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
        <div class="card-footer bg-transparent">
            {{ $users->links() }}
        </div>
    </div>
        @else
            <p class="text-center">Tidak ada user</p>
        @endif
</div>
@endsection