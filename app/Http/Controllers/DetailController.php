<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    public function index(Product $product,$id){
        return view('pages.detail',[
            'product' => $product->with(['galleries','user'])->where('id',$id)->firstOrFail()
        ]);
    }

    public function add(Request $request,$id){
        $data=[
            'products_id' => $id,
            'users_id' => Auth::user()->id
        ];

        Cart::create($data);

        return redirect()->route('cart');
    }
}
