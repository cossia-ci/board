$(window).scroll(function(){ 
	const height = $(document).scrollTop(),
		  height_ = $('.head-title').outerHeight(true),
		  width = $('.content').outerWidth(true);
	if( height > 92 ){
		$('.head-title').addClass('head-title-fixed').css('width', width+'px');
		$('.content').css('margin-top', height_+'px');
	}else{
		$('.head-title').removeClass('head-title-fixed').css('width', '100%');
		$('.content').css('margin-top', '0px');
	}
});

let index = 1000;

$(document).on('click', '.js-del-content', function(){
    if( !$('input[name="anos[]"]:checked').length ){
        alert('선택된 항목이 없습니다.');
        return;
    }
    let anos = [];
    $('input[name="anos[]"]:checked').each(function(){
        anos.push( $(this).val() );
    })
    Swal.fire({
        title: '정말 삭제 하시겠습니까?',
        text: '삭제 후 복원이 불가능 할 수 있습니다.',
        icon: 'question',
        allowOutsideClick: false,
        scrollbarPadding: false,
        showCancelButton: true,
        confirmButtonText: '삭제',
        cancelButtonText: '취소'
    }).then((result) => {
        if( result.value === true ){
            $.when( ajax_from({ano: anos, code: $(this).data('code') }, '/del-ajax-content') ).done(function(data){
                if( data === true ){
                    alert('처리되었습니다.', 'reload');
                }else{
                    alert('일시적인 오류 입니다. 다시 시도해 주세요', 'reload');
                }
            });
        }else location.reload();
    });
});
    
$(document).on('click', '.js-del-board', function(){
    if( !$('input[name="anos[]"]:checked').length ){
        alert('선택된 항목이 없습니다.');
        return;
    }
    let anos = [];
    $('input[name="anos[]"]:checked').each(function(){
        anos.push( $(this).val() );
    })
    Swal.fire({
        title: '정말 삭제 하시겠습니까?',
        text: '삭제 후 복원이 불가능 할 수 있습니다.',
        icon: 'question',
        allowOutsideClick: false,
        scrollbarPadding: false,
        showCancelButton: true,
        confirmButtonText: '삭제',
        cancelButtonText: '취소'
    }).then((result) => {
        if( result.value === true ){
            $.when( ajax_from({ano: anos }, '/del-ajax-board') ).done(function(data){
                if( data === true ){
                    alert('처리되었습니다.', 'reload');
                }else{
                    alert('일시적인 오류 입니다. 다시 시도해 주세요', 'reload');
                }
            });
        }else location.reload();
    });
});

$(document).on('click', '.js-del-row', function(){
    if( !$('input[name="anos[]"]:checked').length ){
        alert('선택된 항목이 없습니다.');
        return;
    }
    let anos = [];
    $('input[name="anos[]"]:checked').each(function(){
        anos.push( $(this).val() );
    })
    Swal.fire({
        title: '정말 삭제 하시겠습니까?',
        text: '삭제 후 복원이 불가능 할 수 있습니다.',
        icon: 'question',
        allowOutsideClick: false,
        scrollbarPadding: false,
        showCancelButton: true,
        confirmButtonText: '삭제',
        cancelButtonText: '취소'
    }).then((result) => {
        if( result.value === true ){
            $.when( ajax_from({ano: anos, table: $(this).data('table') }, '/del-ajax-basic') ).done(function(data){
                if( data === true ){
                    alert('처리되었습니다.', 'reload');
                }else{
                    alert('일시적인 오류 입니다. 다시 시도해 주세요', 'reload');
                }
            });
        }else location.reload();
    });
});

const get_anos=()=>{
    let ano = [];
    $('input[name="anos[]"]:checked').each(function(){
        ano.push( $(this).val() );
    })
    return ano;
};
