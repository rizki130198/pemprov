<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventComment;
use Auth;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Response;
use Session;
use View;
class EventController extends Controller
{    
	public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
	{
		$user = Auth::user();

		$user_list = $user->messagePeopleList();


		$events = DB::table('events')->get();
		return view('events.index', compact('user', 'events','user_list'));
	}
}
