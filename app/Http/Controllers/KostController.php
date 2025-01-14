<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UploadGallery;
use Carbon\Carbon;
use App\Kost;
use App\HargaKost;
use App\Photo;
use App\Fasilitas;
use App\Kelurahan;
use App\Kecamatan;
use App\FasilitasKost;
use App\Reservations;
use Auth;

class KostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $kosts = DB::table('kosts')->where('user_id', $user_id)->paginate(5);
        $reservations = Reservations::whereHas('kosts', function ($query) use ($user_id){
            $query->where('user_id', $user_id);
        })->paginate(5);
        $data = ['kosts' => $kosts,
        'reservations' => $reservations];
        return view('kost.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kode_pos = DB::table('kelurahan')->orderBy('kode_pos', 'asc')->get();
        return view('kost.create')->with('kode_pos', $kode_pos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'desc' => 'required|string|max:255',
            'addr' => 'required|string|max:255',
            'pict' => 'image|nullable|max:1999',
        ]);

        if($request->hasFile('pict')){
            $fileNameWithExt = $request->file('pict')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('pict')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $request->file('pict')->storeAs('public/image/kost', $fileNameToStore);
        } else {
            $fileNameToStore = "no_image.png";
        }

        $kost = new Kost;
        $kost->nama_kost = $request->input('name');
        $kost->deskripsi = $request->input('desc');
        $kost->alamat_lengkap = $request->input('addr');
        $kost->photo = $fileNameToStore;
        $kost->kode_pos = $request->input('kode_pos');
        $kost->user_id = auth::user()->id;
        $kost->save();

        return redirect('/kost')->with('success', 'Kost Berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kost = Kost::find($id);
        if(Auth::user()->id != $kost->user_id){
            return redirect('/kost')->with('error', 'Akses dilarang');
        }
        $harga = HargaKost::where('kost_id', $id)->first();
        $photos = Photo::where('kost_id', $id)->get();
        $fasilitas = DB::table('fasilitas')->get();
        $kelurahan = Kelurahan::find($kost->kode_pos);
        $kecamatan = Kecamatan::find($kelurahan->kecamatan_id);
        $fasilitaskos = FasilitasKost::where('kost_id', $id)->get();

        $data = [
            'harga' => $harga,
            'kost' => $kost,
            'fasilitas' => $fasilitas,
            'kelurahan' => $kelurahan,
            'kecamatan' => $kecamatan,
            'fasilitaskos' => $fasilitaskos
        ];
        return view('kost.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kost = Kost::find($id);
        if(auth::user()->id != $kost->user_id){
            return redirect('/kost')->with('error', 'Akses dilarang');
        }
        $kode_pos = DB::table('kelurahan')->orderBy('kode_pos', 'asc')->get();
        return view('kost.edit')->with(['kost' => $kost, 'kode_pos' => $kode_pos]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'desc' => 'required|string|max:255',
            'addr' => 'required|string|max:255',
            'pict' => 'image|nullable|max:1999',
            'kode_pos' => 'required|string'
        ]);

        if($request->hasFile('pict')){
            $fileNameWithExt = $request->file('pict')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('pict')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $request->file('pict')->storeAs('public/image/kost', $fileNameToStore);
        }

        $kost = Kost::find($id);
        if(auth::user()->id != $kost->user_id){
            return redirect('/kost')->with('error', 'Akses dilarang');
        }
        $kost->nama_kost = $request->input('name');
        $kost->deskripsi = $request->input('desc');
        $kost->alamat_lengkap = $request->input('addr');
        $kost->kode_pos = $request->input('kode_pos');
        if($request->hasFile('pict') && $kost->photo != 'no_image.png'){
            Storage::delete('public/image/kost/'.$kost->photo);
            $kost->photo = $fileNameToStore;
        }
        $kost->save();

        return redirect('/kost')->with('success', 'Kost Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kost = Kost::find($id);

        if(auth::user()->id != $kost->user_id){
            return redirect('/kost')->with('error', 'Akses dilarang');
        }

        if($kost->photo != 'no_image.png'){
            Storage::delete('public/image/kost/'.$kost->photo);
        }

        $kost->delete();
        return redirect('/kost')->with('success', 'Kost dihapus');
    }

    public function addImg($id)
    {
        $kost = Kost::find($id);
        return view('kost.addimg')->with('kost', $kost);
    }

    public function saveImg(UploadGallery $request)
    {
        //$kost = Kost::create($request->all());
        foreach ($request->photos as $photo) {
            //$filename = $photo->store('photos');
            $fileNameWithExt = $photo->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $photo->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $photo->storeAs('public/image/gallery', $fileNameToStore);
            Photo::create([
                'photo' => $fileNameToStore,
                'kost_id' => $request->id,
            ]);
        }
        return redirect('/kost/gallery/'. $request->id)->with('success', 'Photo berhasil ditambah');
    }

    public function gallery($id)
    {
        $kost = Kost::find($id);
        if(Auth::user()->id != $kost->user_id){
            return redirect('/kost')->with('error', 'Akses dilarang');
        }
        $photos = Photo::where('kost_id', $id)->get();

        $date = new Carbon;
        Carbon::setLocale('id');
        $i=0;
        foreach ($photos as $photo) {
            $d = $date->parse($photo->updated_at);
            $photos[$i]->differ = Carbon::now()->subSeconds($date->diffInSeconds($d))->diffForHumans();
            $i++;
        }

        $data = [
            'kost' => $kost,
            'photos' => $photos,
        ];
        return view('kost.gallery', $data);
    }

    public function destroyImg($kost, $id)
    {
        $photos = Photo::find($id);
        Storage::delete('public/image/gallery/'.$photos->photo);
        $photos->delete();

        return redirect('/kost/gallery/'. $kost)->with('success', 'Gambar di gallery dihapus');
    }

    public function createHarga($id)
    {
        $kosts = Kost::find($id);
        $harga = DB::table('harga_kost')->where('kost_id', $kosts->id)->first();
        return view('kost.createHarga')->with(['kosts' => $kosts, 'harga' => $harga]);
    }

    public function storeHarga(Request $request, $id)
    {
        $this->validate($request, [
            'hari' => 'required|max:1000000|numeric',
            'minggu' => 'required|max:7000000|numeric',
            'bulan' => 'required|max:30000000|numeric',
        ]);

        $hargakos = HargaKost::where('kost_id', $id);
        $hargakos->delete();
        $harga = new HargaKost;
        $harga->hari = $request->input('hari');
        $harga->bulan = $request->input('bulan');
        $harga->minggu = $request->input('minggu');
        $harga->kost_id = $id;
        $harga->save();

        return redirect('/kost/'. $id)->with('success', 'Harga telah di perbarui');
    }

    public function storeFasilitas(Request $request, $id)
    {
        $fasilitas = $request->input('fasilitas');
        $faskos = FasilitasKost::where('kost_id', $id);
        $faskos->delete();
        if(!empty($fasilitas)){
            foreach($fasilitas as $dfas){
                $fkost = new FasilitasKost;
                $fkost->fasilitas_id = $dfas;
                $fkost->kost_id = $id;
                $fkost->save();
            }
        }
        return redirect('/kost/'. $id)->with('success', 'Fasilitas telah di perbarui');
    }
}
