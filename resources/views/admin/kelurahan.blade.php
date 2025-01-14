@extends('layouts.app')

@section('content')
<div class="container">
    @include('inc.messages')
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card text-center">
                <div class="card-header">{{ $kecamatan->kecamatan }}</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Kelurahan</th>
                                <th scope="col">Kode Pos</th>
                                <th scope="col"><a href="{{ route('create.kelurahan', $kecamatan->id) }}" class="btn btn-outline-secondary btn-sm">Tambah Kelurahan</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kelurahan as $dkel)
                                <tr>
                                    <th scope="row">{{ ( $kelurahan->currentPage() - 1 ) * $kelurahan->perPage() + $loop->iteration }}</th>
                                    <td>{{ $dkel->kelurahan }}</td>
                                    <td>{{ $dkel->kode_pos }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('destroy.kelurahan', $dkel->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input name="kecamatan" type="hidden" value="{{$kecamatan->id}}">
                                            <input type="submit" class="btn btn-outline-danger btn-sm" value="Hapus">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $kelurahan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
