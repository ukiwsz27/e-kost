@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Tambah Kelurahan {{ $kecamatan->kecamatan }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('store.kelurahan', $kecamatan->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="kelurahan" class="col-md-4 col-form-label text-md-right">Nama Kelurahan</label>

                            <div class="col-md-6">
                                <input id="kelurahan" type="text" class="form-control{{ $errors->has('kelurahan') ? ' is-invalid' : '' }}" name="kelurahan" value="{{ old('kelurahan') }}" required autofocus>

                                @if ($errors->has('kelurahan'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('kelurahan') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="kode_pos" class="col-md-4 col-form-label text-md-right">Kode Pos</label>

                            <div class="col-md-6">
                                <input id="kode_pos" type="text" class="form-control{{ $errors->has('kode_pos') ? ' is-invalid' : '' }}" name="kode_pos" value="{{ old('kode_pos') }}" required autofocus>

                                @if ($errors->has('kode_pos'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('kode_pos') }}</strong>
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
