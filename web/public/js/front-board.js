$(function(){
    $(document).on('click', 'a[href$="secret"]', function(){
        const code = $(this).data('code'),
              ano = $(this).data('ano');
        Swal.fire({
            title: '비밀번호를 입력해주세요',
            input: 'password',
            allowOutsideClick: false,
            inputAttributes: {
                autocapitalize: 'off'
            },
            confirmButtonText: '확인',
            cancelButtonText: '취소',
            showLoaderOnConfirm: true,
            showCancelButton: true,
            preConfirm: (password) => {
                const param = {ano: ano, code: code, pw: password};
                return $.when( ajax_from(param, '/bdpw-validat') ).done(function(data){
                    if( data == true ) window.location.replace(`/bdread/${code}/${ano}`);
                    else Swal.showValidationMessage('비밀번호가 일치하지 않습니다.');
                    });
            }
        })
    });

    $(document).on('click', 'a[href$="delete"]', function(){
        const code = $(this).data('code'),
              ano = $(this).data('ano');
        Swal.fire({
            title: '정말 삭제 하시겠습니까?',
            text: '삭제후 복원이 불가능 합니다.',
            icon: 'warning',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '삭제',
            cancelButtonText: '취소',
        }).then((result) => {
            if (result.isConfirmed) {
                const param = {ano: ano, code: code};
                $.when( ajax_from(param, '/requst-board-delete') ).done(function(data){
                    if( data == true ) alert('처리되었습니다.', `/bdlist/${code}`);
                    else alert('일시적 오류 입니다. 다시 시도해 주세요');
                });
            }
        });
    });
});

$('#cmt').validate({
    rules: {
        comment: { required: true },
    }
});
