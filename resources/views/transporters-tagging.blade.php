@extends("layouts.app")

@section("style")
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link href="{{ asset('css/sweetalert2.min.css') }}">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

    @section("wrapper")
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Transporters</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Tagging')}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ url('create-vehicle') }}" class="btn btn-primary">Tag Transporter</a>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="card">
                <div class="card-body">
                    <div class="">
                    <form id="add_tagging" class="row g-3" enctype="multipart/form-data">
                                   @csrf
                                   
									<div class="col-md-4">
										<label for="warehousename" class="form-label">Warehouse</label>
                                        <select class="form-control" id="wid" name="warehousename">
                                        <option value="" selected disabled>Select item...</option>
                                        @foreach ($warehouse as $w)
                                        <option value="{{ $w->wid }}">{{ $w->wid }}</option>
                                        @endforeach
                                        </select>
									</div>
									<div class="col-md-8">
                                       <label for="Transporters" class="form-label">Transporters</label>
                                       <select class="form-control" multiple="multiple" name="trps[]" id="trps" required>
                                        @foreach ($transporter as $t)
                                        <option value="{{ $t->transporter_name }}">{{ $t->transporter_name }}</option>
                                        @endforeach
                                        </select>
									</div>

                                    <div class="col-md-4 tagged">

									</div>

									<div class="col-12">
										<button type="submit" class="btn btn-primary px-5">Assign</button>
									</div>
								</form>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="tagging_table" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Warehouse')}}</th>
                                <th>{{ __('Transporters')}}</th>
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
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<!--server side users table script-->
<script src="{{ asset('assets/js/transporter.js') }}"></script>

@endsection