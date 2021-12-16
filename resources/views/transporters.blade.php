@extends("layouts.app")

@section("style")
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
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
                            <li class="breadcrumb-item active" aria-current="page">{{ __('List')}}</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ url('create-vehicle') }}" class="btn btn-primary">Create Transporter</a>
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
                    <table id="trp_table" class="table">
                        <thead>
                            <tr>
                                <th>{{ __('Transporter')}}</th>
                                <th>{{ __('GST')}}</th>
                                <th>{{ __('Address')}}</th>
                                <th>{{ __('City')}}</th>
                                <th>{{ __('state')}}</th>
                                <th>{{ __('Zip')}}</th>
                                <th>{{ __('Manager Name')}}</th>
                                <th>{{ __('M contact')}}</th>
                                <th>{{ __('Emp Name')}}</th>
                                <th>{{ __('Emp contact')}}</th>
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
<!--server side users table script-->
<script src="{{ asset('assets/js/transporter.js') }}"></script>

@endsection