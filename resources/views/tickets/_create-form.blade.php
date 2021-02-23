<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0"> Buat Pengaduan </h3>
                        </div>
                    </div>
                <div class="card-body">
                    <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="d-block">
                                    Judul
                                    <input class="form-control @error('theme') is-invalid @enderror"
                                        type="text"
                                        value="{{ old('theme') }}"
                                        name="theme">
                                    @error('theme')
                                        <p class="invalid-feedback">
                                            <strong>{{ $errors->first('theme') }}</strong>
                                        </p>
                                    @enderror
                                </label>
                            </div>

                            <div class="form-group col-md-6" style="margin-top:23px;">
                                <div class="custom-file">
                                    <input type="file"
                                        class="custom-file-input @error('attachment') is-invalid @enderror"
                                        id="attachment"
                                        name="attachment"
                                    >
                                    <label class="custom-file-label" for="attachment">Upload gambar</label>

                                    @error('attachment')
                                        <p class="invalid-feedback">{{ $errors->first('attachment') }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="d-block">
                                Lokasi
                                <select class="browser-default custom-select @error('location_id') is-invalid @enderror" 
                                        name="location_id" 
                                        id="location_id"
                                    >
                                    <option selected>Pilih gedung</option>
                                    @foreach ($locations as $item)
                                        <option value="{{ $item->id }}">{{ $item->loc }}</option>
                                    @endforeach
                                </select>
                                
                                @error('location_id')
                                    <p class="invalid-feedback">{{ $errors->first('location_id') }}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="d-block">
                                Detail
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                        name="content"
                                >{{ old('content') }}</textarea>

                                @error('content')
                                    <p class="invalid-feedback">{{ $errors->first('content') }}</p>
                                @enderror
                            </label>
                        </div>

                        <div class="text-right mt-4">
                            <button class="btn btn-primary">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
