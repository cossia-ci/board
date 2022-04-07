$(function(){
    $('input').prop('autocomplete','off');
    $('img').each(function(k, v){
        if( v.src != '' && v.complete == true && v.naturalWidth == 0 ){
            $(this).prop('src', '/images/no-img.jpg');
        }
    });
    $(document).on('click', '.js-all-click', function(){
        if( $(this).is(':checked') ) $(`input[name="${ $(this).data('target') }"]`).prop('checked', true);
        else $(`input[name="${ $(this).data('target') }"]`).prop('checked', false);
    });

    $(document).on('keyup change', '.num-only', function() {
		$(this).val( $(this).val().replace(/[^0-9]/g, '') );
	});
    $(document).on('keyup change', '.eng-only', function() {
		$(this).val( $(this).val().replace(/[^a-zA-Z]/g, '') );
	});
    $(document).on('keyup change', '.num-eng', function() {
		$(this).val( $(this).val().replace(/[^a-zA-Z0-9]/g, '') );
	});
	$(document).on('keyup', '.phone', function() {
		$(this).val( $(this).val().replace(/[^0-9]/g, '').replace(/(^02|^0505|^1[0-9]{3}|^0[0-9]{2})([0-9]+)?([0-9]{4})$/,"$1-$2-$3").replace('--', '-') );
	});
    $('.phone').prop({maxlength: 13, placeholder: '하이픈(-) 자동입력'});
	$('.bizNo').prop({maxlength: 12, placeholder: '하이픈(-) 자동입력'});
	$(document).on('keyup', '.bizNo', function() {
		$(this).val( $(this).val().replace(/[^0-9]/g, '').replace(/([0-9]{3})([0-9]{2})([0-9]+)/, '$1-$2-$3').replace('--', '-') );
	});
    $(document).on('change', 'input', function(){
        $(this).val( $(this).val().trim() );
    })
})

$.validator.addMethod('pwCheck', function (value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/.test(value);
});
$.extend(
    $.validator.messages, {
        required: '필수 항목입니다.',
        remote: '사용이 불가능합니다.',
        email: '유효하지 않은 E-Mail주소입니다.',
        url: '유효하지 않은 URL입니다.',
        date: '올바른 날짜를 입력하세요.',
        dateISO: '올바른 날짜(ISO)를 입력하세요.',
        number: '유효한 숫자가 아닙니다.',
        digits: '숫자만 입력 가능합니다.',
        creditcard: '신용카드 번호가 바르지 않습니다.',
        equalTo: $.validator.format('{0}와 같은 값을 입력하세요.'),
        extension: '올바른 확장자가 아닙니다.',
        maxlength: $.validator.format('{0}자를 넘을 수 없습니다.'),
        minlength: $.validator.format('{0}자 이상 입력하세요.'),
        rangelength: $.validator.format('문자 길이가 {0} 에서 {1} 사이의 값을 입력하세요.'),
        range: $.validator.format('{0} 에서 {1} 사이의 값을 입력하세요.'),
        max: $.validator.format('{0} 이하의 값을 입력하세요.'),
        min: $.validator.format('{0} 이상의 값을 입력하세요.'),
        pwCheck: '최소6자 [대문자, 소문자, 숫자] 각 하나 이상'
    });
$.validator.setDefaults({
    // onfocusout: false,
    errorElement: 'span',
    errorPlacement: function (error, element) {
        switch( element.prop('type') ){
            case 'checkbox' : case 'radio': case 'file':
                error.insertAfter( element.next('label') );
            break;
            case 'textarea' :
                error.insertAfter( element.next('div') );
            break;
            default:
                error.insertAfter( element );
        }
    },
});

