/*jslint browser: true, devel: true, white: true, eqeq: true, plusplus: true, sloppy: true, vars: true*/
/*global $ */

/*************** General ***************/

var updateOutput = function (e) {
  var list = e.length ? e : $(e.target);
      output = list.data('output');
  if (window.JSON) {
    if (output) {
      output.val(window.JSON.stringify(list.nestable('serialize')));
      
    }
  } else {
    alert('JSON browser support required for this page.');
  }
  list = '';
  output = '';
};

var nestableList = $("#nestable > .dd-list");

/***************************************/


/*************** Delete ***************/

var deleteFromMenuHelper = function (target) {


$.ajax({
  type: 'POST',
  url: global_data.delete_menu_item,
  data:{
    _method: 'PATCH',
    id: target.data('id'),
    menu_id: $('#main_menu_id[name="main_menu_id"]').val()
  },
  success: function(data){
    if (data == 'ok') {
      target.fadeOut(function () {
        target.remove();
        updateOutput($('#nestable').data('output', $('#as-nav-menu-json-output')));
      });
    }
  }
});


};

var deleteFromMenu = function () {

  var targetId = $(this).data('owner-id');
  var target = $('[data-id="' + targetId + '"]');

open_modal({
        title: 'Delete Menu Item',
        message: 'Are you sure you want to delete this?',
        popup_type: 'modal-danger',
        cancel_text: 'Cancel',
        close_icon:  String('fa-times'),
        submit_text: 'Delete',
        on_submit: {
            type: 'action',
            url: null,
            parameters: function () {
			  target.find("li").each(function () {
			    deleteFromMenuHelper($(this));
			  });
			  deleteFromMenuHelper(target);
        
			  updateOutput($('#nestable').data('output', $('#as-nav-menu-json-output')));
			  $('#global_modal').modal('hide')
			  .removeClass('modal-success')
			  .removeClass('modal-danger');

            }
           },
    });

  
};


// Prepares and shows the Edit Form
var prepareEdit = function () {
  var targetId = $(this).attr('data-owner-id');
  var target = $('.dd-item[data-id="' + targetId + '"]');
open_modal({
        title: 'Edit Menu Item',
        message: '<div class="form-group ">'+
    				'<label for="as-modal-menu-title" class="control-label">Menu Title *</label>'+
    				'<input placeholder="Menu title" aria-describedby="Menu title" class="form-control" name="as-modal-menu-title" type="text" value="'+target.attr("data-name")+'" id="as-modal-menu-title">'+
    			 '</div>'+
    			 '<div class="form-group ">'+
    				'<label for="as-modal-menu-url" class="control-label">Menu Url *</label>'+
    				'<input placeholder="Menu url" aria-describedby="Menu url" class="form-control" name="as-modal-menu-url" type="url" value="'+target.attr("data-url")+'" id="as-modal-menu-url">'+
    			 '</div>',
        cancel_text: 'Cancel',
        close_icon:  String('fa-times'),
        submit_text: 'Edit',
        on_submit: {
            type: 'action',
            url: null,
            parameters: function () {
		      var data_ck = true;
			  var modalName = $("#as-modal-menu-title").val();
			  var modalUrl = $("#as-modal-menu-url").val();

			  if (modalName == '') {
			  	data_ck = false;
			  	$("#as-modal-menu-title").closest('.form-group').addClass('has-error');
			  }else{
			  	$("#as-modal-menu-title").closest('.form-group').removeClass('has-error');
			  }
			  if (modalUrl == '') {
			  	data_ck = false;
			  	$("#as-modal-menu-url").closest('.form-group').addClass('has-error');
			  }else{
			  	if (ValidURL(modalUrl)) {
			  		$("#as-modal-menu-url").closest('.form-group').removeClass('has-error');
			  	}else{
			  		data_ck = false;
			  		$("#as-modal-menu-url").closest('.form-group').addClass('has-error');
			  		alert("Please enter a valid URL.");
			  	}
			  }
			  if (data_ck === true) {
			  	editMenuItem(modalName, modalUrl, target.data("id"));
			  	$('#global_modal').modal('hide');
  				updateOutput($('#nestable').data('output', $('#as-nav-menu-json-output')));
			  }
            }
           },
    });

};

