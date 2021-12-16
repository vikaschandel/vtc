(function($) {
    'use strict';
        // Roles data table
        $(document).ready(function()
        {
            var searchable = [];
            var selectable = []; 
            
    
            var dTable = $('#trp_table').DataTable({
    
                order: [],
                processing: true,
                responsive: false,
                serverSide: true,
                processing: true,
                language: {
                  processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
                },
                scroller: {
                    loadingIndicator: false
                },
                pagingType: "full_numbers",
                dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                ajax: {
                    url: 'transporter/trnplist',
                    type: "get"
                },
                columns: [
                    {data:'transporter_name', name: 'transporter_name', orderable: false, searchable: false},
                    {data:'gst_number', name: 'gst_number'},
                    {data:'address', name: 'address'},
                    {data:'city', name: 'city'},
                    {data:'state', name: 'state'},
                    {data:'zip', name: 'zip'},
                    {data:'manager_name', name: 'manager_name'},
                    {data:'manager_contact', name: 'manager_contact'},
                    {data:'emp_name', name: 'emp_name'},
                    {data:'emp_contact', name: 'emp_contact'},
                    {data:'action', name: 'action'}
                ],
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn-sm btn-info',
                        title: 'Transporters',
                        header: false,
                        footer: true,
                        exportOptions: {
                            // columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        className: 'btn-sm btn-success',
                        title: 'Transporters',
                        header: false,
                        footer: true,
                        exportOptions: {
                            // columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn-sm btn-warning',
                        title: 'Transporters',
                        header: false,
                        footer: true,
                        exportOptions: {
                            // columns: ':visible',
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-sm btn-primary',
                        title: 'Transporters',
                        pageSize: 'A2',
                        header: false,
                        footer: true,
                        exportOptions: {
                            // columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-sm btn-default',
                        title: 'Transporters',
                        // orientation:'landscape',
                        pageSize: 'A2',
                        header: true,
                        footer: false,
                        orientation: 'landscape',
                        exportOptions: {
                            // columns: ':visible',
                            stripHtml: false
                        }
                    }
                ],
                initComplete: function () {
                    var api =  this.api();
                    api.columns(searchable).every(function () {
                        var column = this;
                        var input = document.createElement("input");
                        input.setAttribute('placeholder', $(column.header()).text());
                        input.setAttribute('style', 'width: 140px; height:25px; border:1px solid whitesmoke;');
    
                        $(input).appendTo($(column.header()).empty())
                        .on('keyup', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
    
                        $('input', this.column(column).header()).on('click', function(e) {
                            e.stopPropagation();
                        });
                    });
    
                    api.columns(selectable).every( function (i, x) {
                        var column = this;
    
                        var select = $('<select style="width: 140px; height:25px; border:1px solid whitesmoke; font-size: 12px; font-weight:bold;"><option value="">'+$(column.header()).text()+'</option></select>')
                            .appendTo($(column.header()).empty())
                            .on('change', function(e){
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column.search(val ? '^'+val+'$' : '', true, false ).draw();
                                e.stopPropagation();
                            });
    
                        $.each(dropdownList[i], function(j, v) {
                            select.append('<option value="'+v+'">'+v+'</option>')
                        });
                    });
                }
            });

            var dTabletags = $('#tagging_table').DataTable({
    
                order: [],
                processing: true,
                responsive: false,
                serverSide: true,
                processing: true,
                language: {
                  processing: '<i class="ace-icon fa fa-spinner fa-spin orange bigger-500" style="font-size:60px;margin-top:50px;"></i>'
                },
                scroller: {
                    loadingIndicator: false
                },
                pagingType: "full_numbers",
                dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
                ajax: {
                    url: '/transporter/get-tagged',
                    type: "get"
                },
                columns: [
                    {data:'wid', name: 'wid', orderable: false, searchable: false},
                    {data:'transporters', name: 'transporters'},
                    {data:'action', name: 'action'}
                ],
                buttons: [
                    {
                        extend: 'copy',
                        className: 'btn-sm btn-info',
                        title: 'Transporters',
                        header: false,
                        footer: true,
                        exportOptions: {
                            // columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        className: 'btn-sm btn-success',
                        title: 'Transporters',
                        header: false,
                        footer: true,
                        exportOptions: {
                            // columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn-sm btn-warning',
                        title: 'Transporters',
                        header: false,
                        footer: true,
                        exportOptions: {
                            // columns: ':visible',
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn-sm btn-primary',
                        title: 'Transporters',
                        pageSize: 'A2',
                        header: false,
                        footer: true,
                        exportOptions: {
                            // columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn-sm btn-default',
                        title: 'Transporters',
                        // orientation:'landscape',
                        pageSize: 'A2',
                        header: true,
                        footer: false,
                        orientation: 'landscape',
                        exportOptions: {
                            // columns: ':visible',
                            stripHtml: false
                        }
                    }
                ],
                initComplete: function () {
                    var api =  this.api();
                    api.columns(searchable).every(function () {
                        var column = this;
                        var input = document.createElement("input");
                        input.setAttribute('placeholder', $(column.header()).text());
                        input.setAttribute('style', 'width: 140px; height:25px; border:1px solid whitesmoke;');
    
                        $(input).appendTo($(column.header()).empty())
                        .on('keyup', function () {
                            column.search($(this).val(), false, false, true).draw();
                        });
    
                        $('input', this.column(column).header()).on('click', function(e) {
                            e.stopPropagation();
                        });
                    });
    
                    api.columns(selectable).every( function (i, x) {
                        var column = this;
    
                        var select = $('<select style="width: 140px; height:25px; border:1px solid whitesmoke; font-size: 12px; font-weight:bold;"><option value="">'+$(column.header()).text()+'</option></select>')
                            .appendTo($(column.header()).empty())
                            .on('change', function(e){
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column.search(val ? '^'+val+'$' : '', true, false ).draw();
                                e.stopPropagation();
                            });
    
                        $.each(dropdownList[i], function(j, v) {
                            select.append('<option value="'+v+'">'+v+'</option>')
                        });
                    });
                }
            });

        });
    
        $('select').select2();

    /*************************** Warehouse tagging *************************/

    $('#add_tagging').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var wid = jQuery('#wid').val();
        var trps = jQuery('#trps').val();
        //alert(trps);return false;
        if (!wid) {
          swal("Error!", "Warehouse field is required", "error");
          return false;
        }
        $.ajax({
            type:'POST',
            url: "/transporter/add-tagging",
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
              swal("success!", "Tagging saved", "success");
              $("#add_lane")[0].reset();
            }
            else{
            swal("error!", data.messages, "error");
            }
          }
        });
        }); 

        $('#update_tagging').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var wid = jQuery('#wid').val();
            var trps = jQuery('#trps').val();
            //alert(trps);return false;
            if (!wid) {
              swal("Error!", "Warehouse field is required", "error");
              return false;
            }
            $.ajax({
                type:'POST',
                url: "/transporter/update-tagging",
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
                  swal("success!", "Tagging updated", "success");
                  $("#add_lane")[0].reset();
                }
                else{
                swal("error!", data.messages, "error");
                }
              }
            });
            });         

    })(jQuery);
