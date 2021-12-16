@extends("layouts.app")

@section("style")
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sweetalert2.min.css') }}">
@endsection

    @section("wrapper")
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Products</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('List')}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleVerticallycenteredModal">Create Product</button>
                </div>
            </div>
           
										<!-- Modal -->
										<div class="modal fade" id="exampleVerticallycenteredModal" tabindex="-1" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title">Add New Product</h5>
														<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
													</div>
													<div class="modal-body">
                                                    <form id="add_product" class="row g-3" enctype="multipart/form-data">
                                                        @csrf
                                                            <div class="col-md-12">
                                                                <label for="inputZip" class="form-label">Product Name</label>
                                                                <input type="text" name="pname" class="form-control" id="pname">
                                                            </div>
                                                            <div class="col-12">
                                                                <button type="submit" class="btn btn-primary px-5">Save</button>
                                                            </div>
                                                        </form>   
                                                    </div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
													</div>
												</div>
											</div>
										</div>
            <!--end breadcrumb-->
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="product_table" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Product Name')}}</th>
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
    </div>
    <!--end page wrapper -->

    
    @endsection

@section("script")
<script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('assets/js/product.js') }}"></script>

@endsection