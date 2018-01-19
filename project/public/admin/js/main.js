
$(document).ready(function() {	

        var tarm_opject_table = $('#tarm_opject_table');
        var set_method = tarm_opject_table.attr('data-method');
        var set_action = tarm_opject_table.attr('data-action');
        set_method = ( set_method === undefined) ? 'PATCH' : set_method ;
        set_action = ( set_action === undefined) ? '' : set_action ;
        if (tarm_opject_table.length > 0) {
            tarm_opject_table.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                         "url": tarm_opject_table.attr('tarms-url'),
                         "dataType": "json",
                         "type": "post",
                         "data":{ _token: global_data.token, _method: set_method, action: set_action}
                       },
                "columns": JSON.parse(tarm_opject_table.attr('tarms-data').trim())
            });
        }


    var $multiSelect = $(".select2").select2();

    $('.uploader_slimScroll').slimScroll({
        height: '500px',
        wheelStep: 10,
    });

    $('li.sub_active').closest('li.treeview').addClass('active');
    $('li.sub_active').addClass('active');


});

