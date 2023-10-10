<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Order;
use Illuminate\Http\Request;
use Ramsey\Uuid\Rfc4122\Validator;

class OrderController extends Controller
{
    public function ConfirmOrder( Request $request) {
        $user_id = auth()->user()->id;

        $basketExist = Basket::where([
            'user_id' => $user_id,
            'status' => 'onhold',
        ])
        ->with('basketProducts.product')
        ->first();

        //TODO: check payement
        //TODO: generate reference

        $order = Order::create([
            'reference' => uniqid(),
            'user_id' => $user_id,
            'basket_id' => $basketExist->id,
        ]);

        if($order) $basketExist->update([ 'status' => 'valid' ]);

        return sendResponse('order valid', 'order');
        
    }

    public function getPrevOrders( Request $request) {
        $user_id = auth()->user()->id;

        $orders = Order::where([
            'user_id' => $user_id,
        ])
        ->with('basket.basketProducts.product')
        ->get();

        return sendResponse($orders, 'orders');
    }
}
