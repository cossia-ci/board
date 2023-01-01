const
view_youtube = (obj) => {
    const cnt = $(obj).data('content')?`<div class="youtube-content">${$(obj).data('content')}</div>`:``;
    BootstrapDialog.show({
        title: $(obj).data('title'),
        closeByBackdrop: false,
        closeByKeyboard: false,
        message: `<iframe width="550" height="305" src="https://www.youtube.com/embed/${$(obj).data('id')}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>${cnt}`
    });
};

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