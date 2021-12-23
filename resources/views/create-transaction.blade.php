@extends('layouts.app') 
@section('title', 'Warehouse')
    @section("style")
    <meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css') }}">
    <script defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key=AIzaSyBQ6x_bU2BIZPPsjS8Y8Zs-yM2g2Bs2mnM"
            type="text/javascript"></script>

    @endsection
    @section("wrapper")
    
    @section("wrapper")
    <style>
        @import url("https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css");
select { font-family: 'FontAwesome', Verdana }
    #warehouse-list {
    float: left;
    list-style: none;
    margin-top: -3px;
    padding: 10px;
    position: absolute;
    z-index: 999;
    width: 80%;
    }
    #warehouse-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
    #warehouse-list li:hover{background:#ece3d2;cursor: pointer;}
    #search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
    
    #add_tranaction h6 {
    margin-top: 0;
    margin-bottom: 0.5rem;
    font-weight: 500;
    line-height: 1.2;
    color: #008cff;
}
.card-header {
    padding: 0.5rem 1rem;
    margin-bottom: 0;
    background-color: rgb(91 153 158 / 6%);
    border-bottom: 1px solid rgb(91 213 40 / 35%);
}
.trpfields{display:none;}
.inv_fields{display:none;}
    </style>
    <div class="page-wrapper">
      <div class="page-content">
           <div class="row clearfix">
	        <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <!-- only those have manage_role permission will get access -->
            @can('create_transaction')
			<div class="col-md-4">
	            <div class="card">
	                <div class="card-header">
                    <h6 style="color:#008cff;"><i class="fadeIn animated bx bx-map"></i><label for="tload" class="form-label">Transaction Details</label></h6>
                </div>
                <div class="card-body">
                @php
                //echo "<pre>"; print_r($vehicle);
                @endphp
                <form id="add_tranaction" class="row g-2" enctype="multipart/form-data">
                                   @csrf
                                   <?php //echo "<pre>"; print_r($assigned);?>
									<div class="col-md-12">
										<label for="inputFirstName" class="form-label">From City</label> 
                                        <input class="form-control" id="from_places" placeholder=""/>
                                        <input id="origin" name="origin" required="" type="hidden"/>
									</div>
                                    <div class="col-md-12" id="fo" style="display:none;">
									</div>
                                    <div class="col-md-12"><label>Destination: </label>
                                        <input class="form-control" id="to_places" placeholder=""/>
                                        <input id="destination" name="destination" required="" type="hidden"/>
                                    </div>   
									<div class="col-md-12" id="trndest" style="display:none;">

									</div>
                                    <div class="col-md-12">
                                    <label for="tload" class="form-label">Transit Load(Enter in MT)</label>
                                    <input type="number" name="trnl" class="form-control" id="trnl" step=".01">
									</div>
                                    <div class="card-header vehiclesList" id="addtrnp"><h6><i class="fadeIn animated bx bx-car"></i> {{ __('Add Transporter + ')}}</h6></div>
                                    <div class="col-md-12 trpfields vehiclesList">
                                    <label for="destinations" class="form-label">Choose Vehicle</label>
                                    <select id="vlist" name="vlist" class="form-select">
											<option disabled selected>Vehicles ...</option>
                                            @foreach ($vehicle as $v)
                                            <option value="{{ $v->vehicle_no }}">{{ $v->vehicle_no }}</option>
                                            @endforeach
										</select>  
									</div>

                                    <div class="col-md-12 trpfields vehiclesList">
                                    <label for="destinations" class="form-label">Vehicle Capacity</label>
                                    <input type="text" name="vtype" readonly class="form-control" id="vtype">
                                    <input type="hidden" value="" id="lane" name="lanes">
									</div>

                                    <div class="col-md-12 trpfields vehiclesList">
                                        <label for="destinations" class="form-label">Seal No</label>
									   <input type="text" name="seal" class="form-control" id="seal">
									</div>

                                    <div class="col-md-12 trpfields vehiclesList">
                                    <label for="destinations" class="form-label">Driver</label>
                                    <input type="text" name="driver" class="form-control" id="driver">
									</div>
                                    <div class="col-md-12 trpfields vehiclesList">
                                    <label for="destinations" class="form-label">Choose Transporter</label>
                                    <select id="trp" name="trp" class="form-select">
											<option disabled selected>Transporter...</option>
                                            @foreach ($transporter as $t)
                                            <option value="{{ $t }}">{{ $t }}</option>
                                            @endforeach
										</select>  
									</div>
                                    <div class="col-md-12 trpfields vehiclesList">
                                        <label for="destinations" class="form-label">LR No</label>
									   <input type="text" name="lr" class="form-control" id="lr">
									</div>        

                                    <div class="card-header vehiclesList" id="invc"><h6> <i class="fadeIn animated bx bx-news"></i> {{ __('Add Invoice Details + ')}}</h6></div>
                                    <div class="col-12 inv_fields vehiclesList">
										<label for="inputAddress2" class="form-label">Product Name</label>
										<input type="dname" class="form-control" name="pname" id="pname">
									</div>
                                    <div class="col-12 inv_fields vehiclesList">
										<label for="inputAddress2" class="form-label">Invoice No</label>
										<input type="text" class="form-control" name="invoice" id="invoice">
									</div>
                                    <div class="col-md-12 inv_fields vehiclesList" >
										<label for="inputEmail" class="form-label">Invoice Date</label>
										<input type="date" class="form-control" name="idate" id="idate">
									</div>
									<div class="col-12">
										<button type="submit" class="btn btn-primary px-5">Save</button>
									</div>
								</form>
	                </div>
	            </div>
	        </div>
            <div class="col-sm-8">
            <div id="map" style="height: 100vh; width: 100%" ></div>
            </div>
            @endcan
		</div>
		
	<div>
