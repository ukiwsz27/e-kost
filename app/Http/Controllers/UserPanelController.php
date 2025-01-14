<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class UserPanelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user_id = auth::user()->id;
        $kosts = DB::table('kosts')->where('user_id', $user_id)->get();
        $data = ['kosts' => $kosts];
        return view('pages.panel', $data);
    }
}
