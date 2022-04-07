CKEDITOR.editorConfig = function( config ) {
	config.removeButtons = 'Underline,Subscript,Superscript';
    config.format_tags = 'p;h1;h2;h3;pre';
    config.language = 'ko';
    config.removeDialogTabs = 'image:advanced;link:advanced';
    config.extraPlugins = 'justify';
	config.extraPlugins = 'codesnippet';
	config.codeSnippet_theme = 'monokai_sublime';
    config.baseFloatZIndex = 6;
    config.dialog_noConfirmCancel = true;
    config.enterMode = CKEDITOR.ENTER_BR;
    config.allowedContent = true;
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others'},
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
    ];
};