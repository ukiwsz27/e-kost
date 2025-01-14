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
                        Alamat Lengkap: {{ $kost->alamat_lengkap }}
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
                        <table class="table table-hover">
                            <tr>
                                <?php $i = 1 ?>
                                @foreach ($fasilitaskos as $dfas)
                                    <td>
                                        <img src="/storage/image/icon/{{$dfas->fasilitas->icon}}" width="35" class="img-thumbnail">
                                        {{$dfas->fasilitas->nama_fasilitas}}
                                    </td>
                                    @if ($i % 4 == 0)
                                        </tr>
                                        <tr>
                                    @endif
                                    <?php $i++ ?>
                                @endforeach
                            </tr>
                        </table>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header text-center">
                    {{$kost->nama_kost}}
                </div>
                <img class="card-img-top" src="/storage/image/kost/{{$kost->photo}}" alt="{{$kost->nama_kost}}">
            </div>
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
                        <br/>
                        <a href="{{route('pesan.kost', $kost->id)}}" class="form-control btn btn-outline-primary">Pesan Kamar</a>
                        @else
                        Harga belum di masukkan
                        <br/>
                        <br/>
                        <button class="form-control btn btn-outline-primary disabled">Belum bisa pesan kamar</button>
                        @endif
                    </h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h2 class="mb-4">Gallery</h2>
        <div class="card-columns">
            @foreach ($photos as $photo)
                <div class="card mb-4 box-shadow">
                    <img class="card-img-top" src="/storage/image/gallery/{{ $photo->photo }}" alt="Card image cap">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $photo->differ }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
