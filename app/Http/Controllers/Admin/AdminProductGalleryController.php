<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\AdminProduct_galleryRequest;
use App\Models\Product_gallery;

class AdminProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
			$query = Product_gallery::with(['product']);
			return DataTables::of($query)
			->addColumn('action', function ($item){
				return '
						<div class="btn-group">
							<div class="dropdown">
								<button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                                    type="button"
									data-toggle="dropdown">
										Aksi
								</button>
								<div class="dropdown-menu">
									<form action="'. route('product-gallery.destroy', $item->id).'" method="post">
										'.method_field('delete').csrf_field().'
										<button type="submit" class="dropdown-item text-danger">
											Hapus
										</button>
									</form>
								</div>
							</div>
						</div>
				';
			})
            ->editColumn('photos',function($item){
                return $item->photos ? '<img src="'. Storage::url($item->photos) .'" style="max-height:80px" />' : '';
            })
			->rawColumns(['action','photos'])
			->make();
		}
		return view('pages.admin.product_gallery.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('pages.admin.product_gallery.create',[
            'products' => Product::all(),
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminProduct_galleryRequest $request)
    {
        $data = $request->all();

        $data['photos'] = $request->file('photos')->store('assets/products','public');

        Product_gallery::create($data);

        return redirect()->route('product-gallery.index');
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
      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(AdminProduct_galleryRequest $request, Product $product)
    {
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product_gallery $productGallery)
    {
        $productGallery->delete();

        return redirect()->route('product-gallery.index');
    }
}
