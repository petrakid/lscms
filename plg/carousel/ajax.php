<?php
session_start();

include '../../ld/db.inc.php';
include '../../ld/globals.inc.php';

if(isset($_POST['update_carousel'])) {
     $db->exec("UPDATE tbl_carousel_settings SET `$_POST[field]` = '$_POST[value]' WHERE cs_id = 1");
     $cars = $db->query("SELECT * FROM tbl_carousel_settings WHERE cs_id = 1");
     $cs = $cars->fetch(PDO::FETCH_ASSOC);
     ?>
     <div id="carousel-editor" class="carousel slide mt-1 <?php if($cs['animations'] == 0) { echo 'carousel-fade'; } ?>" data-ride="carousel" data-wrap="<?php echo $cs['wrapping'] ?>" data-interval="<?php echo $cs['interval'] ?>000" data-pause="<?php echo $cs['hover_pause'] ?>">
     <ol class="carousel-indicators" <?php if($cs['indicators'] == 0) { echo 'style="display: none"'; } ?> id="indicators">
          
     <?php
     $ols = $db->query("SELECT c_id FROM tbl_carousel ORDER BY car_order");
     $cnt = $ols->rowCount();
     $s = 0;
     for($l=1;$l<=$cnt;$l++) {
          ?>
          <li data-target="#carousel-editor" data-slide-to="<?php echo $s ?>" class="<?php if($l == 1) { echo 'active'; } ?>"></li>
          
          <?php
          $s++;
          }
     ?>
     </ol>
     
     <div class="carousel-inner" role="listbox">
     <?php
     $i = 1;
     $car = $db->query("SELECT * FROM tbl_carousel ORDER BY car_order");
     while($c = $car->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <div class="carousel-item <?php if($i == 1) { echo 'active'; } ?>">
          <div class="view">
          <img class="d-block w-100 slideimage <?php if($cs['animations'] == 1) { echo 'animated'; } ?> <?php echo $c['car_animation'] ?>" src="<?php echo $gbl['site_url'] ?>/ast/carousel/<?php echo $c['car_image'] ?>" alt="Slide <?php echo $i ?>" />
          <?php
          if($c['car_status'] == 0) {
               ?>
               <div class="mask flex-center rgba-black-strong">
               <p class="white-text">DISABLED</p>
               </div> 
                        
               <?php
          } else {
               ?>
               <div class="mask rgba-<?php echo $c['car_mask'] ?>"></div>
               
               <?php
          }
          ?>
          </div>
      
          <div class="carousel-caption">
          <h3 class="h3-responsive"><?php echo $c['car_caption'] ?></h3>
          <p><?php echo $c['car_text'] ?></p>
          </div>
          </div>
          <?php
          $i++;
     }
     ?>
     </div>
     
     <a class="carousel-control-prev" <?php if($cs['controls'] == 0) { echo 'style="display: none"'; } ?> id="controlsl" href="#carousel-editor" role="button" data-slide="prev">
     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
     <span class="sr-only">Previous</span>
     </a>
     <a class="carousel-control-next" <?php if($cs['controls'] == 0) { echo 'style="display: none"'; } ?> id="controlsr" href="#carousel-editor" role="button" data-slide="next">
     <span class="carousel-control-next-icon" aria-hidden="true"></span>
     <span class="sr-only">Next</span>
     </a>
     </div>     
     <?php
}

