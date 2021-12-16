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
                        <button type="button" class="btn btn-primary">Lanes List</button>
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
			<div class="col-md-12">
	            <div class="card">
	                <div class="card-header">
                    <button type="button" class="btn btn-outline-primary position-relative me-lg-5"><i class="fadeIn animated lni lni-map"></i> {{ __('Add Lanes')}}</button>
                   </div>
	                <div class="card-body">
                               <form id="add_lane" class="row g-3" enctype="multipart/form-data">
                                   @csrf
									<div class="col-md-4">
										<label for="inputFirstName" class="form-label">From</label>
                                        <select id="from" name="from" class="form-select">
											<option disabled selected>Choose...</option>
                                            @foreach ($warehouse as $w)
                                                <option value="{{ $w->city }}">{{ $w->city }}</option>
                                            @endforeach
										</select>
									</div>
									<div class="col-md-4">
                                       <label for="inputEmail" class="form-label">Destination</label>
                                       <select id="destination"  name="destination" class="form-select">
											<option disabled selected>Choose...</option>
                                            @foreach ($warehouse as $w)
                                                <option value="{{ $w->city }}">{{ $w->city }}</option>
                                            @endforeach
										</select>
									</div>
                                    <div class="col-4">
										<label for="inputAddress2" class="form-label">Vehicle Type</label>
										<select id="vtype" name="vtype" class="form-select">
											<option disabled selected>Choose...</option>
                                            <option value="1-5">1-5 MT</option>
                                            <option value="6-10">6-10 MT</option>
                                            <option value="11-15">11-15 MT</option>
                                            <option value="16-20">16-20 MT</option>
                                            <option value="21-50">21-50 MT</option>

										</select>
									</div>
									<div class="col-md-4">
										<label for="inputZip" class="form-label">Lead Time</label>
                                        <select id="lformat" name="lformat" class="form-select">
											<option disabled selected>Lead Time Format ...</option>
                                                <option value="days">Days</option>
                                                <option value="hours">Hours</option>
										</select>
									</div>
                                    <div class="col-md-4">
										<label for="inputZip" class="form-label">Enter Lead Time</label>
										<input type="number" name="leadtime" class="form-control" id="leadtime">
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
