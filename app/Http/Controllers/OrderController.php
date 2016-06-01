<?php
/**
 * Created by PhpStorm.
 * User: yifan
 * Date: 16-4-27
 * Time: 下午3:37
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Auth;

class OrderController extends Controller
{
    public function new_order(Request $request)
    {
        $res = $this->filter($request, [
            'oil_station' => 'required',
            'address' => 'required',
            'oil_type' => 'required',
            'price' => 'required',
            'cost' => 'required',
        ]);

        if(!$res)
            return $this->stdResponse(1);

        $id = Auth::user()->id;
        $order = new Order($request->all());
        $order->user_id =$id;
        $order->no = $id.time();
        $order->if_done = 'no';
        $order->save();
        return $this->stdResponse(0);
    }

    public function all_order()
    {
        return $this->stdResponse(0, Order::where('user_id', Auth::user()->id)->get());
    }

    public function return_pic($id)
    {
        include_once 'phpqrcode/phpqrcode.php';
        $order = Order::find($id);
        // return $order;
        \QRcode::png(json_encode($order));
    }
}
