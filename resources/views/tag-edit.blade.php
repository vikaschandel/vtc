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
                    <form id="update_tagging" class="row g-3" enctype="multipart/form-data">
                                   @csrf
									<div class="col-md-4">
										<label for="warehousename" class="form-label">Warehouse</label>
                                        <input class="form-control" id="wid" name="warehousename" type="text" value="<?php echo $wid;?>" readonly>
									</div>
									<div class="col-md-8">
                                       <label for="Transporters" class="form-label">Transporters</label>
                                       <select class="form-control" multiple="multiple" name="trps[]" id="trps" required>
                                        <?php

                                        foreach ($transporter as $selection) {
                                            $selected = '';
                                            foreach ($slt as $tagged) {
                                                $selected .= ($selection->transporter_name == $tagged) ? "selected" : "";
                                            }
                                            echo '<option '.$selected.' value="'.$selection->transporter_name.'">'.$selection->transporter_name.'</option>';
                                        }
                                        ?>
                                        </select>
									</div>

                                    <div class="col-md-4 tagged">

									</div>

									<div class="col-12">
										<button type="submit" class="btn btn-primary px-5">Update</button>
									</div>
								</form>
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