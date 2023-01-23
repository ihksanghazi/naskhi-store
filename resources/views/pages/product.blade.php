@extends('layouts.app')

@section('title')
  Store Category page
@endsection

@push('addon-style')
<style>
/* Styling untuk container scroll */
.scroll-container {
  width: 100%;
  overflow-x: scroll;
  overflow-y: hidden;
}

/* Styling untuk elemen scroll-content */
.scroll-content {
  display: flex;
  white-space: nowrap;
}

/* Styling untuk elemen content */
.content {
  min-width: 175px;
  min-height: 255px;
  margin-right: 10px;
  text-align: center;
}
</style>
@endpush

@section('content')
<div class="page-content page-home">
  <section class="store-trend-categories">
    <div class="container">
      <div class="row justify-content-center my-5 py-10" style="position: sticky">
        <div class="col-8">
          <form action="{{ route('products') }}">
            @if (request('category'))
              <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <div class="row">
              <div class="col-10">
                <input type="text" name="search" class="form-control" placeholder="Search">
              </div>
              <div class="col-2">
                <button type="submit" class="btn btn-outline-dark">Search</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-12" data-aos="fade-up">
          <h5>Categories</h5>
        </div>
      </div>

      <div class="scroll-container">
        <div class="scroll-content">
          @php
            $incrementCategories=0;
          @endphp
          @forelse ($categories as $category)
            <div class="content" data-aos="fade-up" data-aos-delay="{{ $incrementCategories+=100 }}">
              <a href="{{ route('products','category='.$category->slug) }}" class="component-categories d-block">
                <div class="categories-image">
                  <img src="{{ Storage::url($category->photo) }}" class="w-100" />
                </div>
                <p class="categories-text">{{ $category->name }}</p>
              </a>  
            </div>
          @empty
            <div class="row">
              <div class="col-12 text-center py-5">
                Categories Not Found
              </div>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </section>
  <section class="store-new-products">
    <div class="container">
      <div class="row">
        <div class="col-12" data-aos="fade-up">
          <h5>Products</h5>
        </div>
      </div>
      <div class="row">
        @php
          $incrementProduct=0;
        @endphp
        @forelse ($products as $product)
          <div
          class="col-6 col-md-4 col-lg-3"
          data-aos="fade-up"
          data-aos-delay="{{ $incrementProduct+=100 }}"
          >
            <a href="{{ route('detail',[$product->slug,$product->id]) }}" class="component-products d-block">
              <div class="products-thumbnail">
                <div
                  class="products-image"
                  style="
                  @if($product->galleries->count())
                    background-image: url('{{ Storage::url($product->galleries->first()->photos) }}')
                  @else
                    background-color: #eee  
                  @endif
                  "
                ></div>
              </div>
              <div class="products-text">{{ $product->name }}</div>
              <div class="products-price">Rp {{ number_format($product->price) }}</div>
            </a>
          </div>    
        @empty
          <div class="col-12 text-center py-5">
            Poducts Not Found
          </div>
        @endforelse
        
      </div>
      <div class="row">
        <div class="col-12 mt-4">
          {{ $products->links() }}
        </div>
      </div>
    </div>
  </section>
</div>
@endsection