if(isset($_POST['item'])) {
     $i = 0;
     foreach($_POST['item'] as $value) {
          $db->exec("UPDATE tbl_carousel SET car_order = $i WHERE c_id = $value");
          $i++;
     }
     $cars = $db->query("SELECT * FROM tbl_carousel_settings WHERE cs_id = 1");
     $cs = $cars->fetch(PDO::FETCH_ASSOC);
     ?>
     <div id="carousel-editor" class="carousel slide mt-1 <?php if($cs['animations'] == 0) { echo 'carousel-fade'; } ?>" data-ride="carousel" data-wrap="<?php echo $cs['wrapping'] ?>" data-interval="<?php echo $cs['interval'] ?>000" data-pause="<?php echo $cs['hover_pause'] ?>">
     <ol class="carousel-indicators" <?php if($cs['indicators'] == 0) { echo 'style="display: none"'; } ?> id="indicators">
          
     <?php
     $ols = $db->query("SELECT c_id FROM tbl_carousel ORDER BY car_order");
     $cnt = $ols->rowCount();
     $s = 0;
     for($l=1;$l<=$cnt;$l++) {
          ?>
          <li data-target="#carousel-editor" data-slide-to="<?php echo $s ?>" class="<?php if($l == 1) { echo 'active'; } ?>"></li>
          
          <?php
          $s++;
          }
     ?>
     </ol>
     
     <div class="carousel-inner" role="listbox">
     <?php
     $i = 1;
     $car = $db->query("SELECT * FROM tbl_carousel ORDER BY car_order");
     while($c = $car->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <div class="carousel-item <?php if($i == 1) { echo 'active'; } ?>">
          <div class="view">
          <img class="d-block w-100 slideimage <?php if($cs['animations'] == 1) { echo 'animated'; } ?> <?php echo $c['car_animation'] ?>" src="<?php echo $gbl['site_url'] ?>/ast/carousel/<?php echo $c['car_image'] ?>" alt="Slide <?php echo $i ?>" />
          <?php
          if($c['car_status'] == 0) {
               ?>
               <div class="mask flex-center rgba-black-strong">
               <p class="white-text">DISABLED</p>
               </div> 
                        
               <?php
          } else {
               ?>
               <div class="mask rgba-<?php echo $c['car_mask'] ?>"></div>
               
               <?php
          }
          ?>
          </div>
      
          <div class="carousel-caption">
          <h3 class="h3-responsive"><?php echo $c['car_caption'] ?></h3>
          <p><?php echo $c['car_text'] ?></p>
          </div>
          </div>
          <?php
          $i++;
     }
     ?>
     </div>
     
     <a class="carousel-control-prev" <?php if($cs['controls'] == 0) { echo 'style="display: none"'; } ?> id="controlsl" href="#carousel-editor" role="button" data-slide="prev">
     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
     <span class="sr-only">Previous</span>
     </a>
     <a class="carousel-control-next" <?php if($cs['controls'] == 0) { echo 'style="display: none"'; } ?> id="controlsr" href="#carousel-editor" role="button" data-slide="next">
     <span class="carousel-control-next-icon" aria-hidden="true"></span>
     <span class="sr-only">Next</span>
     </a>
     </div>
     <?php
}
if(isset($_POST['update_slide'])) {
     $db->exec("UPDATE tbl_carousel SET `$_POST[field]` = '$_POST[value]' WHERE c_id = $_POST[c_id]");
          
     $cars = $db->query("SELECT * FROM tbl_carousel_settings WHERE cs_id = 1");
     $cs = $cars->fetch(PDO::FETCH_ASSOC);
     ?>
     <div id="carousel-editor" class="carousel slide mt-1 <?php if($cs['animations'] == 0) { echo 'carousel-fade'; } ?>" data-ride="carousel" data-wrap="<?php echo $cs['wrapping'] ?>" data-interval="<?php echo $cs['interval'] ?>000" data-pause="<?php echo $cs['hover_pause'] ?>">
     <ol class="carousel-indicators" <?php if($cs['indicators'] == 0) { echo 'style="display: none"'; } ?> id="indicators">
          
     <?php
     $ols = $db->query("SELECT c_id FROM tbl_carousel ORDER BY car_order");
     $cnt = $ols->rowCount();
     $s = 0;
     for($l=1;$l<=$cnt;$l++) {
          ?>
          <li data-target="#carousel-editor" data-slide-to="<?php echo $s ?>" class="<?php if($l == 1) { echo 'active'; } ?>"></li>
          
          <?php
          $s++;
          }
     ?>
     </ol>
     
     <div class="carousel-inner" role="listbox">
     <?php
     $i = 1;
     $car = $db->query("SELECT * FROM tbl_carousel ORDER BY car_order");
     while($c = $car->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <div class="carousel-item <?php if($i == 1) { echo 'active'; } ?>">
          <div class="view">
          <img class="d-block w-100 slideimage <?php if($cs['animations'] == 1) { echo 'animated'; } ?> <?php echo $c['car_animation'] ?>" src="<?php echo $gbl['site_url'] ?>/ast/carousel/<?php echo $c['car_image'] ?>" alt="Slide <?php echo $i ?>" />
          <?php
          if($c['car_status'] == 0) {
               ?>
               <div class="mask flex-center rgba-black-strong">
               <p class="white-text">DISABLED</p>
               </div> 
                        
               <?php
          } else {
               ?>
               <div class="mask rgba-<?php echo $c['car_mask'] ?>"></div>
               
               <?php
          }
          ?>
          </div>
      
          <div class="carousel-caption">
          <h3 class="h3-responsive"><?php echo $c['car_caption'] ?></h3>
          <p><?php echo $c['car_text'] ?></p>
          </div>
          </div>
          <?php
          $i++;
     }
     ?>
     </div>
     
     <a class="carousel-control-prev" <?php if($cs['controls'] == 0) { echo 'style="display: none"'; } ?> id="controlsl" href="#carousel-editor" role="button" data-slide="prev">
     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
     <span class="sr-only">Previous</span>
     </a>
     <a class="carousel-control-next" <?php if($cs['controls'] == 0) { echo 'style="display: none"'; } ?> id="controlsr" href="#carousel-editor" role="button" data-slide="next">
     <span class="carousel-control-next-icon" aria-hidden="true"></span>
     <span class="sr-only">Next</span>
     </a>
     </div>       
     <?php
}
if(isset($_POST['delete_slide'])) {
     $img = $db->query("SELECT car_image FROM tbl_carousel WHERE c_id = $_POST[c_id]");
     $i = $img->fetch(PDO::FETCH_ASSOC);
     $root = $gbl['doc_root'] .'ast/carousel/';
     $image = $root . $i['car_image'];
     unlink($image);
     $db->exec("DELETE FROM tbl_carousel WHERE c_id = $_POST[c_id]");
}
if(isset($_POST['new_slide'])) {
     if(!isset($_FILES['car_image'])) {
          echo '<div class="alert alert-danger">You did not include an image!  You need an image to make a slide.</div>';
          die;
     }
     if($_FILES['car_image']['error'] == 4) {
          echo '<div class="alert alert-danger">You did not include an image!  You need an image to make a slide.</div>';
          die;          
     }
     if($_FILES['car_image']['error'] == 3) {
          echo '<div class="alert alert-danger">Something happened with the file and it did not upload correctly.  Slide creation failed</div>';
          die;
     }
     $maxsize = 1000000; //1 megabyte
     if($_FILES['car_image']['size'] > $maxsize) {
          echo '<div class="alert alert-warning">Nope, you cannot upload an image larger than a megabyte because it will load to slowly on some computers.  Check the image dimensions and see if you can make it a smaller file then try again.</div>';
          die;
     }
     $types = array("jpg", "jpeg", "png", "gif");
     $ext = strtolower(pathinfo($_FILES['car_image']['name'], PATHINFO_EXTENSION));
     if(!in_array($ext, $types)) {
          echo '<div class="alert alert-warning">Huh, does not look like the file you tried to add was an actual IMAGE file.  You can only use jpeg (jpg), png or gif image types.  Try again!';
          die;
     }
     $image_info = getimagesize($_FILES["car_image"]["tmp_name"]);
     $image_width = $image_info[0];
     $image_height = $image_info[1];
     if($image_width <= $image_height) {
          echo '<div class="alert alert-warning">This does not seem right.  The height of the image is greater or equal to its width.  The Carousel requires images to be in wide screen format of about a 3:1 ratio.  Check your image and try again.</div>';
          die; 
     }
     $filename = rand(0, 8). date('Ymdhis') .'.'. $ext;
     $root = $gbl['doc_root'] .'ast/carousel/';
     if(move_uploaded_file($_FILES['car_image']['tmp_name'], $root . $filename)) {
          if($_POST['car_status'] == TRUE) {
               $_POST['car_status'] = 1;
          } else {
               $_POST['car_status'] = 0;
          }
          unset($_POST['new_slide']);
          unset($_FILES);
          $_POST['car_image'] = $filename;
          $sql = "INSERT INTO tbl_carousel (";
          foreach($_POST AS $field => $value) {
               $sql .= "`$field`, ";
          }
          $sql = rtrim($sql, ", ");
          $sql .= ") VALUES (";
          foreach($_POST AS $field => $value) {
               $sql .= "'$value', ";               
          }
          $sql = rtrim($sql, ", ");
          $sql .= ")";
          $db->exec($sql);
          echo '<div class="alert alert-success">Great!  Slide has been added.  Now refresh to reorder.</div>';
          die;
     }
       
}