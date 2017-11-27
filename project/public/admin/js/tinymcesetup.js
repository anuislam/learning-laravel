$(document).ready(function(){
editor = '';
tinymce.PluginManager.add('add_media', function(editor, url) {

    editor.addButton('add_media', {
        //icon: 'insertdatetime',
        image: global_data.upload_dir_url + '/default/cleditor_media_icon.png',
        text: '  Add media',
        tooltip: "Add media",
        onclick: function(e) {

            return_selector = 'tinymce'
            var target = $('#global_media_uploader');
            target.find('.modal-title').html('Add media');
            target.find('#uploder_cancel').html('Cancel');
            target.find('#uploder_submit').html('Submit');    
            target.modal('show');
            uploder_seleted = false;
            target.on('click', '#uploder_submit', function(){
                if (uploder_seleted !== false) {
                    if (return_selector == 'tinymce') {
                        editor.insertContent('<img src="'+uploder_seleted.url+'" alt="'+uploder_seleted.alt+'" />');
                        uploder_seleted = false;
                        return_selector = false;
                        target.modal('hide');
                    }
                }
            });
        
        }
    });

});





tinymce.init({
    selector: 'textarea.tainy_mce',
    resize: "both",
    plugins: "fullscreen code link advlist table textcolor visualblocks template preview hr add_media",
    toolbar: 'undo redo | bold italic underline | link | alignleft | aligncenter | alignright | blockquote bullist numlist outdent indent | code | currentdate | fullscreen | table | forecolor | backcolor | visualblocks | preview | hr | styleselect | add_media',
    menubar:false,
    statusbar: false,
    style_formats: [
{
         title: 'Custom Bullet',
             selector: 'ul', 
             classes: 'custom1'
         },
            {
            title: "Headers",
            items: [{
                    title: "Header 1",
                    format: "h1"
                },
                {
                    title: "Header 2",
                    format: "h2"
                },
                {
                    title: "Header 3",
                    format: "h3"
                },
                {
                    title: "Header 4",
                    format: "h4"
                },
                {
                    title: "Header 5",
                    format: "h5"
                },
                {
                    title: "Header 6",
                    format: "h6"
                }
            ]
        },
        {
            title: "Inline",
            items: [{
                    title: "Bold",
                    icon: "bold",
                    format: "bold"
                }, {
                    title: "Italic",
                    icon: "italic",
                    format: "italic"
                },
                {
                    title: "_Underline",
                    icon: "underline",
                    format: "underline"
                }, {
                    title: "Strikethrough",
                    icon: "strikethrough",
                    format: "strikethrough"
                }, {
                    title: "Superscript",
                    icon: "superscript",
                    format: "superscript"
                }, {
                    title: "Subscript",
                    icon: "subscript",
                    format: "subscript"
                }, {
                    title: "Code",
                    icon: "code",
                    format: "code"
                }
            ]
        },
        {
            title: "_Blocks",
            items: [{
                title: "Paragraph",
                format: "p"
            }, {
                title: "Blockquote",
                format: "blockquote"
            }, {
                title: "Div",
                format: "div"
            }, {
                title: "Pre",
                format: "pre"
            }]
        },
        {
            title: "_Alignment",
            items: [{
                title: "Left",
                icon: "alignleft",
                format: "alignleft"
            }, {
                title: "Center",
                icon: "aligncenter",
                format: "aligncenter"
            }, {
                title: "Right",
                icon: "alignright",
                format: "alignright"
            }, {
                title: "Justify",
                icon: "alignjustify",
                format: "alignjustify"
            }]
        },
        {
            title: "Font Family",
            items: [{
                    title: 'Arial',
                    inline: 'span',
                    styles: {
                        'font-family': 'arial'
                    }
                },
                {
                    title: 'Book Antiqua',
                    inline: 'span',
                    styles: {
                        'font-family': 'book antiqua'
                    }
                },
                {
                    title: 'Comic Sans MS',
                    inline: 'span',
                    styles: {
                        'font-family': 'comic sans ms,sans-serif'
                    }
                },
                {
                    title: 'Courier New',
                    inline: 'span',
                    styles: {
                        'font-family': 'courier new,courier'
                    }
                },
                {
                    title: 'Georgia',
                    inline: 'span',
                    styles: {
                        'font-family': 'georgia,palatino'
                    }
                },
                {
                    title: 'Helvetica',
                    inline: 'span',
                    styles: {
                        'font-family': 'helvetica'
                    }
                },
                {
                    title: 'Impact',
                    inline: 'span',
                    styles: {
                        'font-family': 'impact,chicago'
                    }
                },
                {
                    title: 'Open Sans',
                    inline: 'span',
                    styles: {
                        'font-family': 'Open Sans'
                    }
                },
                {
                    title: 'Symbol',
                    inline: 'span',
                    styles: {
                        'font-family': 'symbol'
                    }
                },
                {
                    title: 'Tahoma',
                    inline: 'span',
                    styles: {
                        'font-family': 'tahoma'
                    }
                },
                {
                    title: 'Terminal',
                    inline: 'span',
                    styles: {
                        'font-family': 'terminal,monaco'
                    }
                },
                {
                    title: 'Times New Roman',
                    inline: 'span',
                    styles: {
                        'font-family': 'times new roman,times'
                    }
                },
                {
                    title: 'Verdana',
                    inline: 'span',
                    styles: {
                        'font-family': 'Verdana'
                    }
                }
            ]
        },
        {
            title: "Font Size",
            items: [{
                    title: '8pt',
                    inline: 'span',
                    styles: {
                        fontSize: '12px',
                        'font-size': '8px'
                    }
                },
                {
                    title: '10pt',
                    inline: 'span',
                    styles: {
                        fontSize: '12px',
                        'font-size': '10px'
                    }
                },
                {
                    title: '12pt',
                    inline: 'span',
                    styles: {
                        fontSize: '12px',
                        'font-size': '12px'
                    }
                },
                {
                    title: '14pt',
                    inline: 'span',
                    styles: {
                        fontSize: '12px',
                        'font-size': '14px'
                    }
                },
                {
                    title: '16pt',
                    inline: 'span',
                    styles: {
                        fontSize: '12px',
                        'font-size': '16px'
                    }
                },
                {
                    title: '18pt',
                    inline: 'span',
                    styles: {
                        fontSize: '18px',
                        'font-size': '18px'
                    }
                },
                {
                    title: '20pt',
                    inline: 'span',
                    styles: {
                        fontSize: '20px',
                        'font-size': '20px'
                    }
                }
            ]
        }
    ],





});


});