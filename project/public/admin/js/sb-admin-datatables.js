// Call the dataTables jQuery plugin
$(document).ready(function() {
        $('#admin_user_dataTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": global_data.data_table_url,
                     "dataType": "json",
                     "type": "post",
                     "data":{ _token: global_data.token}
                   },
            "columns": [
                { "data": "profile", searchable: false, orderable: false },
                { "data": "fname" },
                { "data": "lname" },
                { "data": "email" },
                { "data": "created_at", searchable: false, orderable: false  },
                { "data": "roll", searchable: false, orderable: false },
                { "data": "action", searchable: false, orderable: false  },
            ]

        });

        $('#tarm_opject_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": global_data.data_table_url,
                     "dataType": "json",
                     "type": "post",
                     "data":{ _token: global_data.token}
                   },
            "columns": [
                { "data": "fname" },
                { "data": "action", searchable: false, orderable: false  },
            ]

        });


});
