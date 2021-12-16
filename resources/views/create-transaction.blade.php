@extends('layouts.app') 
@section('title', 'Warehouse')
    @section("style")
	<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css') }}">

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
    </style>
    <div class="page-wrapper">
      <div class="page-content">

       <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">{{ __('Transactions')}}</div>
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
                        <button type="button" class="btn btn-primary">Transaction List</button>
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
                    <h6 style="color:#008cff;"><i class="fadeIn animated bx bx-map"></i> ............................. <i class="fadeIn animated bx bx-bus"></i> ........................... <i class="fadeIn animated bx bx-map"></i></h6>
                </div>
                <div class="card-body">
                @php
                //echo "<pre>"; print_r($vehicle);
                @endphp
                <form id="add_tranaction" class="row g-3" enctype="multipart/form-data">
                                   @csrf
                                   <?php //echo "<pre>"; print_r($assigned);?>
									<div class="col-md-4">
										<label for="inputFirstName" class="form-label">Source</label>
										<input type="text" class="form-control" readonly value="<?php echo $assigned;?>" name="source" id="source">
                                        <div id="suggesstion-box"></div>
									</div>
									<div class="col-md-4">
                                       <label for="destinations" class="form-label">Destination</label>
									   <input type="text" name="dest" class="form-control" id="dest">
                                       <div id="suggesstion-destination"></div>
									</div>
                                    <div class="col-md-4 dynamLanes">
									 <!-- Fields will populate once you choose source & destination --> 
									</div>
                                    <div class="card-header vehiclesList"><h6><i class="fadeIn animated bx bx-car"></i> {{ __('Vehicle Details')}}</h6></div>
                                    <div class="col-md-4 vehiclesList">
                                    <label for="destinations" class="form-label">Choose Vehicle</label>
                                    <select id="vlist" name="vlist" class="form-select">
											<option disabled selected>Vehicles ...</option>
                                            @foreach ($vehicle as $v)
                                            <option value="{{ $v->vehicle_no }}">{{ $v->vehicle_no }}</option>
                                            @endforeach
										</select>  
									</div>

                                    <div class="col-md-4 vehiclesList">
                                    <label for="destinations" class="form-label">Vehicle Capacity (in MT)</label>
                                    <input type="text" name="vtype" readonly class="form-control" id="vtype">
                                    <input type="hidden" value="" id="lane" name="lanes">
									</div>

                                    <div class="col-md-4 vehiclesList">
                                    <label for="destinations" class="form-label">Transit Load(Enter in MT)</label>
                                    <input type="number" name="trnl" class="form-control" id="trnl">
									</div>

                                    <div class="col-md-4 vehiclesList">
                                        <label for="destinations" class="form-label">Seal No</label>
									   <input type="text" name="seal" class="form-control" id="seal">
									</div>

                                    <div class="col-md-4 vehiclesList">
                                    <label for="destinations" class="form-label">Driver</label>
                                    <input type="text" name="driver" class="form-control" id="driver">
									</div>


                                    <div class="card-header vehiclesList"><h6> <i class="fadeIn animated bx bx-bus"></i> {{ __('Transporter Details')}}</h6></div>
                                    <div class="col-md-4 vehiclesList">
                                    <label for="destinations" class="form-label">Choose Transporter</label>
                                    <select id="trp" name="trp" class="form-select">
											<option disabled selected>Transporter...</option>
                                            @foreach ($transporter as $t)
                                            <option value="{{ $t }}">{{ $t }}</option>
                                            @endforeach
										</select>  
									</div>
                                    <div class="col-md-4 vehiclesList">
                                        <label for="destinations" class="form-label">LR No</label>
									   <input type="text" name="lr" class="form-control" id="lr">
									</div>
                                    <div class="card-header vehiclesList"><h6> <i class="fadeIn animated bx bx-news"></i> {{ __('Invoice Details')}}</h6></div>
                                  
                                    <div class="col-4 vehiclesList">
										<label for="inputAddress2" class="form-label">Product Name</label>
										<input type="dname" class="form-control" name="pname" id="pname">
									</div>
                                    <div class="col-4 vehiclesList">
										<label for="inputAddress2" class="form-label">Invoice No</label>
										<input type="text" class="form-control" name="invoice" id="invoice">
									</div>
                                    <div class="col-md-4 vehiclesList" >
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
            @endcan
		</div>
		
	<div>
</div>
@endsection
    <!-- push external js -->
    @section("script")
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/transactions.js') }}"></script>
	@endsection
