CKEDITOR.editorConfig = function( config ) {

     config.filebrowserBrowseUrl = 'js/filemanager/dialog.php?type=2&editor=ckeditor&fldr=';
     config.filebrowserUploadUrl = 'js/filemanager/dialog.php?type=2&editor=ckeditor&fldr=';
     config.filebrowserImageBrowseUrl = 'js/filemanager/dialog.php?type=1&editor=ckeditor&fldr=';
     config.allowedContent = true;
     //config.skin = 'bootstrapck, js/ckeditor/skins/bootstrapck/';
	config.toolbarGroups = [
		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
		{ name: 'forms', groups: [ 'forms' ] },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
		{ name: 'links', groups: [ 'links' ] },
		{ name: 'insert', groups: [ 'insert' ] },
		'/',
		{ name: 'styles', groups: [ 'styles' ] },
		{ name: 'colors', groups: [ 'colors' ] },
		{ name: 'tools', groups: [ 'tools' ] },
		{ name: 'others', groups: [ 'others' ] },
		{ name: 'about', groups: [ 'about' ] }
	];

	config.removeButtons = 'Save,NewPage,Preview,Templates,Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Language,Iframe,PageBreak,Styles,About,Checkbox';     

};