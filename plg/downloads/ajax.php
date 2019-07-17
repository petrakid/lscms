<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['edit'])) {
     $sql = $db->query("SELECT * FROM $_SESSION[prefix]_downloads WHERE d_id = $_POST[d_id]");
     $dln = $sql->fetch(PDO::FETCH_ASSOC);
     ?>
     <form method="POST" action="<?php echo $gbl['site_url'] ?>/plg/downloads/ajax.php" enctype="multipart/form-data">
     <input type="hidden" name="callback" value="<?php echo $gbl['site_url'] ?>/<?php echo $_POST['callback'] ?>" />
     <input type="hidden" name="did" value="<?php echo $dln['d_id'] ?>" />
     <div class="form-group">
     <b>Download Title</b><br />
     <div class="col-sm-8 input-group">
     <input type="text" placeholder="Download Title" value="<?php echo $dln['download_title'] ?>" name="downloadtitle" id="downloadtitle" required="required" class="form-control" />
     </div>
     </div>

     <div class="form-group">
     <b>Download Date</b><br />
     <div class="col-sm-4 input-group">
     <input type="date" value="<?php echo $dln['download_date'] ?>" name="downloaddate" id="downloaddate" class="form-control datepicker" /><div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
     </div>
     </div>
    
     <div class="form-group">
     <b>Author</b><br />
     <div class="col-sm-8 input-group">
     <input type="text" placeholder="Title First Last" value="<?php echo $dln['download_author'] ?>" name="downloadauthor" id="downloadauthor" required="required" class="form-control" />
     </div>
     </div>     

     <div class="form-group">
     <b>Description</b><br />
     <div class="col-sm-10 input-group">
     <input type="text" placeholder="Description" value="<?php echo $dln['download_description'] ?>" name="downloaddesc" id="downloaddesc" class="form-control" />
     <span id="helpBlock" class="help-block">This can be anything to help the viewer become familiar with the resource before downloading.</span>
     </div>
     </div>

     <p class="help-block">You can change the document file below.  The current file will be overrided.</p>
     <div class="form-group">
     <label for="dlfile">Downloadable File</label>
     <input type="file" id="dlfile" name="dlfile" />
     <p class="help-block">You may use audio/mp3 files, Most Microsoft Office type files, and Adobe PDF files.  If you're not sure if the file you're uploading will be accepted, try uploading it.  It will not complete if it is an unacceptable filetype.</p>
     </div>

     <div class="well well-sm" style="text-align: center;">You can add a file for download OR include an embedded video url, but NOT BOTH!  Create a separate downloadable if you need both.</div>

     <div class="form-group">
     <b>Youtube Video Embed URL</b><br />
     <div class="col-sm-8 input-group">
     <input type="text" placeholder="Embed URL" value="<?php echo $dln['download_embed_url'] ?>" name="embedurl" id="embedurl" class="form-control" />
     <span id="helpBlock" class="help-block">This is NOT the link/url of the video, but the EMBED url, which can be found in the Sharing options for the video.  You'll see the Embed code, and in the code, you'll see the url.  Copy JUST the url (from https:// to the end of the url) and paste here.</span>
     </div>
     </div>
 
     <input type="submit" name="update_download" id="update_download" value="Update Download" class="btn btn-warning btn-block" />
     <span id="helpBlock" class="help-block">If you've included an audio file and/or pdf file, this will take some time.  Your browser is NOT stuck.</span>
     </form>      
     <?php
}

if(isset($_POST['del'])) {
     $db->exec("UPDATE $_SESSION[prefix]_downloads SET download_status = 0 WHERE d_id = $_POST[d_id]");
     echo 'Download Deleted.';
}

if(isset($_POST['res'])) {
     $db->exec("UPDATE $_SESSION[prefix]_downloads SET download_status = 1 WHERE d_id = $_POST[d_id]");
     echo 'Download Restored.'; 
}

if(isset($_POST['new_download'])) {
     ?>
     <form method="POST" action="<?php echo $gbl['site_url'] ?>/plg/downloads/ajax.php" enctype="multipart/form-data">
     <input type="hidden" name="callback" value="<?php echo $gbl['site_url'] ?>/<?php echo $_POST['callback'] ?>" />
     <input type="hidden" name="page_id" value="<?php echo $_POST['page_id'] ?>" />
     <div class="form-group">
     <b>Download Title</b><br />
     <div class="col-sm-8 input-group">
     <input type="text" placeholder="Download Title" name="downloadtitle" id="downloadtitle" required="required" class="form-control" />
     </div>
     </div>

     <div class="form-group">
     <b>Download Date</b><br />
     <div class="col-sm-4 input-group">
     <input required="required" type="date" name="downloaddate" id="downloaddate" class="form-control datepicker" /><div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
     </div>
     </div>
    
     <div class="form-group">
     <b>Author</b><br />
     <div class="col-sm-8 input-group">
     <input type="text" placeholder="Title First Last" name="downloadauthor" id="downloadauthor" required="required" class="form-control" />
     </div>
     </div>     

     <div class="form-group">
     <b>Description</b><br />
     <div class="col-sm-10 input-group">
     <input type="text" placeholder="Description" name="downloaddesc" id="downloaddesc" class="form-control" />
     <span id="helpBlock" class="help-block">This can be anything to help the viewer become familiar with the resource before downloading.</span>
     </div>
     </div>

     <div class="form-group">
     <label for="dlfile">Downloadable File</label>
     <input type="file" id="dlfile" name="dlfile" />
     <p class="help-block">You may use audio/mp3 files, Most Microsoft Office type files, and Adobe PDF files.  If you're not sure if the file you're uploading will be accepted, try uploading it.  It will not complete if it is an unacceptable filetype.</p>
     </div>

     <div class="well well-sm" style="text-align: center;">You can add a file for download OR include an embedded video url, but NOT BOTH!  Create a separate downloadable if you need both.</div>

     <div class="form-group">
     <b>Youtube Video Embed URL</b><br />
     <div class="col-sm-8 input-group">
     <input type="text" placeholder="Embed URL" name="embedurl" id="embedurl" class="form-control" />
     <span id="helpBlock" class="help-block">This is NOT the link/url of the video, but the EMBED url, which can be found in the Sharing options for the video.  You'll see the Embed code, and in the code, you'll see the url.  Copy JUST the url (from https:// to the end of the url) and paste here.</span>
     </div>
     </div>
 
     <input type="submit" name="add_download" id="add_download" value="Add Downloadable" class="btn btn-warning btn-block" />
     <span id="helpBlock" class="help-block">If you've included an audio file and/or pdf file, this will take some time.  Your browser is NOT stuck.</span>
     </form>      
     <?php
}

if(isset($_POST['add_download'])) {
     if($_FILES['dlfile']['name'] > '') {
          $folder = $gbl['doc_root'] .'ast/res/'. date('Y', strtotime($_POST['downloaddate']));
          
          // determine file's type
          $type = mime_content_type($_FILES['dlfile']['tmp_name']);
          switch($type) {
               case 'text/plain':
               case 'application/msword':
               case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
               case 'application/rtf':
                    $doctype = 'Document';
                    break;
               case 'application/vnd.ms-excel':
               case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                    $doctype = 'Excel Spreadsheet';
                    break;
               case 'application/vnd.ms-powerpoint':
               case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
               case 'application/vnd.openxmlformats-officedocument.presentationml.slideshow':
                    $doctype = "Powerpoint File";
                    break;
               case 'image/png':
               case 'image/jpeg':
               case 'image/gif':
               case 'image/bmp':
                    $doctype = 'Image';
                    break;
               case 'application/pdf':
                    $doctype = 'Adobe PDF';
                    break;
               case 'audio/mpeg':
                    $doctype = 'Mp3 Audio';
                    break;
               default:
                    $doctype = '';
                    break;          
          }
          $ext = pathinfo($_FILES['dlfile']['name'], PATHINFO_EXTENSION);
          $filename = date('ymdhis') .'.'. $ext;
          if(move_uploaded_file($_FILES['dlfile']['tmp_name'], $folder .'/'. $filename)) {
               $date = date('Y-m-d', strtotime($_POST['downloaddate']));
               $db->exec("INSERT INTO $_SESSION[prefix]_downloads (`page_id`, `download_title`, `download_description`, `download_status`, `download_filename`, `download_filetype`, `download_author`, `download_date`) VALUES ('$_POST[page_id]', '$_POST[downloadtitle]', '$_POST[downloaddesc]', 1, '$filename', '$doctype', '$_POST[downloadauthor]', '$date')");
               echo 'Downloadable Added...Refreshing...';
          } else {     
               echo 'Problem adding download.  Please try again...';
          }          
     }
     else if($_POST['embedurl'] > '') {
          $doctype = 'Embedded Resource';
          $date = date('Y-m-d', strtotime($_POST['downloaddate']));
          $db->exec("INSERT INTO $_SESSION[prefix]_downloads (`page_id`, `download_title`, `download_description`, `download_status`, `download_filetype`, `download_author`, `download_date`, `download_embed_url`) VALUES ('$_POST[page_id]', '$_POST[downloadtitle]', '$_POST[downloaddesc]', 1, '$doctype', '$_POST[downloadauthor]', '$date', '$_POST[embedurl]')");
          echo 'Downloadable Added...Refreshing...';          
     } else {
          echo 'Uploaded file is not a valid filetype or there was no embedded resource.';
          die;
     }

     ?>
     <meta content="1; url=<?php echo $_POST['callback'] ?>" http-equiv="refresh" />
     <?php     
}

if(isset($_POST['update_download'])) {
     if($_FILES['dlfile']['name'] > '') {
          $folder = $gbl['doc_root'] .'ast/res/'. date('Y', strtotime($_POST['downloaddate']));
          
          // determine file's type
          $type = mime_content_type($_FILES['dlfile']['tmp_name']);
          switch($type) {
               case 'text/plain':
               case 'application/msword':
               case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
               case 'application/rtf':
                    $doctype = 'Document';
                    break;
               case 'application/vnd.ms-excel':
               case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                    $doctype = 'Excel Spreadsheet';
                    break;
               case 'application/vnd.ms-powerpoint':
               case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
               case 'application/vnd.openxmlformats-officedocument.presentationml.slideshow':
                    $doctype = "Powerpoint File";
                    break;
               case 'image/png':
               case 'image/jpeg':
               case 'image/gif':
               case 'image/bmp':
                    $doctype = 'Image';
                    break;
               case 'application/pdf':
                    $doctype = 'Adobe PDF';
                    break;
               case 'audio/mpeg':
                    $doctype = 'Mp3 Audio';
                    break;
               default:
                    $doctype = '';
                    break;          
          }
          $ext = pathinfo($_FILES['dlfile']['name'], PATHINFO_EXTENSION);
          $filename = date('ymdhis') .'.'. $ext;
          if(move_uploaded_file($_FILES['dlfile']['tmp_name'], $folder .'/'. $filename)) {
               $date = date('Y-m-d', strtotime($_POST['downloaddate']));
               $db->exec("UPDATE $_SESSION[prefix]_downloads SET `download_title` = '$_POST[downloadtitle]', `download_description` = '$_POST[downloaddesc]', `download_filename` = '$filename', `download_filetype` = '$doctype', `download_author` = '$_POST[downloadauthor]', `download_date` = '$date', download_embed_url = '' WHERE d_id = $_POST[did]");
               echo 'Downloadable Updated...Refreshing...';
          } else {     
               echo 'Problem updating download.  Please try again...';
          }          
     }
     else if($_POST['embedurl'] > '') {
          $doctype = 'Embedded Resource';
          $date = date('Y-m-d', strtotime($_POST['downloaddate']));
          $db->exec("UPDATE $_SESSION[prefix]_downloads SET `download_title` = '$_POST[downloadtitle]', `download_description` = '$_POST[downloaddesc]', `download_filetype` = '$doctype', `download_author` = '$_POST[downloadauthor]', `download_date` = '$date', `download_embed_url` = '$_POST[embedurl]', download_filename = '' WHERE d_id = $_POST[did]");
          echo 'Downloadable Updated...Refreshing...';
     }
     else if($_POST['downloadtitle'] > '') {
          $date = date('Y-m-d', strtotime($_POST['downloaddate']));
          $db->exec("UPDATE $_SESSION[prefix]_downloads SET `download_title` = '$_POST[downloadtitle]', `download_description` = '$_POST[downloaddesc]', `download_author` = '$_POST[downloadauthor]', `download_date` = '$date' WHERE d_id = $_POST[did]");
          echo 'Downloadable Updated...Refreshing...';                     
     } else {
          echo 'Uploaded file is not a valid filetype or there was no embedded resource.  Try again...';
     }
     ?>
     <meta content="1; url=<?php echo $_POST['callback'] ?>" http-equiv="refresh" />
     <?php                                                                                                     
}
