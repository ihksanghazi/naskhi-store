<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index(){
        return view('pages.product',[
            'categories' => Category::all(),
            'products' => Product::with('galleries')->filters(request(['search','category']))->latest()->paginate(16)->withQueryString()
        ]);
    }

}
