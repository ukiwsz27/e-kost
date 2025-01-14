@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-default">
                <div class="card-header">Harga {{ $kosts->nama_kost }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('store.harga', $kosts->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="hari" class="col-md-4 col-form-label text-md-right">Harga Harian</label>

                            <div class="col-md-6">
                                <input id="hari" type="text" class="form-control{{ $errors->has('hari') ? ' is-invalid' : '' }}" name="hari" value="{{ old('hari') }}" required autofocus>

                                @if ($errors->has('hari'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('hari') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hari" class="col-md-4 col-form-label text-md-right">Harga Mingguan</label>

                            <div class="col-md-6">
                                <input id="minggu" type="text" class="form-control{{ $errors->has('minggu') ? ' is-invalid' : '' }}" name="minggu" value="{{ old('minggu') }}" required autofocus>

                                @if ($errors->has('minggu'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('minggu') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="bulan" class="col-md-4 col-form-label text-md-right">Harga Bulanan</label>

                            <div class="col-md-6">
                                <input id="bulan" type="text" class="form-control{{ $errors->has('bulan') ? ' is-invalid' : '' }}" name="bulan" value="{{ old('bulan') }}" required autofocus>

                                @if ($errors->has('bulan'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('bulan') }}</strong>
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
