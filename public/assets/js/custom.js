$(document).ready(function (e) {
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    ///////////////////////// Add Warehouse ///////////////////////

    $('#add_warehouse').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var wname = jQuery('#warehouse_name').val();
    var wtype = jQuery('#wtype').val();
    if (!wname) {
      swal("Error!", "Warehouse name is required", "error");
      return false;
    }
    if (!wtype) {
        swal("Error!", "Warehouse type is required", "error");
        return false;
      }
    $.ajax({
        type:'POST',
        url: "warehouse/add-warehouse",
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
          swal("success!", "Warehouse added", "success");
          $("#add_warehouse")[0].reset();
        }
        else{
        swal("error!", data.messages, "error");
        }
      }
    });
    });

    ///////////////////////// Add Vehicle ///////////////////////

    $("#gvw").keyup(function(){

      var unladen = jQuery('#unladen').val();
      var gvw = jQuery('#gvw').val();
      var vc = gvw - unladen;
      var ty = vc / 1000;
      jQuery('#unladen').attr("readonly", true);
      jQuery('#cap').val(ty);

    });

     $('#add_vehicle').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var vname = jQuery('#vno').val();

        if (!vname) {
          swal("Error!", "Vehicle no is required", "error");
          return false;
        }


        $.ajax({
            type:'POST',
            url: "vehicle/add-vehicle",
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
              swal("success!", "Vehicle added", "success");
              $("#add_vehicle")[0].reset();
            }
            else{
            swal("error!", data.messages, "error");
            }
          }
        });
        });  
        
    ///////////////////////// Add Transporter ///////////////////////

    $('#add_transporter').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var tname = jQuery('#tanme').val();
       // alert(vtype);return false;
        if (!tname) {
          swal("Error!", "Transporter name is required", "error");
          return false;
        }
        
        $.ajax({
            type:'POST',
            url: "transporter/add-transporter",
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
              swal("success!", "Transporter added", "success");
              $("#add_transporter")[0].reset();
            }
            else{
            swal("error!", data.messages, "error");
            }
          }
        });
        }); 

    ///////////////////////// Add Lane ///////////////////////

    $('#add_lane').submit(function(e) {
      e.preventDefault();
      var formData = new FormData(this);
      var from = jQuery('#from_places').val();
      var destination = jQuery('#to_places').val();
     // alert(vtype);return false;
      if (!from) {
        swal("Error!", "Origin field is required", "error");
        return false;
      }
      if (!destination) {
        swal("Error!", "Destination field is required", "error");
        return false;
      }

      if (from == destination) {
        swal("Error!", "From and destination can not be same", "error");
        return false;
      }
      
      $.ajax({
          type:'POST',
          url: "lanes/add-lane",
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
            swal("success!", "Lane added", "success");
            $("#add_lane")[0].reset();
          }
          else{
          swal("error!", data.messages, "error");
          }
        }
      });
      }); 

    ///////////////////////// Add Product ///////////////////////

    $('#add_product').submit(function(e) {
      e.preventDefault();
      var formData = new FormData(this);
      var from = jQuery('#pname').val();

     // alert(vtype);return false;
      if (!from) {
        swal("Error!", "Product field is required", "error");
        return false;
      }
      
      $.ajax({
          type:'POST',
          url: "products/add-product",
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
            swal("success!", "Product added", "success");
            $("#add_product")[0].reset();
          }
          else{
          swal("error!", data.messages, "error");
          }
        }
      });
      });       
            
    ///////////////////////// All imports ///////////////////////

    $('#all_imports').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var itype = jQuery('#itype').val();
        var udata = jQuery('#uploadata').val();
       // alert(vtype);return false;
        if (!itype) {
          swal("Error!", "Please select import type", "error");
          return false;
        }
        if (!udata) {
            swal("Error!", "Upload data file in .csv format", "error");
            return false;
          }       
        $.ajax({
            type:'POST',
            url: "imports/all-import",
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
               if(data.ignoredcount > 0) {
                $(".ignored").show();
                document.getElementById("ignoredItems").innerHTML = data.ignoredItems.join();
                swal("success!", data.ignoredcount + " ignored, Rest Items has been imported successfully", "success");
               } 
               else{
                swal("success!", "File has been imported successfully", "success");
              }
            }
            else{
            swal("error!", data.messages, "error");
            }
          }
        });
    });         
  });
  
  