const editor_file = {
    customConfig : '/plugins/ckeditor/config.js',
    filebrowserUploadUrl : '/editor-upload',
    fileTools_requestHeaders : {'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')}
},
editor = {
    customConfig : '/plugins/ckeditor/config.js',
}

$(function(){
	$(document).on('click', '.cookie-popup', function () {
        if ($(this).data('type') == 'l') {
            $(`#layer-${$(this).val()}`).fadeOut();
        } else {
            $(`#header-${$(this).val()}`).slideUp();
        }
        $.cookie(`popup-${$(this).val()}`, true, { expires: 1 , path: '/' });
    });
    $(document).on('click', '.close-popup', function () {
        if ($(this).data('type') == 'l') {
            $(`#layer-${$(this).data('id')}`).fadeOut();
        } else {
            $(`#header-${$(this).data('id')}`).slideUp();
        }
    });
    
})