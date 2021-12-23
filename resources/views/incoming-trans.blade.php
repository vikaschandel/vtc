@extends("layouts.app")

@section("style")
<style>

.theads {
    text-align: center;
    padding: 20px 0;
}
.theads {
    text-align: center;
    padding: 20px 0;
    color: #279dff;
}
</style>
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
@endsection

    @section("wrapper")
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Transactions</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Incoming')}}</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <div class="card">
                <div class="card-body">
                <div class="table-responsive">
							<table class="table mb-0">
                                <h2 class="theads">ARRIVALS </h2>
								<thead class="table-light">
									<tr>
										<th>TRNS#</th>
										<th>Arriving From</th>
										<th>Dpt. Date</th>
										<th>Vehicle</th>
										<th>Transit Load</th>
										<th>Transporter</th>
										<th>Tracking Status</th>
										<th>Lead Time Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
									//echo "<pre>";print_r($data);die;
									?>
									 @foreach ($data as $transactions)
									<tr>
										<td>{{ $transactions['tid'] }}</td>
										<td>{{ @$transactions['from'] }}</td>
										<td>{{ $transactions['created_at'] }}</td>
										<td>{{ $transactions['vehicle_no'] }}</td>
										<td>{{ $transactions['transit_load'] }}MT</td>
										<td>{{ $transactions['transporter'] }}</td>
										<td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>{{ $transactions['status'] }}</div></td>
										<td><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>On time</div></td>
									</tr>
									@endforeach
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

@endsection