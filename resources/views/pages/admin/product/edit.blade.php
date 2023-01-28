@extends('layouts.admin')

@section('title')
  Product
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
	<div class="container-fluid">
		<div class="dashboard-heading">
			<h2 class="dashboard-title">{{ $product->name }}</h2>
			<p class="dashboard-subtitle">Product Details</p>
		</div>
		<div class="dashboard-content">
			<div class="row">
				<div class="col-12">
					<form action="{{ route('product.update',$product->id) }}" method="post">
						@csrf
            @method('put')
						<div class="card">
							<div class="card-body">
								<div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Pemilik</label>
                      <select name="users_id" class="form-control">
                        @foreach ($users as $user)
                          <option value="{{ $user->id }}" {{ $product->user->id === $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
									<div class="col-md-6">
											<div class="form-group">
												<label>Product Name</label>
												<input
													type="text"
													class="form-control @error('name') is-invalid @enderror"
													name="name"
													value="{{ old('name') ?? $product->name }}"
												/>
												@error('name')
													<div class="invalid-feedback">
														{{ $message }}
													</div>
												@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Price</label>
											<input
												type="number"
												class="form-control @error('price') is-invalid @enderror"
												value="{{ old('price') ?? $product->price }}"
												name="price"
											/>
											@error('price')
												<div class="invalid-feedback">
													{{ $message }}
												</div>
											@enderror
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label>Category</label>
											<select
												name="categories_id"
												class="form-control"
											>
												@foreach ($categories as $category)
													<option value="{{ $category->id }}" {{ old('categories_id') == $category->id || $product->category->id == $category->id ? 'selected' : '' }}>
														{{ $category->name }}
													</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label>Description</label>
											<textarea id="editor"
												name="description"
												class="form-control @error('description') is-invalid @enderror"	
											>
												{!! old('description') ?? $product->description !!}
											</textarea>
											@error('description')
												<div class="invalid-feedback">
													{{ $message }}
												</div>
											@enderror
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-12 text-right">
										<button
											type="submit"
											class="btn btn-success w-100"
										>
											Update Product
										</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row mt-3">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
								@foreach ($product->galleries as $gallery)
									<div class="col-md-4">
										<div class="gallery-container">
											<img
												src="{{ Storage::url($gallery->photos) }}"
												class="w-100"
											/>
											<form action="{{ route('dashboard-product-gallery-delete',$gallery->id) }}" method="post">
												@csrf
												@method('delete')
												<input type="hidden" name="product_id" value="{{ $product->id }}">
												<button type="submit" class="delete-gallery" style="background: none;border:none" >
													<img
														src="/images/icon-delete.svg"
													/>
												</button>
											</form>
										</div>
									</div>
								@endforeach
								<div class="col-12">
									<form action="{{ route('dashboard-product-gallery-upload') }}" method="post" enctype="multipart/form-data">
										@csrf
										<input type="hidden" name="products_id" value="{{ $product->id }}">
										<input
											type="file"
											id="file"
											style="display: none"
											name="photos"
											onchange="form.submit()"
										/>
										@if ($errors->any())
											@foreach ($errors->all() as $error)
												<div class="alert alert-warning alert-dismissible fade show my-3" role="alert">
													{{ $error }}
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
											@endforeach
										@endif
										<button
											type="button"
											class="btn btn-secondary btn-block mt-3"
											onclick="thisFileUpload()"
										>
											Add Photo
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




{{-- <div class="section-content section-dashboard-home" data-aos="fade-up">
  <div class="container-fluid">
    <div class="dashboard-heading">
      <h2 class="dashboard-title">Product</h2>
      <p class="dashboard-subtitle">Edit Product</p>
    </div>
    <div class="dashboard-content">
      <div class="row">
        <div class="col-md-12">
          @if ($errors->any())
            <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          <div class="card">
            <div class="card-body">
              <form action="{{ route('product.update',$item->id) }}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Product name</label>
                      <input type="text" name="name" class="form-control" value="{{ $item->name }}" required>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Owner</label>
                      <select name="users_id" class="form-control">
                        <option value="{{ $item->users_id }}">{{ $item->user->name }}</option>
                        @foreach ($users as $user)
                          <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Price</label>
                      <input type="number" name="price" class="form-control" value="{{ $item->price }}" required>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Category</label>
                      <select name="categories_id" class="form-control" required>
                        <option value="{{ $item->categories_id }}">{{ $item->category->name }}</option>
                        @foreach ($categories as $category)
                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Description</label>
                      <textarea name="description" class="form-control" id="editor" required>{!! $item->description !!}</textarea>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col text-right">
                    <button type="submit" class="btn btn-success px-5">
                      Edit Now
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> --}}
@endsection

@push('addon-script')
  <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
  <script>
    function thisFileUpload() {
		  document.getElementById("file").click();
	  }
  </script>
  <script>
    CKEDITOR.replace('editor');
  </script>
@endpush