</div>
@endsection
    <!-- push external js -->
    @section("script")
    <script>
            $(function () {
                var origin, destination, map, directionsDisplay, directionsService;

                // add input listeners
                google.maps.event.addDomListener(window, 'load', function (listener) {
                    setDestination();
                    initMap();
                });


                // init or load map
                function initMap() {

                    var myLatLng = {
                        lat: 30.7333,
                        lng: 76.7794
                    };
                    map = new google.maps.Map(document.getElementById('map'), {zoom: 8, center: myLatLng,});
                }

                function setDestination() {
                    var from_places = new google.maps.places.Autocomplete(document.getElementById('from_places'));
                    var to_places = new google.maps.places.Autocomplete(document.getElementById('to_places'));

                    google.maps.event.addListener(from_places, 'place_changed', function () {
                        var from_place = from_places.getPlace();
                        var from_address = from_place.formatted_address;
                        var from_lat = from_place.geometry.location.lat();
                        var from_lng = from_place.geometry.location.lng();
                        var from_cords = from_lat+','+from_lng;
                    // console.log(cords);
                        $('#origin').val(from_address);
                        $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: "POST",
                        url: 'warehouses/get-assigned',
                        data:'org='+from_address,
                        beforeSend: function(){
                          
                        },
                        success: function(data){
                            $("#fo").show();
                            $("#fo").html(data);
                        }
                        });
                    });

                    google.maps.event.addListener(to_places, 'place_changed', function () {
                        var to_place = to_places.getPlace();
                        var to_address = to_place.formatted_address;
                        var to_lat = to_place.geometry.location.lat();
                        var to_lng = to_place.geometry.location.lng();
                        var to_cords = to_lat+','+to_lng;
                        $('#destination').val(to_address);
                        var origin = $('#origin').val();
                        $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        type: "POST",
                        url: 'warehouses/get-destination',
                        data:'dest='+to_address,
                        beforeSend: function(){
                         map = new google.maps.Map(document.getElementById('map'), {zoom: 8, center: 'Delhi',});
                        },
                        success: function(data){
                            $("#trndest").show();
                            $("#trndest").html(data);
                            var destination = $('#destination').val();
                            var travel_mode = "DRIVING";    
                            var directionsDisplay = new google.maps.DirectionsRenderer();
                            var directionsService = new google.maps.DirectionsService();
                            displayRoute(travel_mode, origin, destination, directionsService, directionsDisplay);
                        }
                        });

                     });

                }

                function displayRoute(travel_mode, origin, destination, directionsService, directionsDisplay) {
                    directionsService.route({
                        origin: origin,
                        destination: destination,
                        travelMode: travel_mode,
                        avoidTolls: true
                    }, function (response, status) {
                        if (status === 'OK') {
                            directionsDisplay.setMap(map);
                            directionsDisplay.setDirections(response);
                        } else {
                            directionsDisplay.setMap(null);
                            directionsDisplay.setDirections(null);
                            alert('Could not display directions due to: ' + status);
                        }
                    });
                }

            });

            // get current Position
            function getCurrentPosition() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(setCurrentPosition);
                } else {
                    alert("Geolocation is not supported by this browser.")
                }
            }

            function switchText(){
            let obj1 = document.getElementById("from_places");
            let obj2 = document.getElementById("to_places");
            let obj3 = document.getElementById("origin");
            let obj4 = document.getElementById("destination");
            
            let temp = obj1.value;
            obj1.value = obj2.value;
            obj2.value = temp;

            let temphidden = obj3.value;
            obj3.value = obj4.value;
            obj4.value = temphidden;
            }


            // get formatted address based on current position and set it to input
            function setCurrentPosition(pos) {
                var geocoder = new google.maps.Geocoder();
                var latlng = {lat: parseFloat(pos.coords.latitude), lng: parseFloat(pos.coords.longitude)};
                geocoder.geocode({ 'location' :latlng  }, function (responses) {
                    console.log(responses);
                    if (responses && responses.length > 0) {
                        $("#origin").val(responses[1].formatted_address);
                        $("#from_places").val(responses[1].formatted_address);
                        //    console.log(responses[1].formatted_address);
                    } else {
                        alert("Cannot determine address at this location.")
                    }
                });
            }

        $(document).ready(function () {
            $location_input = $("#location");
            autocomplete = new google.maps.places.Autocomplete($location_input.get(0));    
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                var data = $("#search_form").serialize();
                console.log('blah')
                alert(data);
                return false;
            });
        });
        </script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/transactions.js') }}"></script>
	@endsection
