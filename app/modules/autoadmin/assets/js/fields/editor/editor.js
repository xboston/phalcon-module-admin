
$(function() {
    var $editors = $('textarea.editor');

    if (CKEDITOR.length != 0 ){
        $editors.each(function (){
            var $editor = $(this);

            CKEDITOR.replace( $editor.attr('id'), {extraPlugins: 'cyberim'});

        });

    }
});
