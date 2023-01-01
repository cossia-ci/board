let td_html_b = ``;
const td_html_null = `타입을 선택하세요`,
td_html_f = `연결 가능한 페이지가 없습니다.<input name="link" type="hidden" value="">`,
td_html_d = `ROUTES 설정에 맞춰 연결됩니다.<input name="link" type="hidden" value="">`,
td_html_h = `<input name="link" type="text" value="">`,
select_warp = `<select name="link">%option%</select>`,
tree = $('#tree').jstree({
    core: {
		data:
        [{ id: '0', ano: '0', text: 'Home', state: {opened: true}, type: 'home',
           children: menuList
        }],
        force_text: true,
		check_callback: true,
	},
	types: {
		'#': {max_depth: 7},
		f: {icon: 'fad fa-folder'},   // valid_children 폴더만 자식을 가질 수 있다
        h: {icon: 'fab fa-html5', valid_children: []},
        b: {icon: 'fad fa-clipboard-list', valid_children: []},
        i: {icon: 'fad fa-info-circle', valid_children: []},
        s: {icon: 'fad fa-question-circle', valid_children: []},
        d: {icon: 'fab fa-dev', valid_children: []},
		hide: {icon: 'fad fa-eye-slash', valid_children: []},
        home: {icon: 'fad fa-home'}
	},
	plugins: ['dnd','types']
}).on('loaded.jstree', function() {
    tree.jstree('open_all');
}),
add_node=()=>{
	const node = selected_node();
    if( !(node.original.type == 'f' || node.original.type == 'home') ){
        alert('Home 또는 폴더만 하위생성 가능합니다.');
        return false;
    }
	if( node ){
		disabl_false();
        set_input_value('ano', 0);
        set_input_value('parent', node.original.ano);
        check_radio('isView', 'y');
        check_radio('type', 'f');
        set_input_value('name', '');
        set_td_html(td_html_f);
	}
    hide_dev_td();
},
edit_node=()=>{
    const node = selected_node();
	if( node.id == '0' ){
		alert('수정이 불가능합니다.');
		return;
	}
	if( node ){
		disabl_false();
		check_radio('isView', node.original.isView);
		check_radio('type', node.original.type);
        set_for_type( node.original.type );
		set_input_value('ano', node.original.ano);
		set_input_value('parent', node.original.parent);
		set_input_value('sort', node.original.sort);
		set_input_value('code', node.original.code);
		set_input_value('name', node.original.name);

        set_input_value('imgPath', node.original.imgPath);

        

        set_input_value('folder', node.original.folder);
        set_input_value('controller', node.original.controller);
        set_input_value('class', node.original.class);
        hide_dev_td();
        switch( node.original.type ){
            case 'h' :
                set_input_value('link', node.original.link);
            break;
            case 'd' :
                un_hide_dev_td();
            break;
            case 'f' : break;
            default :
                set_select_value('link', node.original.link);
        }
	}
},
selected_node = () => {
    const node = $('#tree').jstree('get_selected', true)[0];
    if( !node ) {
		alert('선택된 메뉴가 없습니다.');
		return false;
	}else return node;
},
disabl_false=()=>{
	$(`#frms input`).prop('disabled', false);
    $(`.btn-save`).prop('disabled', false);
},
disabl_true=()=>{
	$(`#frms input`).prop('disabled', true);
    $(`.btn-save`).prop('disabled', true);
},
set_input_value=(name, value)=>{
	$(`input[name="${name}"]`).val( value );
},
set_select_value=(name, value)=>{
    $(`select[name="${name}"]`).val(value).prop('selected', true);
},
check_radio=(name, val)=>{
	$(`input:radio[name="${name}"]:radio[value="${val}"]`).prop('checked', true);
},
set_td_html = (type) => {
    $('#link-td').html( type );
},
set_board_html=()=>{
    let html = '';
    $.each(boardList, function(k, v){
        html += `<option value="${v.code}">${v.name}</option>`;
    });
    td_html_b = select_warp.co_split({option: html});
},
set_info_html=(type)=>{
    let html = '';
    $.each(type, function(k, v){
        html += `<option value="${k}">${v}</option>`;
    });
    td_html_b = select_warp.co_split({option: html});
}
add_first_page=()=>{
    td_html_b = `<input name="landPage" type="radio" value="list" id="landPage-list" checked>
                <label for="landPage-list">리스트 페이지</label>
                <input name="landPage" type="radio" value="write" id="landPage-write">
                <label for="landPage-write">작성 페이지</label>` + td_html_b;
},
set_for_type=( type )=>{
    hide_dev_td();
    switch( type ){
        case 'f'    :   set_td_html(td_html_f);     break;
        case 'h'    :   set_td_html(td_html_h);     break;
        case 'b'    :
            set_board_html();
            // add_first_page();
            set_td_html(td_html_b);
        break;
        case 'i'    :
            set_info_html(infoList);
            set_td_html(td_html_b);
        break;
        case 's'    :
            set_info_html(spsList);
            // add_first_page();
            set_td_html(td_html_b);
        break;
        case 'd' :
            set_td_html(td_html_d);
            un_hide_dev_td();
        break;
    }
},
hide_dev_td=()=>{
    $('.dev-input').addClass('hide');
},
un_hide_dev_td=()=>{
    $('.dev-input').removeClass('hide');
},
del_node=()=>{
	const node = selected_node();
    if( node ){
        let ano = node.children_d;
        ano.push( node.id );
        Swal.fire({
            title: '카테고리 삭제',
            html: '하위 카테고리 포함 삭제 됩니다.<br>삭제 후 복구가 불가능 합니다.<br>정말 삭제 하시겠습니까?',
            icon: 'question',
            allowOutsideClick: false,
            scrollbarPadding: false,
            showCancelButton: true,
            confirmButtonText: '확인',
            cancelButtonText: '취소'
        }).then((result) => {
            if( result.value === true ){
                console.log( ano );
                $.when( ajax_from({table: 'front-menu', ano: ano}, '/del-ajax-basic') ).done(function(data){
                    if( data ){
                        alert('처리되었습니다.','reload','success');
                    }else{
                        alert('일시적 오류 입니다. 다시 시도해 주세요');
                    }
                });
            }
        });
    }
};

