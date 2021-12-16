@extends('layouts.app') 
@section('title', 'Warehouse')
    @section("style")
	<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css') }}">
    @endsection
    @section("wrapper")
    
    @section("wrapper")
    <div class="page-wrapper">
      <div class="page-content">

       <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">{{ __('Transporters')}}</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Add new')}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Transporters List</button>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
			
           <div class="row clearfix">
	        <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <!-- only those have manage_role permission will get access -->
            @can('manage_role')
			<div class="col-md-12">
	            <div class="card">
	                <div class="card-header">
                    <button type="button" class="btn btn-outline-success position-relative me-lg-5"> <i class="fadeIn animated bx bx-bus-school"></i> {{ __('Add Transporters')}}
                </div>
                <div class="card-body">
                <form id="add_transporter" class="row g-3" enctype="multipart/form-data">
                                   @csrf
									<div class="col-md-6">
										<label for="inputFirstName" class="form-label">Transporter Name</label>
										<input type="text" class="form-control" name="tname" id="tanme">
									</div>
									<div class="col-md-6">
                                       <label for="inputEmail" class="form-label">GST Number</label>
									   <input type="coordinates" name="tgst" class="form-control" id="tgst">
									</div>
                                    <div class="col-12">
										<label for="inputAddress2" class="form-label">Address</label>
										<textarea class="form-control" name="taddress" id="inputAddress2" placeholder="Address..." rows="3"></textarea>
									</div>
									<div class="col-md-4">
										<label for="inputCity" class="form-label">City</label>
										<input type="text" name="tcity" class="form-control" id="tcity">
									</div>
									<div class="col-md-4">
										<label for="inputState" class="form-label">State</label>
										<select id="inputState" name="tstate" class="form-select">
											<option selected>Choose...</option>
                                            <option value="AN">Andaman and Nicobar Islands</option>
                                            <option value="AP">Andhra Pradesh</option>
                                            <option value="AR">Arunachal Pradesh</option>
                                            <option value="AS">Assam</option>
                                            <option value="BR">Bihar</option>
                                            <option value="CH">Chandigarh</option>
                                            <option value="CT">Chhattisgarh</option>
                                            <option value="DN">Dadra and Nagar Haveli</option>
                                            <option value="DD">Daman and Diu</option>
                                            <option value="DL">Delhi</option>
                                            <option value="GA">Goa</option>
                                            <option value="GJ">Gujarat</option>
                                            <option value="HR">Haryana</option>
                                            <option value="HP">Himachal Pradesh</option>
                                            <option value="JK">Jammu and Kashmir</option>
                                            <option value="JH">Jharkhand</option>
                                            <option value="KA">Karnataka</option>
                                            <option value="KL">Kerala</option>
                                            <option value="LA">Ladakh</option>
                                            <option value="LD">Lakshadweep</option>
                                            <option value="MP">Madhya Pradesh</option>
                                            <option value="MH">Maharashtra</option>
                                            <option value="MN">Manipur</option>
                                            <option value="ML">Meghalaya</option>
                                            <option value="MZ">Mizoram</option>
                                            <option value="NL">Nagaland</option>
                                            <option value="OR">Odisha</option>
                                            <option value="PY">Puducherry</option>
                                            <option value="PB">Punjab</option>
                                            <option value="RJ">Rajasthan</option>
                                            <option value="SK">Sikkim</option>
                                            <option value="TN">Tamil Nadu</option>
                                            <option value="TG">Telangana</option>
                                            <option value="TR">Tripura</option>
                                            <option value="UP">Uttar Pradesh</option>
                                            <option value="UT">Uttarakhand</option>
                                            <option value="WB">West Bengal</option>
										</select>
									</div>
									<div class="col-md-4">
										<label for="inputZip" class="form-label">Zip</label>
										<input type="text" name="tzip" class="form-control" id="tzip">
									</div>
                                    <div class="card-header"><h6>{{ __('Contact Details')}}</h6></div>
                                  
                                  <div class="col-6">
                                      <label for="inputAddress2" class="form-label">Manager Name</label>
                                      <input type="text" name="mname" class="form-control" id="mname">
                                  </div>
                                  <div class="col-6">
                                      <label for="inputAddress2" class="form-label">Contact No</label>
                                      <input type="text" name="mconum" class="form-control" id="mconum">
                                  </div>
                                  <div class="col-6">
                                      <label for="inputAddress2" class="form-label">Employee Name</label>
                                      <input type="text" name="emname" class="form-control" id="emname">
                                  </div>
                                  <div class="col-6">
                                      <label for="inputAddress2" class="form-label">Contact No</label>
                                      <input type="text" name="econum" class="form-control" id="econum">
                                  </div>
									<div class="col-12">
										<button type="submit" class="btn btn-primary px-5">Save</button>
									</div>
								</form>
	                </div>
	            </div>
	        </div>
            @endcan
		</div>
		
	<div>
</div>
@endsection
    <!-- push external js -->
    @section("script")
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
	@endsection
