var return_selector = false;
var uploder_seleted = false;
Formstone.Ready(function() {	
	$("#active_global_media_uploader").upload({
		maxSize: 107374182400,
		beforeSend: uploder_BeforeSend,
	}).on("start.upload", uploder_start)	
	  .on("fileprogress.upload", uploder_Progress)
	  .on("filecomplete.upload", uploder_FileComplete)
	  .on("fileerror.upload", uploder_eError);
	  //.on("complete.upload", onComplete)
	  //.on("filestart.upload", onFileStart)
	  //.on("fileprogress.upload", onFileProgress)
	  //.on("filecomplete.upload", onFileComplete)
	  //.on("fileerror.upload", onFileError);


	$('ul.medial_uploder_image_list').on('mouseenter', 'span.media_uploder_image_select', function(){
		$(this).removeClass('fa-check').addClass('fa-close');
	});

	$('ul.medial_uploder_image_list').on('mouseout', 'span.media_uploder_image_select', function(){
		$(this).removeClass('fa-close').addClass('fa-check');
	});

	$('ul.medial_uploder_image_list').on('click', '.media_uploader_image', function(){
		var radio = $(this).closest('li');
		var input = radio.find('input');
		input.prop("checked", true);

		if (input.is(':checked')) {
			$('.media_uploader_image').removeClass('media_active');
			$(this).addClass('media_active');
			var media_preview	= radio.attr('media_preview');
			var media_id	= radio.attr('media_id');
			var media_direct_url	= radio.attr('media_direct_url');
			var media_title	= radio.attr('media_title');
			var media_alt	= radio.attr('media_alt');
			var media_type	= radio.attr('media_type');
			var media_description	= radio.attr('media_description');
			var uploder_info = $('#uploader_info');

			uploder_info.find('#uploader_info_image').addClass('loader_icon');
			uploder_info.find('#uploader_info_image i').show();

			uploder_info.find('#uploader_media_id').val(media_id);

			uploder_info.find('#media_direct_url').val(media_direct_url);
			uploder_info.find('#uploader_title').val(media_title);
			uploder_info.find('#uploader_alt').val(media_alt);
			uploder_info.find('#uploader_description').val(media_description);

			uploder_seleted = {
				id: 			media_id,
				url: 			media_direct_url,
				title: 			media_title,
				alt: 			media_alt,
				description: 	media_description,
				preview_image: 	media_preview,
			};

			var image = new Image();	
			image.src = media_preview;
			image.onload = function () {				
				uploder_info.find('#uploader_info_image span').html('<img src="'+media_preview+'" alt="'+media_alt+'" class="img-thumbnail" />');
				uploder_info.find('#uploader_info_image').removeClass('loader_icon');
				uploder_info.find('#uploader_info_image i').hide();
			}


		}		

	});

	$('#global_media_uploader').on('show.bs.modal', function (event) {	
		var media_count = $('#uploader_media_image_list_content ul.medial_uploder_image_list li');
		if (media_count.length == 0) {
		  $.ajax({
		    type: 'POST',
		    url:  global_data.media_uploade_image_url,
		    data:{
		      action: null
		    },
		    success: function(data){
		     	$('ul.medial_uploder_image_list').html(data);	
			     	setTimeout(function(){	  	
					$(".niceScroll").getNiceScroll().resize();
		  		}, 1000);    
				uploder_seleted	= false;
		    }
		  });
		} 
	});

				// id: 			media_id,
				// url: 			media_direct_url,
				// title: 			media_title,
				// alt: 			media_alt,
				// description: 	media_description,
				// preview_image: 	media_preview,
	$('#global_media_uploader').on('click', '#uploder_submit', function(){
		if (uploder_seleted !== false) {
			if (return_selector !== false) {
				var form_group = $('#'+return_selector).closest('.form-group');
				form_group.find('input[name="'+return_selector+'"]').val(uploder_seleted.id);
				var image_preview = form_group.find('#uploader_image_preview');
				image_preview.css('display', 'block');
				image_preview.html('<img src="'+uploder_seleted.preview_image+'" class="rounded float-left img-thumbnail" alt="'+uploder_seleted.title+'">');
				$('#global_media_uploader').modal('hide');
			}
		}
	});



	$('#global_media_uploader').on('change keyup paste', '#uploader_media_search', function(){
		var value = $(this).val(); 
		$('span.searcg_loader').show();
		  $.ajax({
		    type: 'POST',
		    url:  global_data.media_uploade_search_url,
		    data:{
		      _method: 'patch',
		      search_value: value
		    },
		    success: function(data){
		     	$('ul.medial_uploder_image_list').html(data);	
			     	setTimeout(function(){	  	
		  		}, 1000);     

				uploder_seleted	= false;
				$('span.searcg_loader').hide();
		    }

		  });
	});


	$('#global_media_uploader').on('focusout', '#uploader_title', function(){
		$('#media_uploader_form').trigger('submit');
	});
	$('#global_media_uploader').on('focusout', '#uploader_alt', function(){
		$('#media_uploader_form').trigger('submit');
	});
	$('#global_media_uploader').on('focusout', '#uploader_description', function(){
		$('#media_uploader_form').trigger('submit');
	});

	$('#global_media_uploader').on('submit', '#media_uploader_form', function(e){
		e.preventDefault();
		var action_url 		  = $( this ).attr('action');
		var title 			  = $( this ).find('#uploader_title').val();
		var alt 			  = $( this ).find('#uploader_alt').val();
		var description 	  = $( this ).find('#uploader_description').val();
		var uploader_media_id = $( this ).find('#uploader_media_id').val();

		var action_url 		  = action_url+'/'+uploader_media_id
		if (uploader_media_id != '') {
		  $.ajax({
		    type: 'POST',
		    url:  action_url,
		    data:{
		      _method: 'put',
		      mtitle: title,
		      alt: alt,
		      description: description
		    },
		    success: function(response){
		    	$.each(response, function (key, value) {
	    			var input = $('#'+key);
	    			var form_group = input.closest('.form-group');
		    		var help_block = form_group.find('.help-block');
		    		if (value != 'ok') {
		    			form_group.addClass('has-error');
			    		if (help_block.length > 0) {
			    			help_block.html('<strong>'+value+'</strong>');
			    		}else{
			    			form_group.append('<span class="help-block"><strong>'+value+'</strong></span>');
			    		}
		    		}else{
		    			form_group.removeClass('has-error');
		    			if (help_block.length > 0) {
			    			help_block.remove();
			    		}
		    		}		    		
		    	});



				var update_data = $('ul.medial_uploder_image_list').find('li[media_id="'+uploader_media_id+'"]');
				update_data.attr('media_title', title);
				update_data.attr('media_alt', alt);
				update_data.attr('media_description', description);

		    }

		  });
		}
	});

});


