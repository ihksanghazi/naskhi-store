@extends('layouts.dashboard')

@section('title')
  Store Dashboard Product
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
	<div class="container-fluid">
		<div class="dashboard-heading">
			<h2 class="dashboard-title">My Products</h2>
			<p class="dashboard-subtitle">Manage it well and get money</p>
		</div>
		<div class="dashboard-content">
			<div class="row">
				<div class="col-6">
					<a
						href="{{ route('dashboard-product-create') }}"
						class="btn btn-success"
						>Add New Product</a
					>
				</div>
				<div class="col-6">
					<form action="{{ route('dashboard-product') }}">
						<div class="row">
							<div class="col-10" style="display: flex;align-items: center;">
								<input type="text" name="search" class="form-control" placeholder="Search">
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
						<form action="{{ route('dashboard-product-delete',$product->id) }}" method="post"
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
            <a href="{{ route('dashboard-product-detail',$product->id) }}" class="component-products d-block">
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
@endsection