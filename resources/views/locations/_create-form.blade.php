<div class="container-fluid mt--7">
    <div class="card shadow">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="mb-0"> Tambah Data Lokasi </h3>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="d-block">
                                Lokasi
                                <input class="form-control @error('loc') is-invalid @enderror"
                                    type="text"
                                    value="{{ old('loc') }}"
                                    name="loc">
                                @error('loc')
                                    <p class="invalid-feedback">
                                        <strong>{{ $errors->first('loc') }}</strong>
                                    </p>
                                @enderror
                            </label>
                        </div>
                    </div>
                <div class="text-left">
                    <button class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
