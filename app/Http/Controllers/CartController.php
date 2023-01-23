<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        return view('pages.cart',[
            'carts' => Cart::with(['product.galleries','user'])
                        ->where('users_id',Auth::user()->id)
                        ->get()
        ]);
    }

    public function delete(Cart $cart){
        $cart->delete();

        return redirect()->route('cart');
    }

    public function success(){
        return view('pages.success');
    }
}
