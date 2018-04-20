function as_cms_post(path, parameters, method = 'post') {
    var form = $('<form></form>');
    form.attr("method", method);
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