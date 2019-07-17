<?php
session_start();

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['search_sermons'])) {
     ?>
     <div class="row">
     <div class="col-md-12">
     <div class="card-deck">
     
     <?php
     $sset = $db->query("SELECT * FROM tbl_sermon_settings WHERE ss_id = 1");
     $ss = $sset->fetch(PDO::FETCH_ASSOC);
     $r = 0;
     $smn = $db->query("SELECT s_id, sermon_title, sermon_date, sermon_preacher, sermon_image, sermon_desc FROM tbl_sermons WHERE CAST(sermon_date AS char) LIKE '$_POST[search_data]%' OR sermon_title LIKE '%$_POST[search_data]%' OR sermon_desc LIKE '%$_POST[search_data]%' AND sermon_status = 1 ORDER BY sermon_date DESC");     
     if($ss['layout_type'] == 1) {      
          while($sm = $smn->fetch(PDO::FETCH_ASSOC)) {
               if($r >= 4) {
                    echo '</div><div class="card-deck">';
                    $r = 0;
               }               
               if($sm['sermon_image'] == '') {
                    $sermonimage = $gbl['site_url'] .'/ast/sermons/defaultimage.jpg';
               } else {
                    $sermonimage = $gbl['site_url'] .'/ast/sermons/'. $sm['sermon_image'];
               }
               ?>
               <div class="card mb-4 col-3">
               <div class="view overlay">
               <img class="card-img-top hoverable mt-2" src="<?php echo $sermonimage ?>" alt="<?php echo $sm['sermon_title'] ?>" />
               <a><div class="mask flex-center rgba-stylish-strong"></div></a>
               </div>
                              
               <div class="card-body">
               <h4 class="font-weight-bold card-title"><?php echo $sm['sermon_title'] ?></h4>
               <h6 class="card-subtitle mb-2 text-muted"><?php echo date('F j Y', strtotime($sm['sermon_date'])) ?></h6>
               <p class="card-text"><?php echo $sm['sermon_desc'] ?></p>
               <a href="<?php echo $gbl['site_url'] .'/'. $parent .'/Sermon/&selected_id='. $sm['s_id'] ?>" class="btn btn-elegant justify-content-end z-depth-2">See More <i class="fa fa-angle-double-right"></i></a>
               <?php
               if(isset($_SESSION['isLoggedIn'])) {
                    ?>
                    <button type="button" class="btn btn-info btn-sm get_data" data-id="<?php echo $sm['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm get_datad" data-id="<?php echo $sm['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal">Delete</button>
                    <?php
               }
               ?>
               </div>
               </div>
               <?php
               $r++;
          }
     }
     ?>
     </div>
     </div>
     </div>
     
     <?php
     if($ss['layout_type'] == 2) {
          ?>
          <div class="row">
          <div class="col-md-12">
          <div class="table-responsive pt-3" style="background-color: white;">
          <table class="table table-hover table-striped" id="sortable">
          <thead>
          <tr>
          <?php if(isset($_SESSION['isLoggedIn'])) { echo '<th></th>'; } ?>
          <th>Date</th>
          <th>Title</th>
          <th>Preacher</th>
          <th>Description</th>
          <th></th>
          </tr>
          </thead>
         
          <tfoot>
          <tr>
          <?php if(isset($_SESSION['isLoggedIn'])) { echo '<th></th>'; } ?>
          <th>Date</th>
          <th>Title</th>
          <th>Preacher</th>
          <th>Description</th>
          <th></th>
          </tr>
          </tfoot>
     
          <tbody>          
          <?php
          while($sm = $smn->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <tr>
               <?php
               if(isset($_SESSION['isLoggedIn'])) {
                    ?>
                    <td>
                    <div class="btn-group" role="group" aria-label="Controls">
                    <button title="Edit Sermon" data-toggle="tooltip" type="button" class="btn btn-sm btn-default get_data" data-id="<?php echo $sm['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal"><i class="fa fa-pencil"></i></button>
                    <button title="Delete Sermon" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger get_datad" data-id="<?php echo $sm['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal"><i class="fa fa-trash"></i></button>
                    </div>
                    </td>
                    <?php
               }
               ?>
               <td data-order="<?php echo date('Ymd', strtotime($sm['sermon_date'])) ?>"><?php echo date('M j Y', strtotime($sm['sermon_date'])) ?></td>
               <td><?php echo stripslashes($sm['sermon_title']) ?></td>
               <td><?php echo stripslashes($sm['sermon_preacher']) ?></td>
               <td><?php echo stripslashes($sm['sermon_desc']) ?></td>
               <td><a href="<?php echo $gbl['site_url'] .'/'. $parent .'/Sermon/&selected_id='. $sm['s_id'] ?>" class="btn btn-sm btn-primary">Read More</a></td>
               </tr>
               <?php               
          }
          ?>
          </tbody>
          </table>
          </div>
          </div>
          </div>
          <?php
     }               
}

if(isset($_POST['reset_sermons'])) {
     ?>
     <div class="row">
     <div class="col-md-12">
     <div class="card-deck">
     
     <?php     
     $sset = $db->query("SELECT * FROM tbl_sermon_settings WHERE ss_id = 1");
     $ss = $sset->fetch(PDO::FETCH_ASSOC);     
     $r = 1;
     $smn = $db->query("SELECT s_id, sermon_title, sermon_date, sermon_preacher, sermon_image, sermon_desc FROM tbl_sermons WHERE sermon_status = 1 ORDER BY sermon_date DESC LIMIT 20");
     if($ss['layout_type'] == 1) {      
          while($sm = $smn->fetch(PDO::FETCH_ASSOC)) {
               if($r >= 5) {
                    echo '</div><div class="card-deck">';
                    $r = 1;
               }               
               if($sm['sermon_image'] == '') {
                    $sermonimage = $gbl['site_url'] .'/ast/sermons/defaultimage.jpg';
               } else {
                    $sermonimage = $gbl['site_url'] .'/ast/sermons/'. $sm['sermon_image'];
               }
               ?>
               <div class="card mb-4">
               <div class="view overlay">
               <img class="card-img-top hoverable mt-2" src="<?php echo $sermonimage ?>" alt="<?php echo $sm['sermon_title'] ?>" />
               <a><div class="mask flex-center rgba-stylish-strong"></div></a>
               </div>
                              
               <div class="card-body">
               <h4 class="font-weight-bold card-title"><?php echo $sm['sermon_title'] ?></h4>
               <h6 class="card-subtitle mb-2 text-muted"><?php echo date('F j Y', strtotime($sm['sermon_date'])) ?></h6>
               <p class="card-text"><?php echo $sm['sermon_desc'] ?></p>
               <a href="<?php echo $gbl['site_url'] .'/'. $parent .'/Sermon/&selected_id='. $sm['s_id'] ?>" class="btn btn-elegant justify-content-end z-depth-2">See More <i class="fa fa-angle-double-right"></i></a>
               <?php
               if(isset($_SESSION['isLoggedIn'])) {
                    ?>
                    <button type="button" class="btn btn-info btn-sm get_data" data-id="<?php echo $sm['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal">Edit</button>
                    <button type="button" class="btn btn-danger btn-sm get_datad" data-id="<?php echo $sm['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal">Delete</button>
                    <?php
               }
               ?>
               </div>
               </div>
               <?php
               $r++;
          }
     }
     ?>
     </div>
     </div>
     </div>
     
     <?php
     if($ss['layout_type'] == 2) {
          ?>
          <div class="row">
          <div class="col-md-12">
          <div class="table-responsive pt-3" style="background-color: white;">
          <table class="table table-hover table-striped" id="sortable">
          <thead>
          <tr>
          <?php if(isset($_SESSION['isLoggedIn'])) { echo '<th></th>'; } ?>
          <th>Date</th>
          <th>Title</th>
          <th>Preacher</th>
          <th>Description</th>
          <th></th>
          </tr>
          </thead>
         
          <tfoot>
          <tr>
          <?php if(isset($_SESSION['isLoggedIn'])) { echo '<th></th>'; } ?>
          <th>Date</th>
          <th>Title</th>
          <th>Preacher</th>
          <th>Description</th>
          <th></th>
          </tr>
          </tfoot>
     
          <tbody>          
          <?php
          while($sm = $smn->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <tr>
               <?php
               if(isset($_SESSION['isLoggedIn'])) {
                    ?>
                    <td>
                    <div class="btn-group" role="group" aria-label="Controls">
                    <button title="Edit Sermon" data-toggle="tooltip" type="button" class="btn btn-sm btn-default get_data" data-id="<?php echo $sm['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal"><i class="fa fa-pencil"></i></button>
                    <button title="Delete Sermon" data-toggle="tooltip" type="button" class="btn btn-sm btn-danger get_datad" data-id="<?php echo $sm['s_id'] ?>" data-toggle="modal" data-target="#sermon_editor_modal"><i class="fa fa-trash"></i></button>
                    </div>
                    </td>
                    <?php
               }
               ?>
               <td data-order="<?php echo date('Ymd', strtotime($sm['sermon_date'])) ?>"><?php echo date('M j Y', strtotime($sm['sermon_date'])) ?></td>
               <td><?php echo stripslashes($sm['sermon_title']) ?></td>
               <td><?php echo stripslashes($sm['sermon_preacher']) ?></td>
               <td><?php echo stripslashes($sm['sermon_desc']) ?></td>
               <td><a href="<?php echo $gbl['site_url'] .'/'. $parent .'/Sermon/&selected_id='. $sm['s_id'] ?>" class="btn btn-sm btn-primary">Read More</a></td>
               </tr>
               <?php               
          }
          ?>
          </tbody>
          </table>
          </div>
          </div>
          </div>
          <?php
     }     
}

if(isset($_POST['view_sermon_text'])) {
     $text = $db->query("SELECT sermon_text FROM tbl_sermons WHERE s_id = $_POST[s_id]");
     $t = $text->fetch(PDO::FETCH_ASSOC);
     echo stripslashes($t['sermon_text']);
     die;     
}

if(isset($_POST['change_api'])) {
     $db->query("UPDATE tbl_sermon_settings SET esv_api = '$_POST[esv_api]' WHERE ss_id = 1");
     die;     
}

if(isset($_POST['change_layout'])) {
     $db->query("UPDATE tbl_sermon_settings SET layout_type = $_POST[lvalue] WHERE ss_id = 1");
     die;
}

if(isset($_POST['sermons_per_page'])) {
     $db->query("UPDATE tbl_sermon_settings SET sermons_per_page = $_POST[spp] WHERE ss_id = 1");
     die;
}

if(isset($_POST['edit'])) {
     $sql = $db->query("SELECT * FROM tbl_sermons WHERE s_id = $_POST[s_id]");
     $smn = $sql->fetch(PDO::FETCH_ASSOC);
     ?>
     <form name="sermon_update" id="sermon_update" enctype="multipart/form-data">
     <input type="hidden" name="sid" value="<?php echo $smn['s_id'] ?>" />
     <input type="hidden" name="update_sermon" id="update_sermon" />
     
     <div class="md-form">
     <input type="text" placeholder="Sermon Title" value="<?php echo $smn['sermon_title'] ?>" name="sermontitle" id="sermontitle" required="required" class="form-control" />
     <label for="sermontitle" class="active">Sermon Title</label>
     </div>

     <div class="md-form">
     <small class="text-muted">Sermon Date</small><br />
     <input type="date" placeholder="mm/dd/yyyy" value="<?php echo $smn['sermon_date'] ?>" name="sermondate" id="sermondate" class="form-control" /><div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
     </div>
    
     <div class="md-form">
     <input type="text" placeholder="Title First Last" value="<?php echo $smn['sermon_preacher'] ?>" name="sermonpreacher" id="sermonpreacher" required="required" class="form-control" />
     <label for="sermonpreacher" class="active">Preacher</label>
     </div>

     <div class="md-form ui-front">
     <input type="text" placeholder="Book Chapter:Verses" value="<?php echo $smn['sermon_scripture'] ?>" name="sermonscripture" id="sermonscripture" required="required" class="form-control" autocomplete="off" />
     <label for="sermonscripture" class="active">Scripture Passage</label>
     </div>

     <div class="md-form">
     <input type="text" placeholder="Description" value="<?php echo $smn['sermon_desc'] ?>" name="sermondesc" id="sermondesc" class="form-control" />
     <label for="sermondesc" class="active">Description</label>
     <small class="form-text text-muted">This could be the Scripture reference, theme, or other information.</small>
     </div>

     <div class="md-form">
     <input type="text" placeholder="Keywords" value="<?php echo $smn['sermon_keywords'] ?>" name="sermonkeywords" id="sermonkeywords" class="form-control" />
     <label for="sermonkeywords" class="active">Keywords</label>
     <small class="form-text text-muted">Separate each keyword with a comma.</small>
     </div>

     <div class="md-form">
     <textarea name="sermontext" id="sermontext" rows="5" class="md-textarea form-control" placeholder="Manuscript, Outline, etc."><?php echo stripslashes($smn['sermon_text']) ?></textarea>
     <label for="sermontext" class="active">Sermon Text</label>
     <small class="form-text text-muted">If you don't include a PDF file of your sermon, this could be another way of letting visitors read it.</small>
     </div>
     <hr />
          
     <div class="file-field">
     <a class="btn-floating blue-gradient mt-0 float-left">
     <i class="fas fa-file-pdf-o" aria-hidden="true"></i>
     <input type="file" id="pdffile" name="pdffile" accept="application/pdf" />
     </a>
     <div class="file-path-wrapper">
     <input class="file-path validate" type="text" placeholder="PDF Document" disabled />
     </div>
     </div><br />

     <div class="file-field">
     <a class="btn-floating blue-gradient mt-0 float-left">
     <i class="fas fa-file-audio-o" aria-hidden="true"></i>
     <input type="file" id="audiofile" name="audiofile" accept="audio/mpeg, audio/mp3" />
     </a>
     <div class="file-path-wrapper">
     <input class="file-path validate" type="text" placeholder="Sermon Audio (mp3) file" disabled />
     </div>
     </div><br />
     
     <div class="file-field">
     <a class="btn-floating blue-gradient mt-0 float-left">
     <i class="fas fa-file-image-o" aria-hidden="true"></i>
     <input type="file" id="sermon_image" name="sermon_image" accept="image/jpeg, image/png" />
     </a>
     <div class="file-path-wrapper">
     <input class="file-path validate" type="text" placeholder="Sermon image (jpg/png)" disabled />
     </div>
     </div><br />     

     <div class="md-form">
     <input type="url" placeholder="Embed URL" value="<?php echo $smn['sermon_embed_url'] ?>" onblur="findUrl(this.value)" name="embedurl" id="embedurl" class="form-control" />
     <label for="embedurl">Youtube Video Embed URL</label>
     <small class="form-text help-block">Paste the Embed code here.  After you click outside the box, the code will be replaced with the URL of the video.</small>
     </div>
     
     <input type="submit" id="editsermonbutton" name="update" id="update" value="Update Sermon" class="btn btn-warning btn-block" /><br />
     <div id="progressbar"></div>     
     <small class="form-text text-muted">If you've included an audio file and/or pdf file, this will take some time.  Your browser is NOT stuck.</small>
     </form>      
     <?php
}

if(isset($_POST['del'])) {
     $db->exec("UPDATE tbl_sermons SET sermon_status = 0 WHERE s_id = $_POST[s_id]");
     echo 'Sermon Deleted.';
}

if(isset($_POST['res'])) {
     $db->exec("UPDATE tbl_sermons SET sermon_status = 1 WHERE s_id = $_POST[s_id]");
     echo 'Sermon Restored.'; 
}

if(isset($_POST['update_sermon'])) {
     $folder = $gbl['doc_root'] .'ast/sermons/';
     if($_FILES['audiofile']['error'] != 4) {
          // process the audio file
          $maxsize = 35000000;
          if($_FILES['audiofile']['size'] > $maxsize) {
               echo '<div class="alert alert-warning">The Audio File is too large!  It should be less than '. ($maxsize / 1048576) .' Megabytes!  The 
               file may still upload and work, but forserver space considerations, please limit your file sizes to under 25M.</div><br />';
          }
          $typearray = array('mp3', 'avi', 'mpeg', 'wav', 'MP3', 'AVI', 'MPEG', 'WAV');
          $ext = pathinfo($_FILES['audiofile']['name'], PATHINFO_EXTENSION);
          if(!in_array($ext, $typearray)) {
               echo '<div class="alert alert-info">The uploaded audio file is not an MPEG layer 3 file.  This file will not be added.</div><br />';
          } else {
               // give it a new name based on date and time
               $audiofilename = date('y-m-d_h-i-s') .'.mp3';
               if(move_uploaded_file($_FILES['audiofile']['tmp_name'], $folder . $audiofilename)) {
                    $db->exec("UPDATE tbl_sermons SET sermon_audio_file = '$audiofilename' WHERE s_id = $_POST[sid]");                     
                    echo '<div class="alert alert-success">Audio File created and saved.</div><br />';
               } else {
                    echo '<pre>';
                    print_r($_FILES);
                    echo '</pre>';
               }
          }
     }
     if($_FILES['pdffile']['error'] != 4) {          
          // process the pdf file
          $typearray = array('application/pdf');
          if(!in_array($_FILES['pdffile']['type'], $typearray)) {
               echo '<div class="alert alert-info">The uploaded file is not a PDF file (or is so old that the system doesn\'t recognize it).  This file will not be added.</div><br />';
          } else {
               // give it a new name based on date and time
               $pdffilename = date('y-m-d_h-i-s') .'.pdf';
               if(move_uploaded_file($_FILES['pdffile']['tmp_name'], $folder . $pdffilename)) {
                    $db->exec("UPDATE tbl_sermons SET sermon_pdf_file = '$pdffilename' WHERE s_id = $_POST[sid]");                    
                    echo '<div class="alert alert-success">PDF File created and saved.</div><br />';
               }               
          }
     }
     if($_FILES['sermon_image']['error'] != 4) {
          $typearray = array('image/jpg', 'image/jpeg', 'image/png');
          if(!in_array($_FILES['sermon_image']['type'], $typearray)) {
               echo '<div class="alert alert-info">The uploaded image is not a jpeg or png. The image will not be added.</div><br />';
          } else {
               $ext = pathinfo($_FILES['sermon_image']['name'], PATHINFO_EXTENSION);
               $imagefilename = date('y-m-d_h-i-s') .'.'. $ext;
               if(move_uploaded_file($_FILES['sermon_image']['tmp_name'], $folder . $imagefilename)) {
                    $db->exec("UPDATE tbl_sermons SET sermon_image = '$imagefilename' WHERE s_id = $_POST[sid]");                    
                    echo '<div class="alert alert-success">Image Added and Saved.</div><br />';
               }
          }
     }
     $title = $db->quote($_POST['sermontitle']);
     $sermondate = date('Y-m-d', strtotime($_POST['sermondate']));
     $preacher = $db->quote($_POST['sermonpreacher']);
     $scripture = $db->quote($_POST['sermonscripture']);
     $keywords = $db->quote($_POST['sermonkeywords']);
     $desc = $db->quote($_POST['sermondesc']);
     $text = $db->quote($_POST['sermontext']);
     $url = $_POST['embedurl'];
     
     $db->exec("UPDATE tbl_sermons SET sermon_keywords = $keywords, sermon_scripture = $scripture, sermon_title = $title, sermon_date = '$sermondate', sermon_preacher = $preacher, sermon_desc = $desc, sermon_text = $text, sermon_embed_url = '$url' WHERE s_id = $_POST[sid]");
     echo '<div class="alert alert-default">Sermon Updated.</div>';
}

if(isset($_POST['new_sermon'])) {
     ?>
     <form name="new_sermon" id="new_sermon" enctype="multipart/form-data">
     <input type="hidden" name="addnewsermon" value="1" />
     
     <div class="md-form">
     <input type="text" value="" name="sermontitle" id="sermontitle" required="required" class="form-control" />
     <label for="sermontitle">Sermon Title</label>
     </div>

     <div class="md-form">
     <small class="text-muted">Sermon Date</small><br />
     <input type="date" placeholder="mm/dd/yyyy" value="" name="sermondate" id="sermondate" class="form-control" /><div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
     </div>
    
     <div class="md-form">
     <input type="text" value="" name="sermonpreacher" id="sermonpreacher" required="required" class="form-control" />
     <label for="sermonpreacher">Preacher</label>
     </div>

     <div class="md-form ui-front">
     <input type="text" value="" name="sermonscripture" id="sermonscripture" required="required" class="form-control" />
     <label for="sermonscripture">Scripture Passage</label>
     </div>

     <div class="md-form">
     <input type="text" value="" name="sermondesc" id="sermondesc" class="form-control" />
     <label for="sermondesc">Description</label>
     <small class="form-text text-muted">This could be the Scripture reference, theme, or other information.</small>
     </div>
     
     <div class="md-form">
     <input type="text" value="" name="sermonkeywords" id="sermonkeywords" class="form-control" />
     <label for="sermonkeywords">Keywords</label>
     <small class="form-text text-muted">Separate each keyword with a comma.</small>
     </div>     

     <div class="md-form">
     <textarea name="sermontext" id="sermontext" rows="5" class="md-textarea form-control"></textarea>
     <label for="sermontext">Sermon Text</label>
     <small class="form-text text-muted">If you don't include a PDF file of your sermon, this could be another way of letting visitors read it.</small>
     </div>
     <hr />
          
     <div class="file-field">
     <a class="btn-floating blue-gradient mt-0 float-left">
     <i class="far fa-file-pdf" aria-hidden="true"></i>
     <input type="file" id="pdffile" name="pdffile" accept="application/pdf" />
     </a>
     <div class="file-path-wrapper">
     <input class="file-path validate" type="text" placeholder="PDF Document" disabled />
     </div>
     </div><br />

     <div class="file-field">
     <a class="btn-floating blue-gradient mt-0 float-left">
     <i class="fas fa-file-audio" aria-hidden="true"></i>
     <input type="file" id="audiofile" name="audiofile" accept="audio/mpeg, audio/mp3" />
     </a>
     <div class="file-path-wrapper">
     <input class="file-path validate" type="text" placeholder="Sermon Audio (mp3) file" disabled />
     </div>
     </div><br />
     
     <div class="file-field">
     <a class="btn-floating blue-gradient mt-0 float-left">
     <i class="far fa-file-image" aria-hidden="true"></i>
     <input type="file" id="sermon_image" name="sermon_image" accept="image/jpeg, image/png" />
     </a>
     <div class="file-path-wrapper">
     <input class="file-path validate" type="text" placeholder="Sermon image (jpg/png)" disabled />
     </div>
     </div><br />     

     <div class="md-form">
     <input type="url" value="" onblur="findUrl(this.value)" name="embedurl" id="embedurl" class="form-control" />
     <label for="embedurl">Youtube Video Embed URL</label>
     <small class="form-text help-block">Paste the Embed code here.  After you click outside the box, the code will be replaced with the URL of the video.</small>
     </div>
     
     <input type="submit" id="add_new" name="add_new" value="Add Sermon" class="btn btn-unique btn-block" /><br />
     <div id="progressbar"></div>     
     <small class="form-text text-muted">If you've included an audio file and/or pdf file, this will take some time.  Your browser is NOT stuck.</small>
     </form>     
     <?php
}

if(isset($_POST['addnewsermon'])) {
     $audiofilename = '';
     $pdffilename = '';
     $imagefilename = '';
     $folder = $gbl['doc_root'] .'ast/sermons/';
     if($_FILES['audiofile']['error'] != 4) {
          // process the audio file
          $maxsize = 35000000;
          if($_FILES['audiofile']['size'] > $maxsize) {
               echo '<div class="alert alert-warning">The Audio File is too large!  It should be less than '. ($maxsize / 1048576) .' Megabytes!  The 
               file may still upload and work, but forserver space considerations, please limit your file sizes to under 25M.</div><br />';
          }
          $typearray = array('mp3', 'avi', 'mpeg', 'wav', 'MP3', 'AVI', 'MPEG', 'WAV');
          $ext = pathinfo($_FILES['audiofile']['name'], PATHINFO_EXTENSION);
          if(!in_array($ext, $typearray)) {
               echo '<div class="alert alert-info">The uploaded audio file is not an MPEG layer 3 file.  This file will not be added.</div><br />';
          } else {
               // give it a new name based on date and time
               $audiofilename = date('y-m-d_h-i-s') .'.mp3';
               if(move_uploaded_file($_FILES['audiofile']['tmp_name'], $folder . $audiofilename)) {
                    echo '<div class="alert alert-success">Audio File created and saved.</div><br />';
               } else {
                    echo '<div class="alert alert-danger">There was an error uploading the Audio file.</div><br />';                    
               }
          }
     }
     if($_FILES['pdffile']['error'] != 4) {          
          // process the pdf file
          $typearray = array('application/pdf');
          if(!in_array($_FILES['pdffile']['type'], $typearray)) {
               echo '<div class="alert alert-info">The uploaded file is not a PDF file (or is so old that the system doesn\'t recognize it).  This file will not be added.</div><br />';
          } else {
               // give it a new name based on date and time
               $pdffilename = date('y-m-d_h-i-s') .'.pdf';
               if(move_uploaded_file($_FILES['pdffile']['tmp_name'], $folder . $pdffilename)) {
                    echo '<div class="alert alert-success">PDF File created and saved.</div><br />';
               }               
          }
     }
     if($_FILES['sermon_image']['error'] != 4) {
          $typearray = array('image/jpg', 'image/jpeg', 'image/png');
          if(!in_array($_FILES['sermon_image']['type'], $typearray)) {
               echo '<div class="alert alert-info">The uploaded image is not a jpeg or png. The image will not be added.</div><br />';
          } else {
               $ext = pathinfo($_FILES['sermon_image']['name'], PATHINFO_EXTENSION);
               $imagefilename = date('y-m-d_h-i-s') .'.'. $ext;
               if(move_uploaded_file($_FILES['sermon_image']['tmp_name'], $folder . $imagefilename)) {
                    echo '<div class="alert alert-success">Image Added and Saved.</div><br />';
               }
          }
     }     
     $title = $db->quote($_POST['sermontitle']);
     $sermondate = date('Y-m-d', strtotime($_POST['sermondate']));
     $preacher = $db->quote($_POST['sermonpreacher']);
     $keywords = $db->quote($_POST['sermonkeywords']);
     $scripture = $db->quote($_POST['sermonscripture']);
     $desc = $db->quote($_POST['sermondesc']);
     $text = $db->quote($_POST['sermontext']);
     $url = $_POST['embedurl'];
     
     $db->exec("INSERT INTO tbl_sermons (sermon_keywords, sermon_scripture, sermon_image, sermon_title, sermon_date, sermon_preacher, sermon_desc, sermon_text, sermon_audio_file, sermon_pdf_file, sermon_embed_url) VALUES ($keywords, $scripture, '$imagefilename', $title, '$sermondate', $preacher, $desc, $text, '$audiofilename', '$pdffilename', '$url')");
     echo '<div class="alert alert-primary">Sermon added successfully!</div>';
}
if(isset($_POST['search_form'])) {
     
}
?>
