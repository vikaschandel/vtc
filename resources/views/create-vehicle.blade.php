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
                <div class="breadcrumb-title pe-3">{{ __('Vehicles')}}</div>
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
                        <button type="button" class="btn btn-primary">Vehicle List</button>
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
			<div class="col-md-12">
	            <div class="card">
	                <div class="card-header">
                    <button type="button" class="btn btn-outline-primary position-relative me-lg-5"> <i class="fadeIn animated bx bx-train"></i> {{ __('Add Vehicle')}}</button>
                </div>
	                <div class="card-body">
                    <form id="add_vehicle" class="row g-3" enctype="multipart/form-data">
                                   @csrf
									<div class="col-md-4">
										<label for="inputFirstName" class="form-label">Vehicle/RC No</label>
										<input type="text" class="form-control" name="vno" id="vno">
									</div>
                                    <div class="col-md-4">
										<label for="inputEmail" class="form-label">Unladen Weight</label>
										<input type="number" name="unladen" class="form-control" id="unladen">
									</div>
                                    <div class="col-md-4">
										<label for="inputEmail" class="form-label">Gross Vehicle Weight</label>
										<input type="number" name="gvw" class="form-control" id="gvw">
									</div>
                                    <div class="col-md-4">
										<label for="capacity" class="form-label">Vehicle Capacity (in MT)</label>
										<input type="text" name="cap" class="form-control" id="cap" readonly>
									</div>
                                    <div class="col-4">
										<label for="inputAddress2" class="form-label">Upload RC</label>
										<input class="form-control" name="uploadrc" type="file" id="uploadrc">
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
