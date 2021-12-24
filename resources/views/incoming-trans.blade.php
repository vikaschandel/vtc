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
                <?php $title = array("","Vehicle No", "Status", "Action");?>
                <div class="table-responsive">
							<table class="table mb-0" id="arrivals">
                                <h2 class="theads">ARRIVALS </h2>
								<thead class="table-light">
                                <tr><?php foreach($title as $t) echo "<th>$t</th>"; ?></tr>
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

@endsection