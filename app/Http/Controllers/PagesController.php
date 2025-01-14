<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Kost;
use App\HargaKost;
use App\Photo;
use App\Fasilitas;
use App\Kelurahan;
use App\Kecamatan;
use App\FasilitasKost;
use App\User;
use App\Reservations;
use Auth;

class PagesController extends Controller
{
    public function index()
    {
        $kosts = DB::table('kosts')->get();
        $date = new Carbon;
        Carbon::setLocale('id');
        $i=0;
        foreach ($kosts as $kost) {
            $d = $date->parse($kost->updated_at);
            $kosts[$i]->differ = Carbon::now()->subSeconds($date->diffInSeconds($d))->diffForHumans();
            $user = User::find($kost->user_id);
            $kosts[$i]->phone = $user->phone;
            $kosts[$i]->email = $user->email;
            $i++;
        }
        $data = ['kosts' => $kosts];
        return view('index', $data);
    }

    public function show($id)
    {
        $kost = Kost::find($id);
        $harga = HargaKost::where('kost_id', $id)->first();
        $photos = Photo::where('kost_id', $id)->get();
        $kelurahan = Kelurahan::find($kost->kode_pos);
        $kecamatan = Kecamatan::find($kelurahan->kecamatan_id);
        $fasilitaskos = FasilitasKost::where('kost_id', $id)->get();
        $date = new Carbon;
        Carbon::setLocale('id');
        $i=0;
        foreach ($photos as $photo) {
            $d = $date->parse($photo->updated_at);
            $photos[$i]->differ = Carbon::now()->subSeconds($date->diffInSeconds($d))->diffForHumans();
            $i++;
        }

        $data = [
            'harga' => $harga,
            'kost' => $kost,
            'kelurahan' => $kelurahan,
            'kecamatan' => $kecamatan,
            'fasilitaskos' => $fasilitaskos,
            'photos' => $photos,
        ];
        return view('pages.kost', $data);
    }

    public function pesan($id)
    {
        $kost = Kost::find($id);
        return view('pages.pesan')->with('kost', $kost);
    }

    public function storePesanan(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|min:6|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|string|min:10|max:255',
            'pict' => 'image|nullable|max:2000',
        ]);

        if($request->hasFile('pict')){
            $fileNameWithExt = $request->file('pict')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('pict')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $request->file('pict')->storeAs('public/image/ktp', $fileNameToStore);
        } else {
            exit();
        }

        $reservations = new Reservations;
        $reservations->name = $request->input('name');
        $reservations->email = $request->input('email');
        $reservations->phone = $request->input('phone');
        $reservations->ktp = $fileNameToStore;
        $reservations->kosts_id = $id;
        $reservations->save();
        return redirect('/pages/'.$id)->with('success', 'Pesanan anda sudah masuk, silahkan tunggu pemilik kost menghubungi anda');
    }
}