function uploder_start(e, files){
	var data_html = '';
	$.each(files, function( key, value ) {
		data_html = data_html+'<li class="col-3" data-index="' + value.index + '"">'+
		'<span class="media_uploder_image_select fa fa-check"></span>'+
		'<div class="media_uploder_image_preloader img-thumbnail">'+
		'<div class="progress">'+
		'<div class="progress-bar progress-bar-striped bg-success progress-bar-animated" role="progressbar" style="width: 0;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>'+
		'</div></li>';
	});
	$('#nav_media_uploader_tab').tab('show');
	$('.medial_uploder_image_list').prepend(data_html);
}

function uploder_Progress(e, file, percent){
 var html_li = $("ul.medial_uploder_image_list")
      .find("li[data-index=" + file.index + "]");
    html_li.find(".progress")
      .find('.progress-bar').css("width", percent + "%").attr('aria-valuenow', percent);
}

function uploder_FileComplete(e, file, response){

	 var html_li = $("ul.medial_uploder_image_list")
      .find("li[data-index=" + file.index + "]");


	var chack_error = JSON.parse(response);
	if (chack_error.type == 'error') {
      	html_li.find('.media_uploder_image_preloader').html('<span class="media_uploader_error_msg">Error</span>');
      }else{
      	if (chack_error.type == 'success') {
      		//html_li.remove();
      		html_li.attr('media_preview', chack_error.uploader_data.uploader_preview);
      		html_li.attr('media_id', chack_error.uploader_data.media_id);
      		html_li.attr('media_title', chack_error.uploader_data.media_title);
      		html_li.attr('media_alt', chack_error.uploader_data.alt);
      		html_li.attr('media_type', chack_error.uploader_data.media_type);
      		html_li.attr('media_description', chack_error.uploader_data.description);
      		html_li.attr('media_direct_url', chack_error.uploader_data.media_direct_url);
     		data_html = '<div class="media_uploader_image">'+
							'<span class="media_uploder_image_select fa fa-check"></span>'+           
							  '<img src="'+chack_error.uploader_data.thumbnail+'" alt="'+chack_error.uploader_data.media_title+'" class="img-thumbnail">'+
							'</div>'+
							'<input type="radio" name="media_uploader">';
			html_li.html(data_html);
						

      	}else{
          return false
        }
      }
      
}

function uploder_eError(e, file, error){
	 var html_li = $("ul.medial_uploder_image_list")
      .find("li[data-index=" + file.index + "]");

      html_li.find('.media_uploder_image_preloader').html('<span class="media_uploader_error_msg">Error</span>');
}

  function uploder_BeforeSend(formData, file) {
    formData.append("file", file);
    // return (file.name.indexOf(".jpg") < -1) ? false : formData; // cancel all jpgs
    return formData;
  }


  function open_media_uploader(th){
  	var data_title = $(th).attr('uploader_title');
  	var cancel_text = $(th).attr('cancel_text');
  	var submit_text = $(th).attr('submit_text');
  	return_selector = $(th).attr('id');
  	if(return_selector === undefined){
  		return_selector = false;
  	}
  	if(data_title === undefined){
  		data_title = 'Upload Image';
  	}
  	if(cancel_text === undefined){
  		cancel_text = 'Cancel';
  	}
  	if(submit_text === undefined){
  		submit_text = 'Select';
  	}
    var target = $('#global_media_uploader');
    target.find('.modal-title').html(data_title);
    target.find('#uploder_cancel').html(cancel_text);
    target.find('#uploder_submit').html(submit_text);    
    target.modal('show');
  }