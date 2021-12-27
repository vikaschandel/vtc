@extends('layouts.app') 
@section('title', 'Warehouse')
    @section("style")
    <style>
    .swapper {
        text-align: center;
        padding-top: 0px;
        margin-bottom: -31px;
    }
    .swapper i {
    font-size: 32px;
    color: green;
    }
    </style>
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">    
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css') }}">
    <script defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key=AIzaSyBQ6x_bU2BIZPPsjS8Y8Zs-yM2g2Bs2mnM"
            type="text/javascript"></script>
    @endsection

    @section("wrapper")
    <div class="page-wrapper">
      <div class="page-content">

       <!--breadcrumb-->
       <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">{{ __('Lanes')}}</div>
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
                        <button type="button" class="btn btn-primary">Lane List</button>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->

           <div class="row clearfix">
	        <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <!-- only those have manage_role permission will get access -->
            @can('create_transaction')
           <?php //echo "<pre>";print_r($vehicle);?>
			<div class="col-md-4">
	            <div class="card">
	                <div class="card-header">
                    <button type="button" class="btn btn-outline-primary position-relative me-lg-5"> <i class="fadeIn animated bx bx-train"></i> {{ __('Add Lane')}}</button>
                </div>
                    <div class="card-body">
                    <form id="add_lane" class="row" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group"><label>Origin ( <a class="" onclick="getCurrentPosition()">Set Current Location</a>)</label>
                            <input class="form-control" id="from_places" placeholder=""/>
                            <input id="origin" name="origin" required="" type="hidden"/>
                            <div class="swapper" onclick="switchText()"><i class="fadeIn animated bx bx-repost"></i></div>
                        </div>
                        <div class="form-group"><label>Destination: </label>
                            <input class="form-control" id="to_places" placeholder=""/>
                            <input id="destination" name="destination" required="" type="hidden"/>
                        </div>               

                        <div class="form-group">
                        <label for="capacity" class="form-label">Transit Load (in MT)</label>
                         <select id="vtype" name="vtype[]" class="form-select" multiple="multiple">
                            <option value="1">1MT</option>
                            <option value="2">2MT</option>
                            <option value="3">3MT</option>               
                            <option value="4">4MT</option>
                            <option value="5">5MT</option>
                            <option value="6">6MT</option>
                            <option value="7">7MT</option>  
                            <option value="8">8MT</option>           
                            <option value="9">9MT</option>
                            <option value="10">10MT</option>
                            <option value="11">11MT</option>
                            <option value="12">12MT</option>
                            <option value="13">13MT</option>
                            <option value="14">14MT</option>
                            <option value="15">15MT</option>
                            <option value="16">16MT</option>
                            <option value="17">17MT</option>
                            <option value="18">18MT</option>      
                            <option value="19">19MT</option>         
                            <option value="20">20MT</option>
                            <option value="21">21MT</option>
                            <option value="22">22MT</option>
                            <option value="23">23MT</option>
                            <option value="24">24MT</option>
                            <option value="25">25MT</option>
                            <option value="26">26MT</option>
                            <option value="27">27MT</option>
                            <option value="28">28MT</option>
                            <option value="29">29MT</option>
                            <option value="30">30MT</option>
                            <option value="31">31MT</option>
                            <option value="32">32MT</option>
						 </select>
                        </div>    

                        <div class="form-group">
                        <label for="inputZip" class="form-label">Enter Lead Time</label>
                        <input type="number" name="leadtime" class="form-control" id="leadtime">
                        </div>

                        <button type="submit" class="btn btn-primary px-5">Create Lane</button>

                    </form>            
	                </div>
	            </div>
	        </div>
            <div class="col-sm-8">
         <div id="map" style="height: 63vh; width: 100%" ></div>
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
        var origin, destination, map;

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
            map = new google.maps.Map(document.getElementById('map'), {zoom: 14, center: myLatLng,});
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
            });

            google.maps.event.addListener(to_places, 'place_changed', function () {
                map = new google.maps.Map(document.getElementById('map'), {zoom: 8, center: 'Delhi',});
                var to_place = to_places.getPlace();
                var to_address = to_place.formatted_address;
                var to_lat = to_place.geometry.location.lat();
                var to_lng = to_place.geometry.location.lng();
                var to_cords = to_lat+','+to_lng;
                $('#destination').val(to_address);
                var origin = $('#origin').val();
                var destination = $('#destination').val();
                var travel_mode = "DRIVING";     
                var directionsDisplay = new google.maps.DirectionsRenderer({'draggable': false});
                var directionsService = new google.maps.DirectionsService();
                displayRoute(travel_mode, origin, destination, directionsService, directionsDisplay);
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

</script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--get role wise permissiom ajax script-->
    <script src="{{ asset('js/get-role.js') }}"></script>
	@endsection

    