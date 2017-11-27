
$(document).ready(function() {
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': global_data.token
	    }
	});	
	

        var tarm_opject_table = $('#tarm_opject_table');
        if (tarm_opject_table.length > 0) {
            tarm_opject_table.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                         "url": tarm_opject_table.attr('tarms-url'),
                         "dataType": "json",
                         "type": "post",
                         "data":{ _token: global_data.token, _method: 'PATCH'}
                       },
                "columns": JSON.parse(tarm_opject_table.attr('tarms-data').trim())


        // initComplete: function () {
        //     this.api().columns().every( function () {
        //         var column = this;
        //         var select = $('<select><option value=""></option></select>')
        //             .appendTo( $(column.footer()).empty() )
        //             .on( 'change', function () {
        //                 var val = $.fn.dataTable.util.escapeRegex(
        //                     $(this).val()
        //                 );
 
        //                 column
        //                     .search( val ? '^'+val+'$' : '', true, false )
        //                     .draw();
        //             } );
 
        //         column.data().unique().sort().each( function ( d, j ) {
        //             select.append( '<option value="'+d+'">'+d+'</option>' )
        //         } );
        //     } );
        // }



            });
        }


    var $multiSelect = $(".select2").select2();

    $('.uploader_slimScroll').slimScroll({
        height: '500px',
        wheelStep: 10,
    });

    $('li.sub_active').closest('li.treeview').addClass('active');
    $('li.sub_active').addClass('active');



    // $('.post_type_chack_slug').on('focusout', function(){
    //     var form_group  = $('div.get_post_type_chack_slug_message');
    //     var url         = form_group.attr('data-chack-url');
    //     var value       = $(this).val();   
    //         $.ajax({
    //             type: 'POST',
    //             url: url,
    //             data:{
    //               value: String(value)
    //             },
    //             success: function(data){
    //                 if (data != 'empty') {
    //                     if (data.type == ' error') {
    //                         form_group.addClass('.has-error');                            
    //                         if (form_group.find('.help-block').length > 0) {
    //                             form_group.find('.help-block').html('<strong>'+data.message+'</strong>');
    //                         }else{
    //                             form_group.append('<span class="help-block"><strong>'+data.message+'</strong></span>');
    //                         }
    //                     }else{
    //                         form_group.attr('data-chack-value', data.value);
    //                         form_group.find('input[type="hidden"]').val(data.value);
    //                         form_group.find('.form-control').html(data.value);
    //                     }
    //                 }
    //             }
    //         });
    // });

});

