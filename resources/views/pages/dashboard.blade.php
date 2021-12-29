@extends("layouts.app")
@section("style")
<meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
    <style>
        .list-group {
            width: 400px !important
        }

        .list-group-item {
            margin-top: 10px;
            border-radius: none;
            background: #5E35B1;
            cursor: pointer;
            transition: all 0.3s ease-in-out
        }

        .list-group-item:hover {
            transform: scaleX(1.1)
        }

        .about span {
            font-size: 12px;
            margin-right: 10px;
            color:#000;
        }
        .ml-2 {
            margin-left: 10px;
        }

        .d-flex.ttt.flex-row {
            background: #f9be10;
            border: 2px solid #000;
            border-radius: 3px;
            padding: 5px 10px;
        }
        .list-group .mb-0 {
                margin-bottom: 0 !important;
                font-size: 21px;
            }
            .list-group span {
                font-size: 10px;
                padding-top: 5px;
                color:#000;
            }
         .list-group td {
            font-size: 18px;
        }
    </style>
@endsection

@section("wrapper")
    <div class="page-wrapper">
        <div class="page-content">
           @role('Security Guards') 
           @include('include.message')
            <div class="container d-flex justify-content-center">
                <ul class="list-group mt-5 text-white">
                    <h4 class="justify-content-center">Incoming Vehicles</h4>
                    @if(!empty($data))
                    @foreach($data as $inv)
                    <li class="list-group-item d-flex justify-content-between align-content-center">
                        <div class="d-flex ttt flex-row"><span  translate="no"> IND </span>
                            <div class="ml-2">
                                <h6 class="mb-0" translate="no">{{ $inv['vehicle_no'] }}</h6>
                            </div>
                        </div>
                        <div class="check"><button type="button" data-bs-toggle="modal" data-bs-target="#enter_id_{{ $inv['id'] }}" class="btn btn-primary px-3 radius-30">Enter</button></div>		
                    </li>
                    <!-- Modal -->
                    <div class="modal fade" id="enter_id_{{ $inv['id'] }}" tabindex="-1" aria-hidden="true">
                           <form id="update_txn_{{ $inv['id'] }}" class="row" enctype="multipart/form-data">
                             @csrf  
								<div class="modal-dialog modal-dialog-centered">
									<div class="modal-content">
										<div class="modal-header">
												<h5 class="modal-title">Verify Details</h5>
												<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
									<div class="modal-body">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Vehicle No</th>
                                            <td>
                                            <div class="d-flex ttt flex-row" style="width:65%"><span translate="no"> IND </span>
                                                <div class="ml-2">
                                                    <h6 class="mb-0" translate="no">{{ $inv['vehicle_no'] }}</h6>
                                                </div>
                                            </div> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Driver Name</th>
                                            <td>{{ $inv['driver'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Load - MT</th>
                                            <td>{{ $inv['transit_load'] }}MT</td>
                                        </tr>
                                        <tr>
                                            <th>Invoice Details</th>
                                            <td>{{ $inv['invoice'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>LR No</th>
                                            <td>{{ $inv['lr'] }}</td>
                                        </tr>
                                        <tr>
                                            <th>Upload Photo</th>
                                            <td><input type="file" id="entryFile_{{ $inv['id'] }}" name="entryFile_{{ $inv['id'] }}"></td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" onClick="updateEntery({{ $inv['id'] }})" class="btn btn-primary">Verify</button>
                                    </div>
							   </div>
						</div>
                        </form>
					</div>                    
                    @endforeach 
                   @else
                   <p style="color:red;font-size:16px;"> No Vehicle found</p>
                   @endif 
                </ul>
            </div>
            @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Orders</p>
                                    <h4 class="my-1 text-info">4805</h4>
                                    <p class="mb-0 font-13">+2.5% from last week</p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class='bx bxs-cart'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Revenue</p>
                                    <h4 class="my-1 text-danger">₹84,245</h4>
                                    <p class="mb-0 font-13">+5.4% from last week</p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class='bx bxs-wallet'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Bounce Rate</p>
                                    <h4 class="my-1 text-success">34.6%</h4>
                                    <p class="mb-0 font-13">-4.5% from last week</p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bxs-bar-chart-alt-2' ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Customers</p>
                                    <h4 class="my-1 text-warning">8.4K</h4>
                                    <p class="mb-0 font-13">+8.4% from last week</p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i class='bx bxs-group'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->

            <div class="row">
                <div class="col-12 col-lg-7 col-xl-8 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Recent Orders</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12 border-end">
                                    <div id="geographic-map-2"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-5 col-xl-4 d-flex">
                    <div class="card w-100 radius-10">
                        <div class="card-body">
                            <div class="card radius-10 border shadow-none">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Total Likes</p>
                                            <h4 class="my-1">45.6M</h4>
                                            <p class="mb-0 font-13">+6.2% from last week</p>
                                        </div>
                                        <div class="widgets-icons-2 bg-gradient-cosmic text-white ms-auto"><i class='bx bxs-heart-circle'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card radius-10 border shadow-none">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Comments</p>
                                            <h4 class="my-1">25.6K</h4>
                                            <p class="mb-0 font-13">+3.7% from last week</p>
                                        </div>
                                        <div class="widgets-icons-2 bg-gradient-ibiza text-white ms-auto"><i class='bx bxs-comment-detail'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card radius-10 mb-0 border shadow-none">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Total Shares</p>
                                            <h4 class="my-1">85.4M</h4>
                                            <p class="mb-0 font-13">+4.6% from last week</p>
                                        </div>
                                        <div class="widgets-icons-2 bg-gradient-moonlit text-white ms-auto"><i class='bx bxs-share-alt'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div><!--end row-->
 
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Sales Overview</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
                                <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #14abef"></i>Sales</span>
                                <span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1" style="color: #ffc107"></i>Visits</span>
                            </div>
                            <div class="chart-container-1">
                                <canvas id="chart1"></canvas>
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">24.15M</h5>
                                    <small class="mb-0">Overall Visitor <span> <i class="bx bx-up-arrow-alt align-middle"></i> 2.43%</span></small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">12:38</h5>
                                    <small class="mb-0">Visitor Duration <span> <i class="bx bx-up-arrow-alt align-middle"></i> 12.65%</span></small>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3">
                                    <h5 class="mb-0">639.82</h5>
                                    <small class="mb-0">Pages/Visit <span> <i class="bx bx-up-arrow-alt align-middle"></i> 5.62%</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="card radius-10">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Trending Products</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="chart-container-2 mt-4">
                                <canvas id="chart2"></canvas>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Jeans <span class="badge bg-success rounded-pill">25</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">T-Shirts <span class="badge bg-danger rounded-pill">10</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Shoes <span class="badge bg-primary rounded-pill">65</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Lingerie <span class="badge bg-warning text-dark rounded-pill">14</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!--end row-->

            <div class="row row-cols-1 row-cols-lg-3">
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <p class="font-weight-bold mb-1 text-secondary">Weekly Revenue</p>
                            <div class="d-flex align-items-center mb-4">
                                <div>
                                    <h4 class="mb-0">₹89,540</h4>
                                </div>
                                <div class="">
                                    <p class="mb-0 align-self-center font-weight-bold text-success ms-2">4.4% <i class="bx bxs-up-arrow-alt mr-2"></i>
                                    </p>
                                </div>
                            </div>
                            <div class="chart-container-0">
                                <canvas id="chart3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Orders Summary</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container-1">
                                <canvas id="chart4"></canvas>
                            </div>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Completed <span class="badge bg-gradient-quepal rounded-pill">25</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Pending <span class="badge bg-gradient-ibiza rounded-pill">10</span>
                            </li>
                            <li class="list-group-item d-flex bg-transparent justify-content-between align-items-center">Process <span class="badge bg-gradient-deepblue rounded-pill">65</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-header bg-transparent">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0">Top Selling Categories</h6>
                                </div>
                                <div class="dropdown ms-auto">
                                    <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Another action</a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:;">Something else here</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container-0">
                                <canvas id="chart5"></canvas>
                            </div>
                        </div>
                        <div class="row row-group border-top g-0">
                            <div class="col">
                                <div class="p-3 text-center">
                                    <h4 class="mb-0 text-danger">₹45,216</h4>
                                    <p class="mb-0">Clothing</p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-3 text-center">
                                    <h4 class="mb-0 text-success">₹68,154</h4>
                                    <p class="mb-0">Electronic</p>
                                </div>
                            </div>
                        </div><!--end row-->
                    </div>
                </div>
            </div><!--end row-->
            @endrole
        </div>
    </div>
@endsection

@section("script")
    <script src="assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="assets/plugins/chartjs/js/Chart.min.js"></script>
    <script src="assets/plugins/chartjs/js/Chart.extension.js"></script>
    <script src="assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
    @role('Security Guards') 
    <link href="{{ asset('css/sweetalert2.min.css') }}">
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <style>.dataTables_filter, .dataTables_info { display: none; }</style>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    @else
    <script src="assets/js/index.js"></script>
    @endrole
<script>
 $(document).ready(function() {
    var table = $('#arrivals').DataTable( {
        "ajax": "/transactions/incoming-trn-dt",
        "bPaginate": false,
        "columns": [
            { "data": 'status'},
            { "data": "action" }
        ]
    } );
 }); 
 $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 
function updateEntery( id ) {
    
    var fd = new FormData();  
    //var efile = $('#entryFile_'+id).val(); \
    fd.append('file', $('#entryFile_'+id)[0].files[0]);
    fd.append('tid', id);
    $.ajax({
    url: 'transactions/entry/',
    data: fd,
    processData: false,
    contentType: false,
    type: 'POST',
    success: function(data){
        if(data.success == true){ // if true (1)
            swal("success!", "Vehicle Verified", "success");
            setTimeout(function(){// wait for 5 secs(2)
                location.reload(); // then reload the page.(3)
            }, 2000); 
        }
        else{
            alert(data.message);
        }
    }
});
}
</script>    
@endsection