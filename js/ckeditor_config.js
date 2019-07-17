var url = new URL(window.location.href);
var href = url.protocol +'//'+ url.hostname;

CKEDITOR.plugins.addExternal('sourcedialog', href +'/js/ckeditor/plugins/sourcedialog/', 'plugin.js');
CKEDITOR.plugins.addExternal('panelbutton', href +'/js/ckeditor/plugins/panelbutton/', 'plugin.js');
CKEDITOR.plugins.addExternal('floatpanel', href +'/js/ckeditor/plugins/floatpanel/', 'plugin.js');
CKEDITOR.plugins.addExternal('bootstrapGrid', href +'/js/ckeditor/plugins/bootstrapGrid/', 'plugin.js');
CKEDITOR.plugins.addExternal('clipboard', href +'/js/ckeditor/plugins/clipboard/', 'plugin.js');
CKEDITOR.plugins.addExternal('notification', href +'/js/ckeditor/plugins/notification/', 'plugin.js');
CKEDITOR.plugins.addExternal('toolbar', href +'/js/ckeditor/plugins/toolbar/', 'plugin.js');
CKEDITOR.plugins.addExternal('button', href +'/js/ckeditor/plugins/button/', 'plugin.js');
CKEDITOR.plugins.addExternal('widgetselection', href +'/js/ckeditor/plugins/widgetselection/', 'plugin.js');
CKEDITOR.plugins.addExternal('lineutils', href +'/js/ckeditor/plugins/lineutils/', 'plugin.js');
CKEDITOR.plugins.addExternal('widget', href +'/js/ckeditor/plugins/widget/', 'plugin.js');
CKEDITOR.plugins.addExternal('html5audio', href +'/js/ckeditor/plugins/html5audio/', 'plugin.js');
CKEDITOR.editorConfig = function( config ) {

     config.filebrowserBrowseUrl = 'js/filemanager/dialog.php?type=2&editor=ckeditor&fldr=';
     config.filebrowserUploadUrl = 'js/filemanager/dialog.php?type=2&editor=ckeditor&fldr=';
     config.filebrowserImageBrowseUrl = 'js/filemanager/dialog.php?type=1&editor=ckeditor&fldr=';
     config.allowedContent = true;
     config.extraPlugins = 'html5audio, sourcedialog, panelbutton, floatpanel, bootstrapGrid, lineutils, widget, widgetselection, clipboard, notification, toolbar, button';
     config.contentsCss = 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css';
     config.mj_variables_bootstrap_css_path = 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css';
     config.bootstrapGrid_container_large_desktop = 1170;
     config.bootstrapGrid_container_desktop = 970;
     config.bootstrapGrid_container_tablet = 750;
     config.bootstrapGrid_grid_columns = 12;
     config.skin = 'bootstrapck, '+ href +'/js/ckeditor/skins/bootstrapck/';
     config.toolbar = [
     	{ name: 'document', items: [ 'Sourcedialog', '-', 'Preview' ] },
     	{ name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
     	{ name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
     	'/',
     	{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
     	{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl' ] },
     	{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor', 'Button' ] },
     	{ name: 'insert', items: [ 'Image', 'Flash', 'Html5audio', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
     	'/',
     	{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
     	{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
     	{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
          { name: 'grid', items: [ 'BootstrapGrid', 'BootstrapGridAdd', 'BootstrapGridDelete' ] },
     	{ name: 'others', items: [ '-' ] },
     ];

	config.removeButtons = 'Form,Checkbox,Radio,TextField,Textarea,Select,ImageButton,HiddenField,Save,NewPage,Print,Templates,Language,Styles,About';
};