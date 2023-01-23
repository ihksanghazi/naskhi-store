@extends('layouts.dashboard')

@section('title')
  Dashboard Transaction Detail
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
	<div class="container-fluid">
		<div class="dashboard-heading">
			<h2 class="dashboard-title">{{ $transaction->code }}</h2>
			<p class="dashboard-subtitle">Transactions Details</p>
		</div>
		<div class="dashboard-content" id="transactionDetail">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-12 col-md-4">
									<img
										src="{{ Storage::url($transaction->product->galleries->first()->photos ?? '') }}"
										alt=""
										class="w-100 mb-3"
									/>
								</div>
								<div class="col-12 col-md-8">
									<div class="row">
										<div class="col-12 col-md-6">
											<div class="product-title">
												Customer Name
											</div>
											<div class="product-subtitle">
												{{ $transaction->transaction->user->name }}
											</div>
										</div>
										<div class="col-12 col-md-6">
											<div class="product-title">
												Product Name
											</div>
											<div class="product-subtitle">
												{{ $transaction->product->name }}
											</div>
										</div>
										<div class="col-12 col-md-6">
											<div class="product-title">
												Date of Transaction
											</div>
											<div class="product-subtitle">
												{{ $transaction->created_at }}
											</div>
										</div>
										<div class="col-12 col-md-6">
											<div class="product-title">
												Payment Status
											</div>
											<div class="product-subtitle text-danger">
												{{ $transaction->transaction->transaction_status }}
											</div>
										</div>
										<div class="col-12 col-md-6">
												<div class="product-title">
													Total Amount
												</div>
												<div class="product-subtitle">
													Rp. {{ number_format($transaction->product->price) }}
												</div>
										</div>
										<div class="col-12 col-md-6">
											<div class="product-title">
												Mobile
											</div>
											<div class="product-subtitle">
												{{ $transaction->transaction->user->phone_number }}
											</div>
										</div>
									</div>
								</div>
							</div>
							<form action="{{ route('dashboard-transaction-update',$transaction->id) }}" method="post">
								@csrf
								<div class="row">
									<div class="col-12 mt-4">
										<h3>Shipping Information</h3>
									</div>
									<div class="col-12">
										<div class="row">
											<div class="col-12 col-md-6">
												<div class="product-title">
													Address 1
												</div>
												<div class="product-subtitle">
													{{ $transaction->transaction->user->address_one }}
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="product-title">
													Address 2
												</div>
												<div class="product-subtitle">
													{{ $transaction->transaction->user->address_two }}
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="product-title">
													Province
												</div>
												<div class="product-subtitle">
													{{ App\Models\Province::find($transaction->transaction->user->provinces_id)->name }}
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="product-title">
													City
												</div>
												<div class="product-subtitle">
													{{ App\Models\Regency::find($transaction->transaction->user->regencies_id)->name }}
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="product-title">
													Postal Code
												</div>
												<div class="product-subtitle">
													{{ $transaction->transaction->user->zip_code }}
												</div>
											</div>
											<div class="col-12 col-md-6">
												<div class="product-title">
													Country
												</div>
												<div class="product-subtitle">
													Indonesia
												</div>
											</div>
											<div class="col-12 col-md-3">
												<div class="product-title">
													{{ $transaction->transaction->user->country }}
												</div>
												<select
													name="shipping_status"
													id="status"
													class="form-control"
													v-model="status"
												>
													<option value="PENDING" {{ $transaction->shipping_status == "PENDING" ? 'selected' : '' }}>
														Pending
													</option>
													<option value="SHIPPING" {{ $transaction->shipping_status == "SHIPPING" ? 'selected' : '' }}>
														Shipping
													</option>
													<option value="SUCCESS" {{ $transaction->shipping_status == "SUCCESS" ? 'selected' : '' }}>
														Success
													</option>
												</select>
											</div>
											<template v-if="status == 'SHIPPING'">
												<div class="col-md-3">
													<div class="product-title">
														Input Resi
													</div>
													<input
														type="text"
														class="form-control"
														name="resi"
														v-model="resi"
													/>
												</div>
												<div class="col-md-2">
													<button
														type="submit"
														class="btn btn-success btn-block mt-4"
													>
														Update Resi
													</button>
												</div>
											</template>
										</div>
									</div>
								</div>
								<div class="row mt-4">
									<div class="col-12 text-right">
										<button
											type="submit"
											class="btn btn-success btn-lg mt-4"
										>
											Save Now
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
</div>
@endsection

@push('addon-script')
<script src="/vendor/vue/vue.js"></script>
<script>
	var transactionsDetails = new Vue({
		el: "#transactionDetail",
		data: {
			status: "{{ $transaction->shipping_status }}",
			resi: "{{ $transaction->resi }}",
		},
	});
</script>
@endpush