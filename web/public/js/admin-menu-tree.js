const tree = $('#tree').jstree({
    core: {
		data:
        [{ id: '0', ano: '0', text: 'Home', state: {opened: true}, type: 'home',
           children: menuList
        }],
        force_text: true,
		check_callback: true,
	},
	types: {
		'#': {max_depth: 4},
		folder: {icon: 'fad fa-folder'},
		hide: {icon: 'fad fa-eye-slash', valid_children: []},
        controller: {icon: 'fad fa-file-code', valid_children: []},
        home: {icon: 'fad fa-home'}
	},
	plugins: ['dnd','types']
}).on('loaded.jstree', function() {
    tree.jstree('open_all');
}),
add_node=()=>{
	const node = selected_node();
	if( node ){
		disabl_false('switch-de');
        set_input_value('ano', 0);
        set_input_value('parent', node.original.ano);
	}
},
disabl_false=(clsNm)=>{
	$(`.${clsNm}`).prop('disabled', false);
},
disabl_true=(clsNm)=>{
	$(`.${clsNm}`).prop('disabled', true);
},
set_input_value=(name, value)=>{
	$(`input[name="${name}"]`).val( value );
},
selected_node = () => {
    const node = $('#tree').jstree('get_selected', true)[0];
    if( !node ) {
		alert('선택된 메뉴가 없습니다.');
		return false;
	}else return node;
},
edit_node = () =>{
	const node = selected_node();
	if( node.id == '0' ){
		alert('수정이 불가능합니다.');
		return;
	}
	if( node ){
		disabl_false('switch-de');
		check_radio('isView', node.original.isView);
		check_radio('type', node.original.type_);
		set_input_value('ano', node.original.ano);
		set_input_value('parent', node.original.parent);
		set_input_value('sort', node.original.sort);
		set_input_value('icons', node.original.icons);
		set_input_value('code', node.original.code);
		set_input_value('name', node.original.name);
		set_input_value('folder', node.original.folder);
		set_input_value('controller', node.original.controller);
		set_input_value('class', node.original.class);
	}
},
check_radio=(name, val)=>{
	$(`input:radio[name="${name}"]:radio[value="${val}"]`).prop('checked', true);
};

tree.on('move_node.jstree', function (e, d) {
	const param = $('#tree').jstree(true).get_json('#',{flat:true});
    $.each(param, function(key, val){
        if( key != 0 ) param[key].isView = $("#tree").jstree(true).get_node(val.id).original.isView;
    });
    $.when( ajax_from({data: param, type: 'sort'}, '/admin-menu-post') ).done(function(data){
		location.reload();
    });
})

$(function(){
    $(document).on('click', '.js-tree-act', function(){
		switch( $(this).data('act') ){
			case 'add'  :	add_node();		break;
			case 'edit' :	edit_node();	break;
			case 'del'  :	del_node();		break;
		}
	});
})