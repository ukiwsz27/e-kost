@extends('layouts.app')

@section('content')
<div class="container">
    @include('inc.messages')
    <h2>{{$kost->nama_kost}}</h2>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header text-center">
                    Informasi Kost
                </div>
                <div class="card-body text-center">
                    <h4 class="card-title">
                        Lokasi Kost
                    </h4>
                    <p class="card-text">
                        Alamat: {{ $kost->alamat_lengkap }}
                        <br/>
                        Kode Pos: {{$kelurahan->kode_pos}}
                        <br/>
                        Kelurahan: {{ $kelurahan->kelurahan }}
                        <br/>
                        Kecamatan: {{ $kecamatan->kecamatan}}
                    </p>
                </div>
                <div class="card-body">
                    <h4 class="card-title text-center">
                        Fitur Kost
                    </h4>
                    <p class="card-text">
                        <form method="post" action="{{ route('store.fasilitaskost', $kost->id) }}">
                            @csrf
                            <table class="table table-hover">
                                <tr>
                                    <?php $i = 1 ?>
                                    @foreach ($fasilitas as $dfas)
                                        <td>
                                            <label for="fasilitas{{ $i }}" class="form-check-label">
                                                <img src="/storage/image/icon/{{ $dfas->icon }}" width="35">
                                                {{ $dfas->nama_fasilitas }}
                                            </label>
                                        </td>
                                        <td width="10">
                                            <input type="checkbox" class="form-check-input" name="fasilitas[]"
                                            @foreach ($fasilitaskos as $dfaskos)
                                                @if ($dfaskos->fasilitas_id == $dfas->id)
                                                    checked
                                                @endif
                                            @endforeach
                                            value="{{ $dfas->id }}" id="fasilitas{{ $i }}">
                                        </td>
                                        @if ($i % 3 == 0)
                                            </tr>
                                            <tr>
                                        @endif
                                        <?php $i++ ?>
                                    @endforeach
                                </tr>
                            </table>
                            <input type="submit" class="btn btn-outline-primary float-right" value="Simpan">
                        </form>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header text-center">
                    Harga Kost
                </div>
                <div class="card-body text-center">
                    <h4 class="card-title">
                        @if(!empty($harga))
                        <ul class="list-group">
                            <li class="list-group-item">Rp. {{number_format($harga->hari)}} / hari</li>
                            <li class="list-group-item">Rp. {{number_format($harga->minggu)}} / minggu</li>
                            <li class="list-group-item">Rp. {{number_format($harga->bulan)}} / bulan</li>
                        </ul>
                        @else
                        Harga belum di masukkan
                        @endif
                    </h4>
                    <p class="card-text">
                        <a href="{{ route('create.harga', $kost->id) }}" class="form-control btn btn-outline-secondary">Isi harga</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
