$(document).ready(function(){
    $('.site_map_btn').click(function(){
        $('.site_map').addClass('on')
    });
    $('.site_map .sm_close').click(function(){
        $('.site_map').removeClass('on')
    });
    /*
    $('.site_map .site_map_inner > ul > li').click(function(){
        $(this).find('ul').slideToggle(300);
        $('.site_map .site_map_inner > ul > li').not(this)
        .find('ul').slideUp(300);return false;
    });
    */
})
$(document).on('click', '.site_map .have-children', function(){
    $(this).toggleClass('on')
});
