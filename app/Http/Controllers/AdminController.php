<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Pagination\Paginator;
use App\User;
use App\Fasilitas;
use App\Kecamatan;
use App\Kelurahan;
use Auth;

class AdminController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if ($this->user->role == "user") {
                abort(404);
            }
            return $next($request);
        });
    }

    public function index()
    {
        $users = DB::table('users')->orderBy('role', 'asc')->orderBy('name', 'asc')->paginate(5, ['*'], 'users');
        $fasilitas = DB::table('fasilitas')->orderBy('nama_fasilitas', 'asc')->paginate(5, ['*'], 'fasilitas');
        $kecamatan = DB::table('kecamatan')->orderBy('kecamatan', 'asc')->paginate(5, ['*'], 'kecamatan');
        $kelurahan = DB::table('kelurahan')->orderBy('kode_pos', 'asc')->paginate(5, ['*'], 'kelurahan');
        return view('admin.index')->with(
            ['users' => $users,
            'fasilitas' => $fasilitas,
            'kecamatan' => $kecamatan,
            'kelurahan' => $kelurahan]
        );
    }

    public function updateRole($id)
    {
        $user = User::find($id);
        switch ($user->role) {
            case 'admin':
                $user->role = 'user';
                break;

            case 'user':
                $user->role = 'admin';
                break;

            default:
                $user->role = 'user';
                break;
        }
        $user->save();
        return redirect('/admin')->with('success', 'Akses berhasil diubah');
    }

    public function editUser($id)
    {
        $user = User::find($id);
        return view('admin.editUser')->with('user', $user);
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|min:6|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|min:10',
            'password' => 'nullable|max:255|min:7|confirmed',
        ]);

        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        if(null !== $request->input('password')){
            $user->password = Hash::make($request->input('password'));
        }
        $user->save();
        return redirect('/admin')->with('success', 'Data user berhasil dirubah');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/admin')->with('success', 'Data user berhasil dihapus');
    }

    public function createFasilitas()
    {
        return view('admin.createFasilitas');
    }

    public function storeFasilitas(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'icon' => 'required|image|max:10'
        ]);

        if($request->hasFile('icon')){
            $fileNameWithExt = $request->file('icon')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('icon')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $request->file('icon')->storeAs('public/image/icon', $fileNameToStore);
        }

        $fasilitas = new Fasilitas;
        $fasilitas->nama_fasilitas = $request->input('name');
        $fasilitas->icon = $fileNameToStore;
        $fasilitas->save();

        return redirect('/admin')->with('success', 'Fasilitas Berhasil disimpan');
    }

    public function deleteFasilitas($id)
    {
        $fasilitas = Fasilitas::find($id);
        Storage::delete('public/image/icon/'.$fasilitas->icon);
        $fasilitas->delete();
        return redirect('/admin')->with('success', 'Data fasilitas berhasil dihapus');
    }

    public function createKecamatan()
    {
        return view('admin.createKecamatan');
    }

    public function storeKecamatan(Request $request)
    {
        $request->validate([
            'kecamatan' => 'required|string|unique:kecamatan|min:5'
        ]);

        $kecamatan = new Kecamatan;
        $kecamatan->kecamatan = $request->input('kecamatan');
        $kecamatan->save();
        return redirect('/admin')->with('success', 'Kecamatan berhasil ditambahkan');
    }

    public function showKelurahan($id)
    {
        $kecamatan = Kecamatan::find($id);
        $kelurahan = Kelurahan::where('kecamatan_id', $id)->orderBy('kelurahan', 'asc')->paginate(5);
        return view('admin.kelurahan')->with(['kecamatan' => $kecamatan, 'kelurahan' => $kelurahan]);
    }

    public function createKelurahan($id)
    {
        $kecamatan = Kecamatan::find($id);
        return view('admin.createKelurahan')->with('kecamatan', $kecamatan);
    }

    public function storeKelurahan(Request $request, $id)
    {
        $request->validate([
            'kelurahan' => 'required|string|unique:kelurahan|min:4',
            'kode_pos' => 'required|numeric'
        ]);

        $kelurahan = new Kelurahan;
        $kelurahan->kode_pos = $request->input('kode_pos');
        $kelurahan->kelurahan = $request->input('kelurahan');
        $kelurahan->kecamatan_id = $id;
        $kelurahan->save();

        return redirect('/admin/' . $id . '/kelurahan')->with('success', 'Kelurahan baru berhasil di tambahkan');
    }

    public function destroyKelurahan(Request $request, $kode_pos)
    {
        $kelurahan = Kelurahan::find($kode_pos);
        $kelurahan->delete();

        $id = $request->input('kecamatan');
        return redirect('/admin/' . $id . '/kelurahan')->with('success', 'Kelurahan berhasil di hapus');
    }

    public function destroyKecamatan($id)
    {
        $kelurahan = Kecamatan::find($id);
        $kelurahan->delete();

        return redirect('/admin/')->with('success', 'Kecamatan berhasil di hapus');
    }
}
