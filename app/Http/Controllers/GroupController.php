<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Group;
use App\Models\Grup;
use App\Models\Hobby;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{

    public $group;

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function secure($id){
        $group = Grup::find($id);

        if ($group){
            $this->group = $group;
            return true;
        }
        return false;
    }

    public function index()
    {

        $user = Auth::user();


        $groups = Grup::join('user_groups', 'user_groups.id_groups', '=', 'grup.id_grup')
            ->where('user_groups.id_user', $user->id)->select('grup.*');

        return view('groups.index', compact('user', 'groups'));
    }



    public function group($id){

        if (!$this->secure($id)) return redirect('/404');

        $user = Auth::user();

        $group = $this->group;

        $wall = [
            'new_post_group_id' => $group->id_group
        ];


        return view('groups.group', compact('user', 'group', 'wall'));
    }



    public function stats($id){


        if (!$this->secure($id)) return redirect('/404');

        $user = Auth::user();

        $group = $this->group;

        $country = $user->location->city->country;
        $city = $user->location->city;

        $all_countries = $group->countAllCountries();

        return view('groups.stats', compact('user', 'group', 'country', 'city', 'all_countries'));
    }



}
