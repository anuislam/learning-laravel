Formstone.Ready(function() {
	var uploder_seleted = false;
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

			uploder_info.find('#media_direct_url').val(media_direct_url);

			uploder_info.find('#uploader_title').val(media_title);
			uploder_info.find('#uploader_alt').val(media_alt);
			uploder_info.find('#uploader_description').val(media_description);
			uploder_seleted = media_id;

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
  

	});


	$('#global_media_uploader').on('click', '#uploder_submit', function(){
		alert(uploder_seleted);
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
      		console.log(chack_error.uploader_data.uploader_preview);
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