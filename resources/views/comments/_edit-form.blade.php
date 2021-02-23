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
                           autocomplete="off" {{--- Firefox при перезагрузке страницы кеширует значение инпутов, тут это не нужно ---}}
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
            Komentar
            <textarea class="form-control @error('content') is-invalid @enderror"
                      name="content"
                      aria-label="Комментарий"
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
