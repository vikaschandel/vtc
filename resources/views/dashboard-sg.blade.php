@extends("layouts.app")
@section("style")
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
        .mb-0 {
                margin-bottom: 0 !important;
                font-size: 21px;
            }
            .list-group span {
                font-size: 10px;
                padding-top: 5px;
                color:#000;
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
                    <li class="list-group-item d-flex justify-content-between align-content-center">
                        <div class="d-flex ttt flex-row"><span> IND </span>
                            <div class="ml-2">
                                <h6 class="mb-0">PB65AX7625</h6>
                            </div>
                        </div>
                        <div class="check"><button type="button" class="btn btn-primary px-3 radius-30">Enter</button></div>
                    </li> 
                </ul>
            </div>
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
    <script src="{{ asset('plugins/DataTables/datatables.min.js') }}"></script>
    <style>.dataTables_filter, .dataTables_info { display: none; }</style>
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
 
</script>    
@endsection