
function logout_modal(th){
    var current_tag = $(th);
   open_modal({
    title: 'Ready to Leave?',
    message: 'Select "Logout" below if you are ready to end your current session.',
    cancel_text: 'Cancel',
    close_icon:  'fa-times',
    submit_text: 'Logout',
    on_submit: {
        type: 'post',
        url: current_tag.attr('dada-url'),
        parameters: {
            _token : current_tag.attr('data-token')
        }
       },
   })
}





var global_modal_set_memori = '';
function open_modal(data){
    console.log(data);
    var target = $('#global_modal');
    target.find('.modal-title').html(data.title);
    target.find('.modal-body').html(data.message);
    target.find('#data_cancel').html(data.cancel_text);
    global_modal_set_memori = data.on_submit;
    target.find('#data_submit').html(data.submit_text);
    target.find('#close_icon').html('<i class="fa '+data.close_icon+'" aria-hidden="true"></i>');    
    target.modal('show');
}

$('#data_submit').on('click', function(){
    global_modal_on_submit();
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