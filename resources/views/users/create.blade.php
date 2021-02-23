@extends('layouts.app')
@section('title', 'Tambah User')
@section('content')
@include('layouts.headers.main')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0"> Tambah User </h3>
                        </div>
                    </div>
                <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                            <div class="form-group">
                                    <label class="form-control-label" for="input-password-confirmation">Nama</label>                                    <input class="form-control @error('name') is-invalid @enderror"
                                        type="text"
                                        name="name"
                                        required>
                                    @error('name')
                                        <p class="invalid-feedback">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </p>
                                    @enderror
                            </div>
                            <div class="form-group">
                                    <label class="form-control-label" for="email">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror"
                                        type="email"
                                        name="email"
                                        required>
                                    @error('name')
                                        <p class="invalid-feedback">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </p>
                                    @enderror
                            </div>
                            <div class="form-group">
                                    <label class="form-control-label" for="password">Password</label>
                                    <input class="form-control @error('password') is-invalid @enderror"
                                        type="password"
                                        name="password"
                                        required>
                                    @error('password')
                                        <p class="invalid-feedback">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </p>
                                    @enderror
                            </div>
                            <div class="form-group ">
                                <label class="form-control-label" for="password-confirmation">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                    <div class="text-center">
                        <button class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection