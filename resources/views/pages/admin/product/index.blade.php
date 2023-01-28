@extends('layouts.admin')

@section('title')
  Product
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
	<div class="container-fluid">
		<div class="dashboard-heading">
			<h2 class="dashboard-title">Products</h2>
			<p class="dashboard-subtitle">List of Products</p>
		</div>
		<div class="dashboard-content">
			<div class="row">
				<div class="col-5">
					<a
						href="{{ route('product.create') }}"
						class="btn btn-success"
						>Add New Product</a
					>
				</div>
				<div class="col-7">
					<form action="{{ route('product.index') }}">
            @if ( request('user') )
              <input type="hidden" name="user" value="{{ request('user') }}">
            @elseif( request('search') )
              <input type="hidden" name="search" value="{{ request('search') }}">
            @endif
						<div class="row">
              <div class="col-md-4 mb-1" style="display: flex;align-items: center;">
                <select name="user" class="form-control" onchange="form.submit()">
                  @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                  @endforeach
                </select>
              </div>
							<div class="col-md-8 mb-1" style="display: flex;align-items: center;">
								<input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}">
								<button type="submit" class="btn btn-outline-dark">Search</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row mt-4">
				@foreach ($products as $product)
					@php
						$incrementProduct=0;
					@endphp
					<div
            class="col-6 col-md-4 col-lg-3"
            data-aos="fade-up"
            data-aos-delay="{{ $incrementProduct+=100 }}"
						style="position: relative;padding-top:10px"
          >
						<form action="{{ route('product.destroy',$product->id) }}" method="post"
							style="position: absolute;top:0;right:0;z-index:2">
							@csrf
							@method('delete')
							<input type="hidden" name="product_id" value="{{ $product->id }}">
							<button type="submit" style="background: none;border:none" >
								<img
									src="/images/icon-delete.svg"
								/>
							</button>
						</form>
            <a href="{{ route('product.edit',$product->id) }}" class="component-products d-block">
              <div class="products-thumbnail">
                <div
                  class="products-image" 
                  style="
                    @if($product->galleries->count())
                      background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                    @else
                      background-image: url('{{ Storage::url('assets/products/nophoto.png') }}')
                    @endif
                  "
                ></div>
              </div>
							<div class="product-category">{{ $product->category->name }}</div>
              <div class="products-text">{{ $product->name }}</div>
              <div class="products-price">Rp. {{ number_format($product->price) }}</div>
            </a>
          </div> 

				@endforeach
			</div>
			<div class="row">
        <div class="col-12 mt-4">
          {{ $products->links() }}
        </div>
      </div>
		</div>
	</div>
</div>




{{-- <div class="section-content section-dashboard-home" data-aos="fade-up">
  <div class="container-fluid">
    <div class="dashboard-heading">
      <h2 class="dashboard-title">Product</h2>
      <p class="dashboard-subtitle">List of Product</p>
    </div>
    <div class="dashboard-content">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <a href="{{ route('product.create') }}" class="btn btn-primary mb-3">
                Add New Product
              </a>
              <div class="table-responsive">
                <table class="table table-hover scroll-horizontal-vertical w-100" id="crudTable">
                  <thead>
                    <tr>
                      <th>Id</th>
                      <th>Name</th>
                      <th>Pemilik</th>
                      <th>Category</th>
                      <th>Price</th>
                      <th>Aksi</th>
                    </tr>
                    <tbody>
                    </tbody>
                  </thead>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> --}}
@endsection