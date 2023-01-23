@extends('layouts.dashboard')

@section('title')
  Store Dashboard Create
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
	<div class="container-fluid">
		<div class="dashboard-heading">
			<h2 class="dashboard-title">Create New Product</h2>
			<p class="dashboard-subtitle">Create your own product</p>
		</div>
		<div class="dashboard-content pb-5">
			<form action="{{ route('dashboard-product-store') }}" method="post" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-12">
						<input type="hidden" name="users_id" value="{{ Auth::user()->id }}">
						<div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Product Name</label>
											<input
												type="text"
												class="form-control @error('name') is-invalid @enderror"
												name="name"
												value="{{ old('name') ?? '' }}"
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
												name="price"
												value="{{ old('price') ?? '' }}"
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
													<option value="{{ $category->id }}" {{ old('categories_id') == $category->id ? 'selected' : '' }}>
														{{ $category->name }}
													</option>
												@endforeach
											</select>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label>Description</label>
											<textarea name="description" 
												id="editor" 
												class="@error('description') is-invalid @enderror"
											>
												{!! old('description') ?? '' !!}
											</textarea>
											@error('description')
												<div class="invalid-feedback">
													{{ $message }}
												</div>
											@enderror
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label>Thumbnail</label>
											<input
												type="file"
												class="form-control @error('photo.*') is-invalid @enderror"
												name="photo[]"
												multiple
											/>
											@error('photo.*')
												<div class="invalid-feedback">
													{{ $message }}
												</div>
											@enderror
											<p class="text-muted">
												Kamu Dapat Memilih lebih dari
												satu file
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mt-3">
					<div class="col-12 text-right">
						<button type="submit" class="btn btn-success w-100">
							Create Product
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@push('addon-script')
<script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace("editor");
</script>
@endpush