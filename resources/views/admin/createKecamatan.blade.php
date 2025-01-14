@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Tambah Kecamatan Baru</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('store.kecamatan') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Nama Kecamatan</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('kecamatan') ? ' is-invalid' : '' }}" name="kecamatan" value="{{ old('kecamatan') }}" required autofocus>

                                @if ($errors->has('kecamatan'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('kecamatan') }}</strong>
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
