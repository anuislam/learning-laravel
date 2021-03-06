
function delete_comment(id) {
    open_modal({
        title: 'Ready to Delete?',
        message: 'Are you sure you want to delete?',
        cancel_text: 'Cancel',
        close_icon:  String('fa-times'),
        submit_text: 'Delete',
        popup_type: String('modal-danger'),
        on_submit: {
            type: 'ajax',
            url: null,
            parameters: function () {
                $.ajax({
                    type: 'POST',
                    url: global_data.ajax_url,
                    data:{
                      action: 'admin_comment_delete',
                      comment_id: id
                    },
                    success: function(data){
                        var target = $('#global_modal');
                        if (data == 'ok') {
                            alert('comment delete successful.');
                            location.reload();
                        }else{
                            alert('Failed to delete comment.');
                            target.modal('hide');
                        }
                    }
                });
            }
           },
    });
}

function data_modal(th){
    event.preventDefault();
    var current_tag = $(th);
    var parameters_data = JSON.parse(current_tag.attr('data-parameters'));
    open_modal({
        title: String(current_tag.attr('data-title')),
        message: String(current_tag.attr('data-message')),
        cancel_text: String(current_tag.attr('cancel_text')),
        close_icon:  String('fa-times'),
        submit_text: String(current_tag.attr('submit_text')),
        popup_type: String('modal-danger'),
        on_submit: {
            type: String(current_tag.attr('data-type')),
            url: String(current_tag.attr('href')),
            parameters: parameters_data
           },
    })
}

var global_modal_set_memori = '';
function open_modal(data){
    var target = $('#global_modal'); 
    if (data.popup_type) {
        target.removeClass('modal-danger');
        target.removeClass('modal-primary');
        target.removeClass('modal-warning');
        target.removeClass('modal-default');
        target.addClass(data.popup_type);
    }else{
        target.addClass('modal-success');
        target.removeClass('modal-danger');
        target.removeClass('modal-primary');
        target.removeClass('modal-warning');
        target.removeClass('modal-default');
    }
    target.find('.modal-title').html(data.title);
    target.find('.modal-body').html(data.message);
    target.find('#data_cancel').html(data.cancel_text);
    global_modal_set_memori = data.on_submit;
    target.find('#data_submit').html(data.submit_text);
    target.find('#close_icon').html('<i class="fa '+data.close_icon+'" aria-hidden="true"></i>');    
    target.modal('show');

}

$(document).ready(function(){
    $('#data_submit').on('click', function(){
        global_modal_on_submit();
    });
});
function global_modal_on_submit(){
    if (global_modal_set_memori.type == 'post') {
        post(global_modal_set_memori.url, global_modal_set_memori.parameters);
    }else if (global_modal_set_memori.type == 'url') {
        window.location.href = global_modal_set_memori.url;
    }else{
        global_modal_set_memori.parameters();
    }
}


// post(data.on_submit.url, data.on_submit.url.parameters)
// Post to the provided URL with the specified parameters.

function post(path, parameters) {
    var form = $('<form></form>');
    form.attr("method", "post");
    form.attr("action", path);
    $.each(parameters, function(key, value) {
        var field = $('<input></input>');
        field.attr("type", "hidden");
        field.attr("name", key);
        field.attr("value", value);
        form.append(field);
    });
    // The form needs to be a part of the document in
    // order for us to be able to submit it.
    $(document.body).append(form);
    form.submit();
}

function open_modal_chack_slug(th) {

    var form_group  = $(th).closest(".form-group");
    var value       = form_group.attr('data-chack-value');
    var url         = form_group.attr('data-chack-url');
    var pop_title   = $(th).attr('data-title');
    var cancel_text   = $(th).attr('cancel_text');
    var submit_text   = $(th).attr('submit_text');

    var data_html = '<div class="form-group ">'+                        
                        '<input placeholder="'+pop_title+'" class="form-control" type="text" value="'+value+'" id="chack_post_type_slug">'+
                    '</div>';

    open_modal({
        title: pop_title,
        message: data_html,
        cancel_text: cancel_text,
        close_icon:  String('fa-times'),
        submit_text: String(submit_text),
        on_submit: {
            type: 'action',
            url: null,
            parameters: function () {
                 var after_edit_val = $('#chack_post_type_slug').val();
                $.ajax({
                    type: 'POST',
                    url: url,
                    data:{
                      value: String(after_edit_val),
                      post_id: form_group.attr('data-post-id')
                    },
                    success: function(data){
                        if (data.type == 'error') {
                            alert(data.message);
                        }else{
                            form_group.attr('data-chack-value', data.value);
                            form_group.find('input[type="hidden"]').val(data.value);
                            form_group.find('.form-control').html(data.value);
                            $('#global_modal').modal('hide');
                        }
                    }
                });
            }
           },
    });
}


function ValidURL(str) {
var regex = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
  if(!regex .test(str)) {
    return false;
  } else {
    return true;
  }
}


function checkbox_hide_toggole(selector, target) {
    target = $(target);
    if ($(selector).prop('checked')) {
        target.closest('.form-group ').show();
    }else{
        target.closest('.form-group ').hide();
    }
    $(selector).on("ifChecked", function() {
       target.closest('.form-group ').show();
    });
    $(selector).on("ifUnchecked", function() {
       target.closest('.form-group ').hide();
    });
}

checkbox_hide_toggole('#sale_price_schedule',   '.schedule_toggle');
checkbox_hide_toggole('#manage_stock',          '.stock_manage_toggle');

