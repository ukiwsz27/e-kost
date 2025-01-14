@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Kost di batam</h2>
    <br/>
    <div class="row">
        <div class="card-columns">
            @foreach($kosts as $kost)
                <div class="card text-center">
                    <div class="card-header">{{$kost->nama_kost}}</div>
                    <a href="{{route('get.kost', $kost->id)}}"><img class="card-img-top" src="/storage/image/kost/{{$kost->photo}}" alt="{{$kost->nama_kost}}"></a>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <h3 class="card-title">Deskripsi Kost</h3>
                            <p class="card-text">{{$kost->deskripsi}}</p>
                        </li>
                        <li class="list-group-item">
                            <h3 class="card-title">Alamat Lengkap</h3>
                            <p class="card-text">{{$kost->alamat_lengkap}}</p>
                        </li>
                    </ul>
                    <div class="card-body">
                        <h4 class="card-title">Informasi Kontak</h4>
                        <p class="card-text">Telpon: {{$kost->phone}}</p>
                        <p class="card-text">Email: <a href="mailto:{{$kost->email}}">{{$kost->email}}</a></p>
                    </div>
                    <div class="card-footer text-muted">
                        diperbarui {{$kost->differ}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
