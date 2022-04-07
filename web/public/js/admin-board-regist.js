$('#frms').validate({
    rules: {
        code: {
            required: true,
            remote: {
                headers : {'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').prop('content')},
                url: '/overlap-custom',
                type: 'post',
                dataType: 'json',
                data:{
                    table: 'board_list',
                    filde: 'code',
                    code: function(){ return $('input[name="code"]').val(); }
                }
            }
        },
        name: {required: true},
        'list[notice]': {required: true, number: true},
        'list[perPage]': {required: true, number: true},
        'list[new]': {required: true, number: true},
        'list[hot]': {required: true, number: true},
    },
    submitHandler: function(frm){
        const arr = ['comment', 'replay', 'list', 'read', 'write'];
        let bool = true;
        $.each(arr, function(k, v){
            if( $(frm).find(`input[name="auth[${v}]"]:checked`).val() == 'sps' )
                if( $(`input[name="auth[${v}sps][]"]`).length == 0 ) bool = false;
        });
        if( !bool ) alert('특정회원 등급이 선택되지 않았습니다.');
        return bool;
    }
});
let idx = 500;
const horse_li = `<li id="horse-%index%" >
                    <input name="item[horse][]" type="hidden" value="%value%">%value%
                    <span class="fad fa-trash-alt" onclick="$('#horse-%index%').remove()"></span>
                  </li>`,
sps_li = `<li id="sps-%name%-%index%" >
            <input name="auth[%name%sps][]" type="hidden" value="%ano%">%levNm%
            <span class="fad fa-trash-alt" onclick="remove_level(this)" data-name="%name%" data-index="%index%"></span>
          </li>`,
level_table = `<table class="table-row">
                    <colgroup>
                        <col width="55px">
                        <col>
                    </colgroup>
                    <thead>
                        <th>선택</th><th>등급명<input name="level_target" type="hidden" value="%target%"></th>
                    </thead>
                    <tbody>%tbody%</tbody>
                </table>`,
level_tr = `<tr>
                <td class="text-center"><input name="l_ano[]" type="checkbox" id="ano-%ano%" value="%ano%" data-name="%name%"><label for="ano-%ano%"></label></td>
                <td class="text-center">%name%</td>
            </tr>`,
add_horse=(value)=>{
    const bool = count_horse( value );
    if( bool ){
        alert('같은 값이 존재 합니다.');
        return;
    }
    $('#horse-ul').append( horse_li.co_split({index: idx++, value: value}) );
},
count_horse=(value)=>{
    let bool = false;
    $('input[name="item[horse][]"]').each(function(){
        if( value == $(this).val() ) bool = true;
    });
    return bool;
},
level_selected=()=>{
    if( $('input[name="l_ano[]"]:checked').length == 0 ){
        non_level_element( $('input[name="level_target"]').val() );
        return;
    }
    let lis = '';
    $('input[name="l_ano[]"]:checked').each(function(){
        lis += sps_li.co_split({
            name: $('input[name="level_target"]').val(),
            index: idx++,
            ano: $(this).val(),
            levNm: $(this).data('name')
        });
    });
    $(`#${$('input[name="level_target"]').val()}-ul`).html(lis);
},
non_level_element=(name)=>{
    $(`input[name="auth[${name}]"][value="all"]`).trigger('click');
    alert('특정회원의 값이 없습니다. 전체로 전환 합니다.');
},
remove_level=(obj)=>{
    $(`#sps-${$(obj).data('name')}-${$(obj).data('index')}`).remove();
    if( $(`input[name="auth[${$(obj).data('name')}sps][]"]`).length == 0 )
        non_level_element( $(obj).data('name') );
},
get_radio_name = (name) => {
    return name.replace(/auth\[/g, '').replace(/\]/g, '');
};
$(function(){
    $(document).on('keydown', 'input[name="horse"]', function(key){
        if(key.keyCode == 13){
            if( $(this).val() ) add_horse( $(this).val() );
            $(this).val( '' );
        } 
    })
    $(document).on('click', 'input[name="auth[comment]"], input[name="auth[replay]"], input[name="auth[list]"], input[name="auth[read]"], input[name="auth[write]"]', function(){
        const btn = $(this).parents('td').children('button'),
              name = get_radio_name( $(this).prop('name') );
        switch( $(this).val() ){
            case 'sps' : $(btn).prop('disabled', false); break;
            default :
                $(btn).prop('disabled', true);
                $(`#${name}-ul`).html('');
        }
    });
    $(document).on('click', '.btn-gray', function(){
        let tbody = '';
        $.each(memLevels, function(k, v){
            tbody += level_tr.co_split( {ano: v.ano, name: v.name} );
        });
        Swal.fire({
            title: '선택하세요',
            confirmButtonText: '선택완료',
            showCancelButton: true,
            cancelButtonText: '취소',
            allowOutsideClick: false,
            html: level_table.co_split( {tbody: tbody, target: $(this).data('target')} )
        }).then( (result) => {
            if (result.isConfirmed) {
                level_selected();
            }
        })
    });
    
    $(document).on('click', 'input[name="type"]', function(){
        if( $(this).val() == 'write' ){
            $('.board-nomal').addClass('hide');
            $('.board-write').removeClass('hide');
        }else{
            $('.board-write').addClass('hide');
            $('.board-nomal').removeClass('hide');
        }
    })

    $(document).on('click', 'input[name="write[email]"]', function(){
        const $inp = $('input[name="write[sendmail]"]');
        $inp.prop('disabled', true);
        if( $(this).val() == 'm' ) $inp.prop('disabled', false);
        
    })

    
})