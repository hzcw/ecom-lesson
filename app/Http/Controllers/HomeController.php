<?php

namespace App\Http\Controllers;

use App\Categories;
use App\order;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
   /* public function __construct()
    {
        $this->middleware('auth');
    }
*/
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->hasAnyrole(['Member'])){
            $orders=order::where('user_id',Auth::id())->get();
            return view('home')->with(['orders'=>$orders]);
        }elseif (Auth::user()->hasAnyRole(['Admin'])){
            $orders=order::get();
            $cats=Categories::get();
            $posts=Post::get();
            $users=User::get();
            return view('home')
                ->with(['orders'=>$orders,
                        'users'=>$users,
                        'posts'=>$posts,
                        'cats'=>$cats
                ]);

        }else{
            return redirect()->route('/');
        }

    }
}
