<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product_gallery;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\AdminProductRequest;


class DashboardProductController extends Controller
{

    public function index(){
        return view('pages.dashboard-products',[
            'products' => Product::with(['galleries','category'])
                            ->where('users_id',Auth::user()->id)->get()
        ]);
    }

    public function detail(Product $product){
        $product->with(['galleries','user','category'])->get();
        $categories = Category::all();
        return view('pages.dashboard-product-detail',[
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function uploadGallery(Request $request){
        $data = $request->validate([
            'products_id' => 'required',
            'photos' => 'file|image|max:1024'
        ]);
        
        $data['photos'] = $request->file('photos')->store('assets/products','public');

        Product_gallery::create($data);

        return redirect()->route('dashboard-product-detail', $request->products_id);
    }

    public function deleteGallery(Product_gallery $productGallery,Request $request){
        $url = public_path('/storage/');
        unlink($url . $productGallery->photos);
        $productGallery->delete();

        return redirect()->route('dashboard-product-detail', $request->product_id);
    }

    public function create(){
        return view('pages.dashboard-product-create',[
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request){
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


        return redirect()->route('dashboard-product');
    }

    public function update(Product $product, Request $request){
        $data = $request->validate([
            "users_id" => "required|exists:users,id",
            "name" => "required|max:255",
            "price" => "required|integer",
            "categories_id" => "required|exists:categories,id",
            "description" => "required",
        ]);
        $data['slug'] = Str::slug($request->name);

        $product->update($data);

        return redirect()->route('dashboard-product');
    }

    public function delete(Product $product){
        foreach ($product->galleries as $gallery) {
            $url = public_path('/storage/');
            unlink($url . $gallery->photos);
            $gallery->delete();
        }

        $product->delete();
        return redirect()->route('dashboard-product');
    }
}