var alert = (msg, url, type) => {
    Swal.fire({
        title: 'Information',
        html: msg,
        allowOutsideClick: false,
        timer: 2000,
        icon: (type != undefined && type != '') ? type : 'info',
    }).then(() => {
        switch (url) {
            case 'reload'   :   location.reload();  break;
            case 'back()'   :   history.back();     break;
            default:
                if (url != undefined && url != '') window.location.replace(url);
        }
    });
},
upload_file = (obj) => {
    let ext = $(obj).val().split('.').pop().toLowerCase(),
        accept = $(obj).attr('accept'),
        reg = ( accept ) ? accept.replace(/\./g, '').co_trim().split(',') : null,
        bool = ( reg && $.inArray(ext, reg) === -1 ) ? false : true,
        img_ext = ['bmp','gif','jpg','jpeg','png','ico'],
        icon_ext = ['svg','js','doc','xml','pdf','zip','mp3','mp4','eps','avi','ai','fla','psd','bin','exe','mkv','wmv','mov','ppt','iso','jar','vcf','obj','html','dll','asp','dwg','eml','txt','3ds','ini','otf','ttf','pkg','com','nfo','wav','rtf','xls','csv','dbf','css'];
    if(!bool){
        alert( reg.join(', ') + ' 파일만 업로드 할수 있습니다.');
        $(obj).val('');
        $( 'label[for="' + $(obj).attr('id') + '"]' ).attr( 'data-content', '' );
        $( '#' + $(obj).data('preview') ).attr( 'src', '/images/no-img.jpg' );
        return;
    }
    if( $.inArray(ext, img_ext) !== -1 ) preview_image(obj);
    else if($.inArray(ext, icon_ext) !== -1) $( '#' + $(obj).data('preview') ).attr( 'src', '/images/file_type/'+ext+'.png' );
    else $( '#' + $(obj).data('preview') ).attr( 'src', '/images/file_type/etc.png' );
    $( 'label[for="' + $(obj).attr('id') + '"]' ).attr( 'data-content', $(obj).val().split('\\').reverse()[0] );
},
preview_image = (input) => {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $( '#' + $(input).data('preview') ).attr( 'src', e.target.result );
        }
        reader.readAsDataURL( input.files[0] );
    }
},
ajax_from = function(data, url){
    "use strict";
    return $.ajax({
        headers : {'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')},
        url : url,
        type : 'POST',
        data : data,
        dataType : 'json',
        success : function(response){},
        error : function(request,status,error){
            console.log("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
        }
    });
},
sort_input_index = (classNm) => {
    $(`.${classNm}`).each(function(idx, item){
        $(item).find(':input').each(function(){
            const name = $(this).prop('name').replace(/\[\d\]/g, `[${idx}]`);
            $(this).prop('name', name);
        });
    });
},
set_post = (obj) => {
	new daum.Postcode({
		oncomplete: function(data) {
			let addr = '';
			let extraAddr = '';
			if (data.userSelectedType === 'R')
			    addr = data.roadAddress;
			else
				addr = data.jibunAddress;
			if(data.userSelectedType === 'R'){
				if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)) extraAddr += data.bname;
				if(data.buildingName !== '' && data.apartment === 'Y')
					extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
				if(extraAddr !== '') extraAddr = ' (' + extraAddr + ')';
            }
			$('input[name="'+$(obj).data('post')+'"]').val(data.zonecode);
			$('input[name="'+$(obj).data('add')+'"]').val(addr);
			$('input[name="'+$(obj).data('focus')+'"]').focus();
		}
	}).open();
};

String.prototype.co_split = String.prototype.co_split || function () { 
    "use strict";
    let str = this.toString();
    if (arguments.length) {
        let t = typeof arguments[0],
            key,
            args = ("string" === t || "number" === t) ? Array.prototype.slice.call(arguments) : arguments[0];
        for (key in args) {
            str = str.replace(new RegExp("\\%" + key + "\\%", "gi"), args[key]);
        }
    }
    return str;
};
String.prototype.co_trim = String.prototype.co_trim || function () {
    "use strict";
    return this.replace(/ /gi, '');
};