CKEDITOR.editorConfig = function( config ) {
    config.format_tags = 'p;h1;h2;h3;pre';
    config.language = 'ko';
    config.removeDialogTabs = 'image:advanced;link:advanced';
    config.baseFloatZIndex = 6;
    config.dialog_noConfirmCancel = true;
    config.enterMode = CKEDITOR.ENTER_BR;
    config.allowedContent = {
		$1: {
			elements: CKEDITOR.dtd,
			attributes: true,
			styles: true,
			classes: true
		}
	};
	config.disallowedContent = 'script; *[on*]';
	config.removeFormatTags = 'svg,let,const,script';
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'align' ] },
		{ name: 'editing'},
		{ name: 'links'},
		{ name: 'insert'},
		{ name: 'tools'},
		'/',
		{ name: 'basicstyles', groups: [ 'fontsize', 'styles', 'basicstyles', 'colors', 'cleanup',  ] },
    ];
	config.removeButtons = 'Iframe,SelectAll,Scayt,Save,NewPage,Preview,Print,Templates';
	config.removePlugins = 'exportpdf';
};