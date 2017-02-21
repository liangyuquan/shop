<?php

namespace App\Http\Controllers;
use App\Cart;
use App\CartItem;
use App\Product;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addItem ($productId){
        $uid = Auth::user()->id;
        $cart = Cart::where('user_id',$uid)->first();

        if(!$cart){
            $cart =  new Cart();
            $cart->user_id = $uid;
            $cart->save();
        }

        $cartItem  = new CartItem();
        $cartItem->product_id=$productId;
        $cartItem->cart_id= $cart->id;
        $cartItem->save();

        return redirect('/cart');

    }

    public function showCart(){
        $uid = Auth::user()->id;
        $cart = Cart::where('user_id',$uid)->first();

        if(!$cart){
            $cart =  new Cart();
            $cart->user_id = $uid;
            $cart->save();
        }
        $items = $cart->cartItems;
        $total = 0;
        if($items){
            foreach($items as $item){
                $total += $item->product->price;
                /*$product_data = Product::where('id',$item->product_id)->first();
                $total += $product_data->price;*/
            }
        }else{
            $items = [];
        }

        return view('cart.view',['items'=>$items,'total'=>$total]);
    }

    public function removeItem($id){

        CartItem::destroy($id);
        return redirect('/cart');
    }

}