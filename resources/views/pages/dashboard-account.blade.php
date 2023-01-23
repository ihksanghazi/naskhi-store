@extends('layouts.dashboard')

@section('title')
  Store Dashboard Account
@endsection

@section('content')
<div class="section-content section-dashboard-home" data-aos="fade-up">
	<div class="container-fluid">
		<div class="dashboard-heading">
			<h2 class="dashboard-title">My Account</h2>
			<p class="dashboard-subtitle">Update your current profile</p>
		</div>
		<div class="dashboard-content">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-12">
									<div class="text-center mb-3">
										<img src="{{ Storage::url($user->photo ? $user->photo : 'assets/user/userDefault.png')}}"
											class="rounded-circle"
											style="width: 200px;height:200px"
										>
									</div>
									<form action="{{ route('dashboard-setting-photo') }}" method="post" enctype="multipart/form-data">
										@csrf
										<input type="file"
											style="display: none"
											name="photo"
											onchange="form.submit()" 
											id="uploadPhoto">
										<button type="button"
											class="btn btn-success w-100 mb-3"
											onclick="document.getElementById('uploadPhoto').click()"	
										>Upload Photo</button>
									</form>	
								</div>
							</div>
							<form action="{{ route('dashboard-setting-redirect','dashboard-setting-account') }}" method="POST" id="location">
								@csrf
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="name">Your Name</label>
											<input
												type="text"
												class="form-control @error('name') is-invalid @enderror"
												id="name"
												name="name"
												value="{{ $user->name }}"
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
											<label for="email"
												>Your Email</label
											>
											<input
												type="email"
												class="form-control @error('email') is-invalid @enderror"
												id="email"
												name="email"
												value="{{ $user->email }}"
											/>
											@error('email')
												<div class="invalid-feedback">
													{{ $message }}
												</div>
											@enderror
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="addressOne"
												>Address 1</label
											>
											<input
												type="text"
												class="form-control"
												id="addressOne"
												name="address_one"
												value="{{ $user->address_one }}"
											/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="addressTwo"
												>Address 2</label
											>
											<input
												type="text"
												class="form-control"
												id="addressTwo"
												name="address_two"
												value="{{ $user->address_two }}"
											/>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="province">Province</label>
											<select
												name="provinces_id"
												id="province"
												class="form-control"
												v-if="provinces" 
												v-model="provinces_id"
											>
												<option v-for="province in provinces" :value="province.id">
													@{{ province.name  }}
												</option>
											</select>
											<select v-else class="form-control"></select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="city">City</label>
											<select
												name="regencies_id"
												id="city"
												class="form-control"
												v-if="regencies"
												v-model="regencies_id"	
											>
												<option v-for="regency in regencies" :value="regency.id">
													@{{ regency.name }}
												</option>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="postalCode"
												>Postal Code</label
											>
											<input
												type="text"
												class="form-control"
												id="postalCode"
												name="zip_code"
												value="{{ $user->zip_code }}"
											/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="country">Country</label>
											<input
												type="text"
												class="form-control"
												id="country"
												name="country"
												value="{{ $user->country }}"
											/>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="mobile">Mobile</label>
											<input
												type="text"
												class="form-control"
												id="mobile"
												name="phone_number"
												value="{{ $user->phone_number }}"
											/>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col text-right">
										<button
											type="submit"
											class="btn btn-success px-5"
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
  <script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
  <script>
    var locations = new Vue({
      el:"#location",
      mounted(){
        AOS.init();
        this.getProvincesData();
      },
      data:{
        provinces:null,
        regencies:null,
        provinces_id:null,
        regencies_id:null,
      },
      methods:{
        getProvincesData(){
          var self = this;
          axios.get('{{ route('api-provinces') }}')
            .then(function(response){
              self.provinces = response.data;
            });
        },
        getRegenciesData(){
          var self = this;
          axios.get('{{ url('api/regencies') }}/'+self.provinces_id)
            .then(function(response){
              self.regencies = response.data;
            });
        },
      },
      watch:{
        provinces_id: function(val,oldval){
          this.regencies_id=null;
          this.getRegenciesData();
        }
      }
    });
  </script>
@endpush