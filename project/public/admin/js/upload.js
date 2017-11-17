
Formstone.Ready(function() {
	$("#media_main_uploader").upload({
	  maxSize: 107374182400,
	  beforeSend: onBeforeSend,
    filedragenter: onfiledragenter(),
    filedragleave: onfiledragleave(),
	}).on("start.upload", onStart)
	  .on("complete.upload", onComplete)
	  .on("filestart.upload", onFileStart)
	  .on("fileprogress.upload", onFileProgress)
	  .on("filecomplete.upload", onFileComplete)
	  .on("fileerror.upload", onFileError);
	//$("span.media-file-cancel").on("click", onCancel);
	//$(".cancel_all").on("click", onCancelAll);
});
  function onCancel(th) {
    var index = $(th).closest("li").data("index");
    $("#media_main_uploader").upload("abort", parseInt(index, 10));
  }
  function onCancelAll() {
    $("#media_main_uploader").upload("abort");
    setTimeout(function(){ 
    	$('#global_modal').modal('hide');
     }, 1000);
    
  }
  function onBeforeSend(formData, file) {
    formData.append("file", file);
    // return (file.name.indexOf(".jpg") < -1) ? false : formData; // cancel all jpgs
    return formData;
  }
  function onStart(e, files) {
  		var data_html = '<ul class="media_upload_progress_bar">';
		$.each(files, function( key, value ) {
			data_html = data_html+'<li data-index="' + value.index + '"">'+
			'<span class="media-file-name pull-left">'+String(value.file.name)+' <i>0&#37;</i></span>'+
			'<span class="media-file-cancel" onclick="onCancel(this)">Cancel</span>'+
			'<div class="progress">'+
			'<div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>'+
			'</div></li>';
		});
		data_html = data_html+'</ul>';		

    open_modal({
        title: 'upload image',
        message: data_html,
        cancel_text: 'Close Uploader',
        close_icon:  String('fa-times'),
        submit_text: 'Cancel All',
        on_submit: {
            type: 'action',
            url: null,
            parameters: function () {
            	onCancelAll();
            }
           },
    })

    // $(this).parents("form").find(".filelist.queue")
    //   .find("li")
    //   .find(".progress").text("Waiting");
  }
  function onComplete(e) {
    setTimeout(function(){ 
      $('#global_modal').modal('hide');
      $('#media_main_uploader .fs-upload-target').css('border-color', '#a8a5a5').css('color', '#a8a5a5');
     }, 1000);
  }
  function onFileStart(e, file) {
    $("ul.media_upload_progress_bar")
      .find("li[data-index=" + file.index + "]")
      .find(".progress")
      .find('.progress-bar').css("width", "0%").attr('aria-valuenow', '0');
  }
  function onFileProgress(e, file, percent) {
    var html_li = $("ul.media_upload_progress_bar")
      .find("li[data-index=" + file.index + "]");
    html_li.find('.media-file-name')
      .find('i').html(percent+'&#37;');
    html_li.find(".progress")
      .find('.progress-bar').css("width", percent + "%").attr('aria-valuenow', percent);

  }
  function onFileComplete(e, file, response) {
    var html_li = $("ul.media_upload_progress_bar")
      .find("li[data-index=" + file.index + "]");
      html_li.find('span.media-file-name i').html('Complete');
      
      var chack_error = JSON.parse(response);
      if (chack_error.type == 'error') {
      	html_li.find('span.media-file-cancel').html(chack_error.errors.file[0]);
      }else{      	
      	//html_li.find('span.media-file-cancel').html('Complete');
        if (chack_error.type == 'success') {
          var media_html =     '<div class="col-6">'+
                                '<div class="row my-4">'+
                                  '<div class="col-md-5">'+
                                    '<a href="'+chack_error.data.media_url+'">'+
                                        '<img src="'+chack_error.data.thumbnail+'" alt="" class="rounded w-100">'+
                                    '</a>'+
                                  '</div>'+
                                  '<div class="col-md-7">'+
                                    '<div class="d-block mb-4">'+
                                      'File name   : '+chack_error.data.media_name+' <br />'+
                                      'File title  : '+chack_error.data.media_title+' <br />'+
                                      'File type  : '+chack_error.data.media_type+' <br />'+
                                    '</div>';

              if (chack_error.data.media_edith_url) {
                media_html +=  '<a href="'+chack_error.data.media_edith_url+'" class="btn btn btn-secondary">Edith</a>';
              }

              if (chack_error.data.media_delete_url) {
                media_html +=  '<a '+
                'onclick="data_modal(this)" '+
                'data-title="Ready to Delete?" '+
                'data-message="Are you sure you want to delete this media?" '+
                'cancel_text="Cancel" '+
                'submit_text="Delete" '+
                'data-type="post" data-parameters=\'{"_token":"'+ global_data.token +'", "_method": "DELETE"}\''+

                 'href="'+chack_error.data.media_delete_url+'" class="btn btn btn-danger ml-3">Delete</a>';
              }

              media_html += '</div></div>';

              $('span#image_preview_main').show();
              $('#media_preview_append').append(media_html);

        }else{
          return false
        }
      }

  }
  function onFileError(e, file, error) {
       var html_li = $("ul.media_upload_progress_bar")
      .find("li[data-index=" + file.index + "]");
      html_li.addClass("error");
      html_li.find('span.media-file-cancel').html("Error: " + error);
  }

  function onfiledragenter(){
      $('#media_main_uploader .fs-upload-target').css('border-color', '#000000').css('color', '#000');
  }
  function onfiledragleave(){
      $('#media_main_uploader .fs-upload-target').css('border-color', '#a8a5a5').css('color', '#a8a5a5');
  }
