
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
    }else{
        window.location.href = global_modal_set_memori.url;
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