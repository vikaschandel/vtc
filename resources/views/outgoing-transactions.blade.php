@extends("layouts.app")
@section("style")
<style>
td.dt-control {
    background: url('/img/details_open.png') no-repeat center center !important;
    cursor: pointer;
}
tr.shown td.dt-control {
    background: url('/img/details_close.png') no-repeat center center !important;
}
.theads {
    text-align: center;
    padding: 5px 0;
    color: #279dff;
}
.ant-timeline {
    box-sizing: border-box;
    font-size: 14px;
    font-variant: tabular-nums;
    line-height: 1.5;
    font-feature-settings: "tnum","tnum";
    margin: 0;
    padding: 0;
    list-style: none;
}
.css-b03s4t {
    color: rgb(0, 0, 0);
    padding: 6px 0px 2px;
}
.css-16pld72 {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-transform: capitalize;
}
.ant-timeline-item-tail {
    position: absolute;
    top: 10px;
    left: 4px;
    height: calc(100% - 10px);
    border-left: 2px solid #e8e8e8;
}
.ant-timeline-item-last>.ant-timeline-item-tail {
    display: none;
}

.ant-timeline-item-head-red {
    background-color: #f5222d;
    border-color: #f5222d;
}
.ant-timeline-item-head-green {
    background-color: #52c41a;
    border-color: #52c41a;
}
.ant-timeline-item-content {
    position: relative;
    top: -6px;
    margin: 0 0 0 18px;
    word-break: break-word;
}
.css-phvyqn {
    color: rgb(0, 0, 0);
    padding: 0px;
    height: 34px !important;
}
.ant-timeline-item {
    position: relative;
    margin: 0;
    padding: 0 0 5px;
    font-size: 14px;
    list-style: none;
}
.ant-timeline-item-head {
    position: absolute;
    width: 10px;
    height: 10px;
    border-radius: 100px;
}
.css-ccw3oz .ant-timeline-item-head {
    padding: 0px;
    border-radius: 0px !important;
}
</style>
<link rel="stylesheet" href="{{ asset('plugins/DataTables/datatables.min.css') }}">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<script defer src="https://maps.googleapis.com/maps/api/js?libraries=places&language=en&key=AIzaSyBQ6x_bU2BIZPPsjS8Y8Zs-yM2g2Bs2mnM" type="text/javascript"></script>

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
                            <li class="breadcrumb-item active" aria-current="page">{{ __('Outgoing')}}</li>
                        </ol>
                    </nav>
                </div>

            </div>
            <!--end breadcrumb-->
            <!-- start message area-->
            @include('include.message')
            <!-- end message area-->
            <?php $title = array("","Vehicle No", "Route", "Started", "Transit Load", "Status");?>
            <div class="card">
                <div class="card-body">
                <div class="table-responsive">
							<table class="table mb-0 display" id="dept">
								<thead class="table-dark">
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
<script>
/* Formatting function for row details - modify as you need */
 
function format ( d ) {

    // `d` is the original data object for the row
    return '<div class="row">'+
    '<div class="col-md-3">'+
    '<strong>#TXNS Id:</strong> '+d.tid+'<br/>'+
    '<strong>Driver:</strong> '+d.driver+'<br/>'+
    '<strong>Lr No:</strong> '+d.lr+'<br/>'+
    '<strong>Seal:</strong> '+d.seal+'<br/>'+
    '<strong>Product:</strong> '+d.product+'<br/>'+
    '<strong>Invoice:</strong> '+d.invoice+'<br/>'+
    '<strong>Inv Date:</strong> '+d.idate+'<br/><br/>'+
    ''+d.route+'<br/>'+
    '</div>'+
    '<div class="col-md-9">'+
    '<div id="map-'+d.id+'" style="height: 40vh; width: 100%" ></div>'+
    '<script type="text/javascript">\n' + 
                    "var map = new google.maps.Map(document.getElementById('map-"+d.id+"'), {zoom: 8, center: 'Delhi',});\n"+
                    "var directionsDisplay = new google.maps.DirectionsRenderer({'draggable': false});\n"+
                    "var directionsService = new google.maps.DirectionsService();\n"+
                    "var travel_mode = 'DRIVING';\n"+ 
                    "var origin = '"+d.from+"';\n"+
                    "var destination = '"+d.city+"';\n"+
                    "directionsService.route({\n"+
                                "origin: origin,\n"+
                                "destination: destination,\n"+
                                "travelMode: travel_mode,\n"+
                                "avoidTolls: true\n"+
                            "}, function (response, status) {\n"+
                                "if (status === 'OK') {\n"+
                                    "directionsDisplay.setMap(map);\n"+
                                    "directionsDisplay.setDirections(response);\n"+
                                "} else {\n"+
                                    "directionsDisplay.setMap(null);\n"+
                                    "directionsDisplay.setDirections(null);\n"+
                                    "alert('Unknown lane found with error code 0, contact your manager');\n"+
                                "}\n"+
                    "});\n"+
             '<\/script></div>'+
    '</div>';
}

$(document).ready(function() {
    var table = $('#dept').DataTable( {
        "ajax": "/transactions/outgoing-dt",
        "columns": [
            {
                "className": 'dt-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            { "data": 'transporters'},
            { "data": "route" },
            { "data": "start_date" },
            { "data": "transit_load" },
            { "data": "status" },
        ],
        "order": [[1, 'asc']]
    } );
     
    // Add event listener for opening and closing details
    $('#dept tbody').on('click', 'td.dt-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
} );

</script>
<!--server side users table script-->

@endsection