// Edits the Menu item and hides the Edit Form
var editMenuItem = function (newName, newurl, targetId) {

      var target = $('.dd-item[data-id="' + targetId + '"]');

		  target.find("> .dd-handle").html(newName);
  		target.attr("data-name", newName);
  		target.attr("data-url", newurl);

  		target.data("name", newName);
  		target.data("url", newurl);
  // update JSON
};

/***************************************/


/*************** Add ***************/

var newIdCount = 1;

var addToMenu = function (newName, newUrl, main_menu_id) {

$.ajax({
  type: 'POST',
  url: global_data.add_menu_item,
  data:{
    _method: 'PUT',
    name: newName,
    url: newUrl,
    main_menu_id: main_menu_id
  },
  success: function(data){
    data = JSON.parse(data);
    if (data.status == 'ok') {
      nestableList.append(
        '<li class="dd-item" ' +
        'data-id="' + data.id + '" ' +
        'data-name="' + data.name + '" ' +
        'data-url="' + data.url + '" ' +
        'data-new="0" ' +
        'data-deleted="0">' +
        '<div class="dd-handle">' + data.name + '</div> ' +
        '<span class="button-delete btn btn-default btn-xs pull-right" ' +
        'data-owner-id="' + data.id + '"> ' +
        '<i class="fa fa-times-circle-o" aria-hidden="true"></i> ' +
        '</span>' +
        '<span class="nav_menu_edit_button button-edit btn btn-default btn-xs pull-right" ' +
        'data-owner-id="' + data.id + '">' +
        '<i class="fa fa-pencil" aria-hidden="true"></i>' +
        '</span>' +
        '</li>'
      );

      updateOutput($('#nestable').data('output', $('#as-nav-menu-json-output')));
      // set events
      $("#nestable .button-delete").on("click", deleteFromMenu);
      $("#nestable .button-edit").on("click", prepareEdit);

    }else{
      alert('Error');
    }
  }
});



  // update JSON
};



/***************************************/



$(function () {

  $("#nestable .button-delete").on("click", deleteFromMenu);
  $("#nestable .button-edit").on("click", prepareEdit);
  updateOutput($('#nestable').data('output', $('#as-nav-menu-json-output')));
	$("#add_nav_menu_item").submit(function (e) {
		e.preventDefault();

		    var data_ck = true;

		  	var newName = $(this).find("#as-menu-title").val();
        var newurl = $(this).find("#as-menu-url").val();
  			var main_menu_id = $('#main_menu_id[name="main_menu_id"]').val();

		  if (newName == '') {
		  	data_ck = false;
		  	$("#as-menu-title").closest('.form-group').addClass('has-error');
		  }else{
		  	$("#as-menu-title").closest('.form-group').removeClass('has-error');
		  }
		  if (newurl == '') {
		  	data_ck = false;
		  	$("#as-menu-url").closest('.form-group').addClass('has-error');
		  }else{
		  	if (ValidURL(newurl)) {
		  		$("#as-menu-url").closest('.form-group').removeClass('has-error');
		  	}else{
		  		data_ck = false;
		  		$("#as-menu-url").closest('.form-group').addClass('has-error');
		  		alert("Please enter a valid URL.");
		  	}
		  }
		  if (data_ck === true) {
		  	addToMenu(newName, newurl, main_menu_id);
		  	$("#as-menu-title").val('');
		  	$("#as-menu-url").val('');
		  }			
	});

});



$('#nestable').nestable({
        maxDepth: 5
      })
      .on('change', function(){
      	updateOutput($('#nestable').data('output', $('#as-nav-menu-json-output')));
      });

