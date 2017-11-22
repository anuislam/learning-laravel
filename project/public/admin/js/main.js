
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
                "columns": JSON.parse(tarm_opject_table.attr('tarms-data'))

            });
        }



	$('.select2').select2();

    $('.uploader_slimScroll').slimScroll({
        height: '500px',
        wheelStep: 10,
    });

    $('li.sub_active').closest('li.treeview').addClass('active');
    $('li.sub_active').addClass('active');


    tinymce.init({
        selector: 'textarea.tainy_mce',

        plugins: "fullscreen image code colorpicker importcss autolink link importcss media lists table importcss paste image textcolor visualblocks template preview hr",
         toolbar: 'undo redo | bold italic underline | link hr | alignleft aligncenter alignright | blockquote bullist numlist outdent indent | code | currentdate | fullscreen | table | image | forecolor | backcolor | visualblocks template preview hr fontsizeselect',
        menu: {
            edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
            insert: {title: 'Insert', items: 'link media | template hr'},
            view: {title: 'View', items: 'visualaid'},
            format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat '},
            table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
            tools: {title: 'Tools', items: 'spellchecker code'}
        },
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt 37pt',

        setup: function(editor) { 

            function toTimeHtml(date) {
              return '<time datetime="' + date.toString() + '">' + date.toDateString() + '</time>';
            }
            
            function insertDate() {
              // var html = toTimeHtml(new Date());
              // editor.insertContent(html);
                $('#global_media_uploader').modal('show');
            }

            editor.addButton('currentdate', {
              //icon: 'fa fa-faceboo',
              image: 'http://p.yusukekamiyamane.com/icons/search/fugue/icons/calendar-blue.png',
              tooltip: "Insert Current Date",
              onclick: insertDate
            });
          }
    });    
  


});

