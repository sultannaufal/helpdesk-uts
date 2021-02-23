<div class="container-fluid mt--7">
    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0"> Edit Pengaduan </h3>
                        </div>
                    </div>
                <div class="card-body">
                    <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="d-block">
                                    Judul
                                    <input class="form-control @error('theme') is-invalid @enderror"
                                        type="text"
                                        value="{{ old('theme', $ticket->theme) }}"
                                        name="theme">

                                    @error('theme')
                                        <p class="invalid-feedback">{{ $errors->first('theme') }}</p>
                                    @enderror
                                </label>
                            </div>

                            <div class="form-group col-md-6">
                                @if($ticket->attachment)
                                    <div id="use-old-attachment-condition"
                                        class="custom-control custom-checkbox"
                                        data-condition="true"
                                    >
                                        <input type="checkbox"
                                            class="custom-control-input"
                                            id="use_old_attachment"
                                            name="use_old_attachment"
                                            autocomplete="off"
                                            checked>
                                        <label class="custom-control-label" for="use_old_attachment">Gunakan File Lama</label>
                                    </div>
                                @endif

                                <div id="attachment-group" class="custom-file" @if(! $ticket->attachment) style="margin-top: 23px;" @endif>
                                    <input type="file"
                                        class="custom-file-input @error('attachment') is-invalid @enderror"
                                        id="attachment"
                                        name="attachment"
                                    >
                                    <label class="custom-file-label" for="attachment">Pilih FIle</label>

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
                                    <option value="{{ $ticket->location_id }}" selected>{{ $ticket->location_id->loc ?? 'Pilih' }}</option>
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
                                        aria-label="Detail"
                                >{{ old('content', $ticket->content) }}</textarea>

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