tree.on('move_node.jstree', function (e, d) {
	const param = $('#tree').jstree(true).get_json('#',{flat:true});
    $.each(param, function(key, val){
        if( key != 0 ) param[key].isView = $("#tree").jstree(true).get_node(val.id).original.isView;
    });
    $.when( ajax_from({data: param, type: 'frontsort'}, '/admin-menu-post') ).done(function(data){
		location.reload();
    });
});

$(function(){
    $(document).on('click', '.js-tree-act', function(){
		switch( $(this).data('act') ){
			case 'add'  :	add_node();		break;
			case 'edit' :	edit_node();	break;
			case 'del'  :	del_node();		break;
		}
	});

    $(document).on('click', 'input[name="type"]', function(){
        set_for_type( $(this).val() );
    })
});

$('#frms').validate({
    rules: {
        name: { required: true },
        link: {
			required: function(){
                return $('input[name="type"]:checked').val() == 'f' || $('input[name="type"]:checked').val() == 'd' ? false : true;
            },
			remote: {
				headers : {'X-CSRF-TOKEN': $('meta[name="X-CSRF-TOKEN"]').attr('content')},
				url: '/overlap-front-menu',
				type: 'post',
				dataType: 'json',
				data:{
                    link: function(){
                        const type = $('#frms input[name="link"]').prop('type'),
                              value = type=='text' ? $('#frms input[name="link"]').val() : $('#frms select[name="link"]:selected').val();
                        return value;
                    },
					ano: function(){ return $('#frms input[name="ano"]').val(); },
					type: function(){ return $('#frms input[name="type"]:checked').val(); }
				}
			}
		}
    }
});