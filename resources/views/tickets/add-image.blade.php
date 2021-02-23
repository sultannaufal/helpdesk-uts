@extends('layouts.app')
@section('title', 'Tambah Gambar')
@section('content')
@include('layouts.headers.main')
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0"> Tambah Gambar </h3>
                        </div>
                    </div>
                <div class="card-body">
                    <form action="{{ route('images.store', $ticket )}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-control-label" for="before">Before</label>
                                        <input type="file"
                                            class="form-control-file @error('before') is-invalid @enderror"
                                            id="before"
                                            name="before"
                                        >
                                        @error('before')
                                            <p class="invalid-feedback">{{ $errors->first('before') }}</p>
                                        @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label class="form-control-label" for="after">After</label>
                                        <input type="file"
                                            class="form-control-file @error('after') is-invalid @enderror"
                                            id="after"
                                            name="after"
                                        >
                                        @error('after')
                                            <p class="invalid-feedback">{{ $errors->first('after') }}</p>
                                        @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <button class="btn btn-primary">Kirim</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection