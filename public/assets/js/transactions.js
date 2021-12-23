
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
        //alert(s);
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
    var dest = jQuery('#destination').val();
    var trnl = jQuery('#trnl').val();
    var tl = parseInt(jQuery('#trnl').val());

    if (!dest) {
      swal("Error!", "Destination is required", "error");
      return false;
    }
    if (!trnl) {
        swal("Error!", "Transit load is required", "error");
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

 $("#addtrnp").click(function(){
  $(".trpfields").show();
  $(".inv_fields").hide();
});

$("#invc").click(function(){
  $(".inv_fields").show();
  $(".trpfields").hide();
});

