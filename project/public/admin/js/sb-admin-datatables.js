// Call the dataTables jQuery plugin
$(document).ready(function() {
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
                "columns": JSON.parse(tarm_opject_table.attr('tarms-data'))

            });
        }
});
