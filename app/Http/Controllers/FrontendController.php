<?php

namespace App\Http\Controllers;

use App\Categories;
use App\order;
use App\orderitem;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

use App\Cart;


class FrontendController extends Controller
{
    public function getWelcome(){
        $cats=Categories::get();
        $posts=Post::orderBy('id','desc')->paginate(3);
        return view('welcome')->with(['cats'=>$cats,'posts'=>$posts]);
    }
    public  function getImage($file_name){
        $file=Storage::disk('posts')->get($file_name);
        return response($file)->header('content-type',".");
    }
    public function getPostsByCategory($cat_id){
        $cats=Categories::get();
        $posts=Post::where('category_id',$cat_id)->orderBy('id','desc')->paginate(3);
        return view('welcome')->with(['cats'=>$cats,'posts'=>$posts]);


    }
    public function getSearchPost(Request $request){
        $q=$_GET['q'];
        $cats=Categories::get();
        $posts=Post::where('item_name',"LIKE","%$q%")
            ->orWhere('price',"LIKE","%$q%")
            ->orderBy('id','desc')
            ->paginate(3);
        return view('welcome')->with(['cats'=>$cats,'posts'=>$posts]);


    }
    public function addToCart($id){
        $post=Post::whereId($id)->firstOrFail();
        $oldPost=Session::has('cart') ? Session::get('cart'):null;
        $cart=new  Cart($oldPost);
        $cart->add($post);
        Session::put('cart',$cart);
        return redirect()->back();
    }
    public function getShoppingCart(){
        return view('shopping');
    }

    public function getIncrease($id){
        $post=Post::whereId($id)->firstOrFail();
        $oldCart=Session::get('cart');
        $cart=new Cart($oldCart);
        $cart->increase($post);
        Session::put('cart',$cart);
        return redirect()->back();

    }

    public function getDecrease($id){
        $oldCart=Session::get('cart');
        $cart=new Cart($oldCart);
        $cart->decrease($id);
        if (count($cart->posts)<1){
            Session::forget('cart');

        }else{
            Session::put('cart',$cart);

        }

        return redirect()->back();

    }
    public function getCheckout(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required',
            'address' => 'required'
        ]);

        $order = new order();
        $order->user_id = Auth::id();
        $order->phone = $request['phone'];
        $order->address = $request['address'];
        $order->save();
        $items = Session::get('cart')->posts;
        foreach ($items as $i) {
            $order_item = new orderitem();
            $order_item->order_id = $order->id;
            $order_item->item_name = $i['post']['item_name'];
            $order_item->price = $i['post']['price'];
            $order_item->qty = $i['qty'];
            $order_item->amount = $i['amount'];
            $order_item->save();


        }

    Session::forget('cart');
        return redirect()->back()->with('info','The order item have been checkout');


    }}
