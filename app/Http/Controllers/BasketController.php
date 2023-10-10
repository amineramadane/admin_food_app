<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\BasketProduct;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function index( Request $request) {
        $user_id = auth()->user()->id;

        $data = Basket::where('user_id', $user_id)->first();
        
        return sendResponse($data, 'basket');
    }


    public function addToBasket( Request $request) {
        $user_id = auth()->user()->id;
        $productId = $request->productId;
        $quantity = $request->quantity;

        $basketExist = Basket::where([
            'user_id' => $user_id,
            'status' => 'onhold',
        ])
        ->first();

        if(optional($basketExist)->id) {
            if($quantity <= 0) {
                BasketProduct::where([
                    'basket_id' => $basketExist->id,
                    'product_id' => $productId,
                ])->delete();
            } else {
                BasketProduct::updateOrInsert(
                    [
                        'basket_id' => $basketExist->id,
                        'product_id' => $productId,
                    ],
                    [
                        'quantity' => $quantity,
                    ]
                );
            } 
        }
        else if( $quantity > 0){

            $basket = Basket::create([
                'user_id' => $user_id,
                'status' => 'onhold',
            ]);

            BasketProduct::create(
                [
                    'basket_id' => $basket->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]
            );
        }


        $data = Basket::where([
            'user_id' => $user_id,
            'status' => 'onhold',
        ])
        ->with('basketProducts.product')
        ->first();
        
        return sendResponse($data, 'basket');
    }

    public function getBasketDetails( Request $request) {
        $user_id = auth()->user()->id;

        $data = Basket::where([
            'user_id' => $user_id,
            'status' => 'onhold',
        ])
        ->with('basketProducts.product')
        ->first();
        
        return sendResponse($data, 'basket');
    }
}
