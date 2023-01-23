<?php

namespace App\Http\Controllers\Admin;
use App\Models\Category;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Admin\AdminCategoryRequest;

class AdminCategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if(request()->ajax()){
			$query = Category::query();
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
									<a class="dropdown-item" href="'.route('category.edit', $item->id).'">
										Sunting
									</a>
									<form action="'. route('category.destroy', $item->id).'" method="post">
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
			->editColumn('photo', function($item){
				return $item->photo ? '<img src="'. Storage::url($item->photo) .'" style="max-height: 40px;" />' : '';
			})
			->rawColumns(['action','photo'])
			->make();
		}
		return view('pages.admin.category.index');
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminCategoryRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['photo'] = $request->file('photo')->store('assets/category','public');

        Category::create($data);

        return redirect()->route('category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        // $item = Category::findOrFail($category);
        return view('pages.admin.category.edit',[
            'item' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(AdminCategoryRequest $request, Category $category)
    {
        // dd($category->id);
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);
        $data['photo'] = $request->file('photo')->store('assets/category','public');

        $category->update($data);

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('category.index');
    }
}
