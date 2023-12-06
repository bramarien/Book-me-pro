<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FriendController extends Controller
{

    public function index(Request $request) {

        $users = User::all()->except((auth()->user()->id));

        if($request->has('search')) {
            $search = $request->get('search');
            foreach ($users as $key=>$user) {
                if (!strstr($user->name, $search))
                    unset($users[$key]);
            }
        }

        return view('friends.index', compact('users'));
    }

    public function friends(Request $request) {

        $users = auth()->user()->friends()->get();

        if($request->has('search')) {
            $search = $request->get('search');
            foreach ($users as $key=>$user) {
                if (!strstr($user->name, $search))
                    unset($users[$key]);
            }
        }

        return view('friends.friends', compact('users'));
    }

    public function followings(Request $request) {

        $users = auth()->user()->followings()->get();

        if($request->has('search')) {
            $search = $request->get('search');
            foreach ($users as $key=>$user) {
                if (!strstr($user->name, $search))
                    unset($users[$key]);
            }
        }

        return view('friends.followings', compact('users'));
    }

    public function followers(Request $request) {

        $users = auth()->user()->followers()->get();

        if($request->has('search')) {
            $search = $request->get('search');
            foreach ($users as $key=>$user) {
                if (!strstr($user->name, $search))
                    unset($users[$key]);
            }
        }

        return view('friends.followers', compact('users'));
    }
}
