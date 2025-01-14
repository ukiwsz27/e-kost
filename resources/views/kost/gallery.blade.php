@extends('layouts.app')

@section('content')
<div class="container">
    @include('inc.messages')
    <h2>{{$kost->nama_kost}} <a href="{{ route('create.img', $kost->id) }}" class="btn btn-outline-secondary float-right">Tambah Gambar</a></h2>
    <div class="row">
        <div class="card-columns">
            @foreach ($photos as $photo)
                <div class="card mb-4 box-shadow">
                    <img class="card-img-top" src="/storage/image/gallery/{{ $photo->photo }}" alt="Card image cap">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <form method="POST" action="{{ route('destroy.img', [$kost->id, $photo->id]) }}">
                                    @csrf
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input type="submit" class="btn btn-sm btn-outline-secondary" value="Hapus">
                                </form>
                            </div>
                            <small class="text-muted">{{ $photo->differ }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
