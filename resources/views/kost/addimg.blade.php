@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Tambah gambar untuk {{ $kost->nama_kost }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('kost.saveimg') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" value="{{ $kost->id }}" name="id">
                        <div class="form-group row">
                            <label for="pict" class="col-md-4 col-form-label text-md-right">Gambar Gallery</label>

                            <div class="col-md-6">
                                <input id="pict" type="file" class="form-control{{ $errors->has('pict') ? ' is-invalid' : '' }}" name="photos[]" multiple>

                                @if ($errors->has('photos'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('photos') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Insert
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
