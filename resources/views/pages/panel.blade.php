@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Kost yang anda miliki <a href="/kost/create" class="btn btn-primary float-right">Tambah Baru</a></h2>
    <div class="row">
        @foreach($kosts as $kost)
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header text-center">
                    <ul class="nav nav-pills card-header-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Edit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Hapus</a>
                        </li>
                    </ul>
                </div>
                <img class="card-img-top" src="http://ekost.dev/image/kost/0464a5f7c648b72ce3b6aac37844ca2c.jpg" alt="Card image cap">
                <div class="card-body text-center">
                    <h4 class="card-title">{{$kost->nama_kost}}</h2>
                    <hr>
                    <h5 class="card-title">Deskripsi Kost</h3>
                    {{$kost->deskripsi}}
                    <br/>
                    <hr>
                    <h5 class="card-title">Alamat Lengkap</h3>
                    {{$kost->alamat_lengkap}}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
