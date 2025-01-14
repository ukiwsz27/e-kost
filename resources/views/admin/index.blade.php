@extends('layouts.app')

@section('content')
<div class="container">
    @include('inc.messages')
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card text-center">
                <div class="card-header">User </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Hak Akses</th>
                                <th scope="col" colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ ( $users->currentPage() - 1 ) * $users->perPage() + $loop->iteration }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.updateRole', $user->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="PUT">
                                        <input type="submit" class="form-control btn btn-outline-secondary btn-sm" value="{{ $user->role }}">
                                    </form>
                                </td>
                                <td>
                                    <a href="/admin/{{ $user->id }}/editUser/" class="form-control btn btn-outline-success btn-sm float-right">Edit</a>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.deleteUser', $user->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input type="submit" class="form-control btn btn-outline-danger btn-sm float-left" value="Hapus">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $users->appends(['fasilitas' => $fasilitas->currentPage(), 'kecamatan' => $kecamatan->currentPage(), 'kelurahan' => $kelurahan->currentPage()])->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card text-center">
                <div class="card-header">Fasilitas</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">icon</th>
                                <th scope="col"><a href="/admin/create/fasilitas" class="form-control btn btn-outline-secondary btn-sm">Baru</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fasilitas as $dfas)
                            <tr>
                                <th scope="row">{{ ( $fasilitas->currentPage() - 1 ) * $fasilitas->perPage() + $loop->iteration }}</th>
                                <td>{{ $dfas->nama_fasilitas }}</td>
                                <td><img src="/storage/image/icon/{{ $dfas->icon }}" width="40"></td>
                                <td>
                                    <form method="POST" action="{{ route('delete.fasilitas', $dfas->id) }}">
                                        @csrf
                                        <input name="_method" type="hidden" value="DELETE">
                                        <input type="submit" class="form-control btn btn-outline-danger btn-sm float-left" value="Hapus">
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $fasilitas->appends(['users' => $users->currentPage(), 'kecamatan' => $kecamatan->currentPage(), 'kelurahan' => $kelurahan->currentPage()])->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header">Kecamatan di batam</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kecamatan</th>
                                <th scope="col" colspan="2"><a href="{{ route('create.kecamatan') }}" class="btn btn-outline-secondary btn-sm">Kecamatan Baru</a></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kecamatan as $dkec)
                                <tr>
                                    <th scope="row">{{ ( $kecamatan->currentPage() - 1 ) * $kecamatan->perPage() + $loop->iteration }}</th>
                                    <td>{{ $dkec->kecamatan }}</td>
                                    <td>
                                        <a href="{{ route('show.kecamatan', $dkec->id) }}" class="btn btn-outline-secondary btn-sm">Lihat Kelurahan</a>
                                    </td>
                                    <td>
                                        <form method="POST" action="{{ route('destroy.kecamatan', $dkec->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <input type="submit" class="form-control btn btn-outline-danger btn-sm float-left" value="Hapus">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $kecamatan->appends(['users' => $users->currentPage(), 'fasilitas' => $fasilitas->currentPage(), 'kelurahan' => $kelurahan->currentPage()])->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header">Kelurahan di batam</div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kelurahan</th>
                                <th scope="col">Kode Pos</th>
                                <th scope="col" colspan="1">Action</th>
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
                                            <input type="submit" class="form-control btn btn-outline-danger btn-sm float-left" value="Hapus">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $kelurahan->appends(['users' => $users->currentPage(), 'fasilitas' => $fasilitas->currentPage(), 'kecamatan' => $kecamatan->currentPage()])->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
