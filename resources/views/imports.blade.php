@extends('layouts.app') 
@section('title', 'Warehouse')
    @section("style")
	<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @endsection
    @section("wrapper")
    <div class="page-wrapper">
      <div class="page-content">

       <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">{{ __('Imports')}}</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Import data for masters')}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Home</button>
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
                    <button type="button" class="btn btn-outline-success position-relative me-lg-5"> <i class="fadeIn animated bx bx-import"></i> {{ __('Bulk Data Import')}}
					</button>
                </div>
	                <div class="card-body">
                               <form id="all_imports" class="row g-3" enctype="multipart/form-data">
                                   @csrf
                                   
									<div class="col-md-4">
                                        <label for="inputLastName" class="form-label">Import Type</label>
										<select class="form-select" id="itype"  name="itype">
											<option disabled selected>Choose...</option>
											<option value="1">Warehouse Data</option>
                                            <option value="2">Vehicles Data</option>
                                            <option value="3">Driver Data</option>
                                            <option value="4">Transporter Data</option>
                                            <option value="5">Lanes Data</option>
                                            <option value="6">Product Data</option>
										</select>
									</div>
                                    <div class="col-4">
										<label for="inputAddress2" class="form-label">Upload CSV</label>
										<input class="form-control" name="uploadata" type="file" id="uploadata">
									</div>
									
									<div class="col-12">
										<button type="submit" id="" class="btn btn-primary px-5">Import</button>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    
		<!--end::Page Custom Javascript-->
	@endsection
