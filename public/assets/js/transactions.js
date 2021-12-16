
$(document).ready(function (e) {
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    //$('#vlist').attr('disabled', 'disabled');

    ///////////  Get lanes Data /////////////

    $("#source").keyup(function(){
        $.ajax({
        type: "GET",
        url: 'warehouse/suggested-lanes',
        data:'keyword='+$(this).val(),
        beforeSend: function(){
            $("#source").css("background","#FFF");
        },
        success: function(data){
            $("#suggesstion-box").show();
            $("#suggesstion-box").html(data);
            $("#source").css("background","#FFF");
        }
        });
    });

    $("#dest").keyup(function(){
        var k = $(this).val();
        var s = jQuery('#source').val();
        $.ajax({
        type: "GET",
        url: 'warehouse/suggested-desti',
        data:{ 
            destination: k, 
            source: s, 
          },
        beforeSend: function(){
            $("#dest").css("background","#FFF");
        },
        success: function(data){
            $("#suggesstion-destination").show();
            $("#suggesstion-destination").html(data);
            $("#dest").css("background","#FFF");
        }
        });
    });
    

    $('#vlist').on('change', function() {
        
        //var lane = $('#lanes').val();
        var vehicle = $(this).val();
        var source = jQuery('#source').val();
        var destination = jQuery('#dest').val();

          $.ajax({
            type: "GET",
            url: 'vehicle/check-vehicles',
            data:{ 
                vehicle: vehicle, 
                source: source,
                destination: destination,  
              },
            beforeSend: function(){
                $("#dest").css("background","#FFF");
            },
            success: function(data){
            if(data.success === true) { 
                swal("Alert!", "The lane you selected have differen vehicle type from " +vehicle+ " type", "error");
              }
              else{
                $('#vtype').val(data.vt);
                $('#lane').val(data.lane);
              }
            }
            });  

      });

    ///////////////////////// Add Transaction ///////////////////////

    $('#add_tranaction').submit(function(e) {
      //alert('hii');return false;
    e.preventDefault();
    var formData = new FormData(this);
    var dest = jQuery('#dest').val();
    var vehicle = jQuery('#vlist').val();
    var vt = jQuery('#vtype').val();
    var tl = parseInt(jQuery('#trnl').val());
    var arr = vt.split(' ');
    var cap = parseInt(arr[0]);


    /*var lane = jQuery('#lanes').val();
    if (!lane) {
      swal("Error!", "Lane is required, choose the right destination", "error");
      return false;
    }*/
    if (!dest) {
      swal("Error!", "Destination is required", "error");
      return false;
    }
    if (!vehicle) {
        swal("Error!", "Vehicle no is required", "error");
        return false;
      }
   if (tl > cap) {
        swal("Error!", "Transit Load can not be greater then Vehicle type/capacity", "error");
        return false;
      }
    $.ajax({
        type:'POST',
        url: "transaction/add-new-transaction",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        beforeSend: function(){
          $(".indicator-progress").show();
          $(".indicator-label").hide();
          
         },
        success: (data) => {
          $(".indicator-progress").hide();
          $(".indicator-label").show();
        if(data.success === true) { 
          swal("success!", "Transaction added", "success");
          $("#add_tranaction")[0].reset();
        }
        else{
        swal("error!", data.message, "error");
        }
      }
    });
    });
  });
  
  ////////// Function used in Ajax Calls ///////////////////

  function selectWarehouse(val) {
    $("#source").val(val);
    $("#suggesstion-box").hide();
    }

  function selectDesti(val) {
        $("#dest").val(val);
        $("#suggesstion-destination").hide();
        /*var dest = jQuery('#dest').val();
        var source = jQuery('#source').val();
        $.ajax({
            type: "GET",
            url: 'warehouse/getLanes',
            data:{ 
                destination: dest, 
                source: source, 
              },
            beforeSend: function(){
                $("#dest").css("background","#FFF");
            },
            success: function(data){
                $(".dynamLanes").html(data);
                if(data != ''){
                $(".vehiclesList").show();
                }
                
            }
            });*/
        
   }
 ////////// Function used in Ajax Calls ///////////////////

