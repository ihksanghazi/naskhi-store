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
				<div class="col-12">
					<a
						href="{{ route('dashboard-product-create') }}"
						class="btn btn-success"
						>Add New Product</a
					>
				</div>
			</div>
			<div class="row mt-4">
				@foreach ($products as $product)
					{{-- <div class="col-12 col-sm-6 col-md-4 col-lg-3">
						<a
							href="{{ route('dashboard-product-detail',$product->id) }}"
							class="card card-dashboard-product d-block"
						>
							<div class="card-body">
								<img
										src="{{ Storage::url($product->galleries->first()->photos ?? 'assets/products/nophoto.png') }}"
										alt=""
										class="w-100 mb-2"
								/>
								<div class="product-title">{{ $product->name }}</div>
								<div class="product-category">{{ $product->category->name }}</div>
							</div>
						</a>
					</div> --}}
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
		</div>
	</div>
</div>
@endsection