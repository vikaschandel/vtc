@extends('layouts.app') 
@section('title', 'Warehouse')
    @section("style")
	<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?libraries=geometry,places,drawing&key=AIzaSyBQ6x_bU2BIZPPsjS8Y8Zs-yM2g2Bs2mnM"></script>
    @endsection
    @section("wrapper")
    <div class="page-wrapper">
      <div class="page-content">

       <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">{{ __('Warehouse')}}</div>
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
                        <button type="button" class="btn btn-primary">Warehouse List</button>
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
                    <button type="button" class="btn btn-outline-success position-relative me-lg-5"> <i class="fadeIn animated bx bx-store"></i> {{ __('Add Warehouse')}}
					</button>
                </div>
	                <div class="card-body">
                               <form id="add_warehouse" class="row g-3">
                                   @csrf
									<div class="col-md-3">
										<label for="inputFirstName" class="form-label">Warehouse Name</label>
										<input type="text" class="form-control" name="warehouse_name" id="warehouse_name">
									</div>
									<div class="col-md-3">
										<label for="inputLastName" class="form-label">Type</label>
										<select class="form-select" id="wtype"  name="wtype">
											<option selected>Choose...</option>
											<option value="primary">Primary</option>
                                            <option value="secondary">Secondary</option>
										</select>
									</div>
                                    <div class="col-md-3">
										<label for="inputFirstName" class="form-label">SD/C&F Name</label>
										<input type="text" class="form-control" name="sdcf" id="sdcf">
									</div>
									<div class="col-md-3">
										<label for="inputEmail" class="form-label">Map Location (Latitude,Longitude)</label>
                                        <input type="hidden" name="origin_pincode" placeholder="*Pincode" class="form-control" required id="origin_pincode" readonly>
                                    <input type="text" name="origin" id="origin" class="form-control"
                                        placeholder="Enter Pincode or City Name">
                                        <input type="hidden" id="origin_city_latlng" name="origin_city_latlng">
									</div>
									<div class="col-12">
										<label for="inputAddress2" class="form-label">Address</label>
										<textarea class="form-control" name="waddress" id="waddress" placeholder="Address..." rows="3"></textarea>
									</div>
									<div class="col-md-4">
										<label for="inputCity" class="form-label">City</label>
										<input type="text" name="wcity" class="form-control" id="wcity">
									</div>
									<div class="col-md-4">
										<label for="inputState" class="form-label">State</label>
										<select class="form-select" id="wstate" name="state">
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
										<input type="text" name="wzip" class="form-control" id="wzip">
									</div>
									<div class="col-12">
										<button type="submit" id="" class="btn btn-primary px-5"><span translate="no">Save</span></button>
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
    <script>
                                    var geocoder;

                                    //Reverse geocoding to get excat city pincode
                                    function codeLatLngO() {
                                        var input = document.getElementById('origin_city_latlng').value;
                                        var latlngStr = input.split(',');
                                        var lat = parseFloat(latlngStr[0]);
                                        var lng = parseFloat(latlngStr[1]);
                                        var latlng = new google.maps.LatLng(lat, lng);
                                        var geocoder = new google.maps.Geocoder();
                                        geocoder.geocode({
                                            'latLng': latlng
                                        }, processRevGeocodeO);
                                        //   alert(lat +''+ lng);
                                    }

                                    // process the results
                                    function processRevGeocodeO(results, status) {
                                        if (status == google.maps.GeocoderStatus.OK) {
                                            var result;
                                            if (results.length > 1)
                                                result = results[1];
                                            else
                                                result = results[0];
                                            displayOPostcode(results[0].address_components);

                                        } else {
                                            alert('Geocoder failed due to: ' + status);
                                        }
                                    }

                                    // displays the resulting post code in a div
                                    function displayOPostcode(address) {
                                        for (p = address.length - 1; p >= 0; p--) {
                                            if (address[p].types.indexOf("postal_code") != -1) {
                                                document.getElementById('origin_pincode').value = address[p].long_name;
                                            }
                                        }
                                    }

                                    //code for getting google city locations in input field
                                    var input1 = 'origin';
                                    $(document).ready(function() {
                                        var autocomplete1;
                                        autocomplete1 = new google.maps.places.Autocomplete(document.getElementById(input1));
                                        google.maps.event.addListener(autocomplete1, 'place_changed', function() {
                                            var near_place1 = autocomplete1.getPlace();
                                            document.getElementById('origin_city_latlng').value = near_place1.geometry.location.lat() + ',' + near_place1.geometry.location.lng();
                                            codeLatLngO();
                                        });
                                    });
                                    $(document).on('change', '#' + input1, function() {
                                        document.getElementById('origin_city_latlng').value = '';
                                        document.getElementById('origin_pincode').value = '';

                                    });

    
                                </script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    
		<!--end::Page Custom Javascript-->
	@endsection
