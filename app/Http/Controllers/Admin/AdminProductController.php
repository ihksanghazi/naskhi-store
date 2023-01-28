<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Product_gallery;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\AdminProductRequest;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return view('pages.admin.product.index',[
            'products' => Product::with(['galleries','category'])
                            ->Filters(request(['search','user']))->paginate(8)->withQueryString(),
            'users' => User::all()
        
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('pages.admin.product.create',[
            'users' => User::all(),
            'categories' => Category::all(),
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            "users_id" => "required|exists:users,id",
            "name" => "required|max:255",
            "price" => "required|integer",
            "categories_id" => "required|exists:categories,id",
            "description" => "required",
            "photo.*" => "required|file|image|max:1024"
        ]);
        
        $data['slug'] = Str::slug($request->name);
        $product = Product::create($data);

        if(isset($data['photo'])){
            $files = $request->file('photo');
            foreach ($files as $file) {
                $gallery = [
                    'products_id' => $product->id,
                    'photos' => $file->store('assets/products','public')
                ];    
                Product_gallery::create($gallery);
            }
        }

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product->with(['galleries','user','category'])->get();
        // return dd($product);
        return view('pages.admin.product.edit',[
            'product' => $product,
            'users' => User::all(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            "users_id" => "required|exists:users,id",
            "name" => "required|max:255",
            "price" => "required|integer",
            "categories_id" => "required|exists:categories,id",
            "description" => "required",
        ]);
        $data['slug'] = Str::slug($request->name);

        $product->update($data);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        foreach ($product->galleries as $gallery) {
            $url = public_path('/storage/');
            unlink($url . $gallery->photos);
            $gallery->delete();
        }

        $product->delete();
        return redirect()->route('product.index');
    }
}
