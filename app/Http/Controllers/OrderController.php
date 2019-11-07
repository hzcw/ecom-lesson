<?php

namespace App\Http\Controllers;

use App\order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function getOrders(Request $request){
        $myDate=$request['filter_by_date'];
        $myMonth=$request['filter_by_month'];
        if ($myDate){
            $today=date('Y-m-d',strtotime($myDate));

        }elseif ($myMonth){
            $today=$request['filter_by_month'];
        }
            else{
                $today=date('Y-m-d');

            }

        $orders=order::where('created_at',"LIKE","%$today%")
            ->OrderBy('id','desc')
            ->get();
        return view('post.orders')->with(['orders'=>$orders]);
    }

    public function getDeliver($id){

        $orders=order::whereId($id)->firstOrFail();

        $orders->status=1;
        $orders->update();

        return redirect()->back();
    }
}
