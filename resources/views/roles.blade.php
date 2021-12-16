@extends('layouts.app') 
@section('title', 'Permission')
    @section("style")
	<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @endsection
    @section("wrapper")
    
    @section("wrapper")
    <div class="page-wrapper">
      <div class="page-content">

       <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">{{ __('User Roles')}}</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Define roles of user')}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary">Settings</button>
                        <button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
                            <a class="dropdown-item" href="javascript:;">Another action</a>
                            <a class="dropdown-item" href="javascript:;">Something else here</a>
                            <div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
                        </div>
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
	                <div class="card-header"><h5>{{ __('Add Role')}}</h5></div>
	                <div class="card-body">
	                    <form class="forms-sample" method="POST" action="{{url('role/create')}}">
	                    	@csrf
	                        <div class="row">
	                            <div class="col-sm-5">
	                                <div class="form-group">
	                                    <label for="role">{{ __('Role')}}<span class="text-red">*</span></label>
	                                    <input type="text" class="form-control is-valid" id="role" name="role" placeholder="Role Name" required>
	                                </div>
	                            </div>
	                            <div class="col-sm-7">
	                                <label for="exampleInputEmail3">{{ __('Assign Permission')}} </label>
	                                <div class="row">
									@foreach($permissions as $key => $permission)
	                                	<div class="col-sm-4">
                                            <label class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="item_checkbox" name="permissions[]" value="{{$key}}">
                                                <span class="custom-control-label">
                                                	<!-- clean unescaped data is to avoid potential XSS risk -->
                                                	{{ $permission }}
                                                </span>
                                            </label>
	                                	</div>
	                                	@endforeach 
	                                </div>
	                                
	                                <div class="form-group">
	                                	<button type="submit" class="btn btn-primary btn-rounded">{{ __('Save')}}</button>
	                                </div>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
            @endcan
		</div>
		<div class="row">
	        <div class="col-md-12">
	            <div class="card p-3">
	                <div class="card-header"><h5>{{ __('Roles')}}</h5></div>
	                <div class="card-body">
	                    <table id="roles_table" class="table">
	                        <thead>
	                            <tr>
	                                <th>{{ __('Role')}}</th>
	                                <th>{{ __('Permissions')}}</th>
	                                <th>{{ __('Action')}}</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        </tbody>
	                    </table>
	                </div>
	            </div>
	        </div>
	    </div>
	<div>
</div>
@endsection
    <!-- push external js -->
    @section("script")
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
    <!--server side roles table script-->
    <script src="{{ asset('js/custom.js') }}"></script>
	@endsection
