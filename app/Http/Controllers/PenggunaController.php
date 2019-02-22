<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use View;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenggunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $response = array();
        $response['code'] = 200;

        $user = Auth::user();

        $user_list = [];

        $data = User::all();
        return view('pengguna.pengguna', compact('user','data','user_list'));
    }
}