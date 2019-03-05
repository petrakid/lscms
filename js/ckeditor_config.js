CKEDITOR.editorConfig = function( config ) {
     config.filebrowserBrowseUrl = 'js/filemanager/dialog.php?type=2&editor=ckeditor&fldr=';
     config.filebrowserUploadUrl = 'js/filemanager/dialog.php?type=2&editor=ckeditor&fldr=';
     config.filebrowserImageBrowseUrl = 'js/filemanager/dialog.php?type=1&editor=ckeditor&fldr=';
     
     config.removePlugins = 'find,pagebreak,templates,about,showblocks,newpage,language';
     config.removeButtons = 'Form,TextField,Textarea,Button,SelectAll,CreateDiv,Select,HiddenField';
     config.allowedContent = true;
     
     //config.skin = 'bootstrapck, js/ckeditor/skins/bootstrapck/';
};