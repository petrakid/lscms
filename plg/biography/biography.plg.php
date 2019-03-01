<?php
if(isset($_SESSION['isLoggedIn'])) {
     
}
?>
<div class="row">
<?php
$bio = $db->query("SELECT * FROM tbl_users WHERE last_name = '". strtolower($q[1]) ."' AND show_bio = 1");
if($bio->rowCount() != 0) {
     while($b = $bio->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <div class="row">
          <div class="col-md-4">
          <div class="card card-cascade narrower">
          <div class="view view-cascade overlay">
          <?php
          if($b['profile_image'] > '') {
               ?>
               <img src="<?php echo $gbl['site_url'] ?>/ast/users/<?php echo $b['profile_image'] ?>" class="card-img-top" alt="No Profile Image" />
               
               <?php
          } else {
               ?>
               <img src="<?php echo $gbl['site_url'] ?>/ast/users/default.png" class="card-img-top" alt="No Profile Image" />
               
               <?php
          }
          ?>
          <a href="javascript:void();"><div class="mask rgba-white-slight"></div></a>
          </div>
          <div class="card-body card-body-cascade text-center">
          <h4 class="card-title"><strong><?php echo $b['title'] .' '. $b['first_name'] .' '. $b['last_name'] .' '. $b['suffix'] ?></strong></h4>
          <h5><?php echo ucwords($b['job_title']) ?></h5>
          <p class="card-text">
          <?php echo $b['email_2'] ?><br />
          <a href="tel:<?php echo $b['phone_2'] ?>" target="_blank"><?php echo formatPhone($b['phone_2']) ?></a><br />
          <hr />
          <?php
          if($b['facebook_profile'] > '') {
               ?>
               <a href="<?php echo $b['facebook_profile'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-fb"><i class="fab fa-facebook"></i></a>
               
               <?php
          }
          if($b['twitter_handle'] > '') {
               ?>
               <a href="<?php echo $b['twitter_handle'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-tw"><i class="fab fa-twitter"></i></a>
               
               <?php
          }
          if($b['instagram_name'] > '') {
               ?>
               <a href="<?php echo $b['instagram_name'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-ins"><i class="fab fa-instagram"></i></a>
               
               <?php
          }
          if($b['tumblr_id'] > '') {
               ?>
               <a href="<?php echo $b['tumblr_id'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-tu"><i class="fab fa-tumblr"></i></a>
               
               <?php
          }
          if($b['pinterest_id'] > '') {
               ?>
               <a href="<?php echo $b['pinterest'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-pin"><i class="fab fa-pinterest"></i></a>
               
               <?php
          }
          if($b['linkedin_id'] > '') {
               ?>
               <a href="<?php echo $b['linkedin_id'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-li"><i class="fab fa-linkedin"></i></a>
               
               <?php
          }
          if($b['lcms_roster_id'] > '') {
               ?>
               <a href="<?php echo $b['lcms_roster_id'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-red"><i class="fas fa-arrows-alt"></i></a>
               
               <?php
          }               
          ?>
          </p>
          </div>
          </div>
          </div>
          <div class="col-md-8">
          <div class="card">
          <div class="card-body">
          <?php echo stripslashes($b['biography']) ?>
          <hr />
          <b>Favorite Quote: </b><i><?php echo stripslashes($b['favorite_quote']) ?></i><br />
          <b>Favorite Scripture Verise: </b><i><?php echo stripslashes($b['favorite_verse']) ?></i>
          
          </div>
          </div>
          </div>
          </div>
          <?php
     }
}
$bio = $db->query("SELECT * FROM tbl_users WHERE bio_position = '". strtolower($q[1]) ."' AND show_bio = 1");
if($bio->rowCount() != 0) {
     while($b = $bio->fetch(PDO::FETCH_ASSOC)) {
          ?>
          <div class="row">
          <div class="col-lg-5">
          <div class="card card-cascade narrower">
          <div class="view view-cascade overlay">
          <?php
          if($b['profile_image'] > '') {
               ?>
               <img src="<?php echo $gbl['site_url'] ?>/ast/users/<?php echo $b['profile_image'] ?>" class="card-img-top" alt="No Profile Image" />
               
               <?php
          } else {
               ?>
               <img src="<?php echo $gbl['site_url'] ?>/ast/users/default.png" class="card-img-top" alt="No Profile Image" />
               
               <?php
          }
          ?>
          <a href="javascript:void();"><div class="mask rgba-white-slight"></div></a>
          </div>
          <div class="card-body card-body-cascade text-center">
          <h4 class="card-title"><strong><?php echo $b['title'] .' '. $b['first_name'] .' '. $b['last_name'] .' '. $b['suffix'] ?></strong></h4>
          <h5><?php echo ucwords($b['job_title']) ?></h5>
          <p class="card-text">
          <?php echo $b['email_2'] ?><br />
          <a href="tel:<?php echo $b['phone_2'] ?>" target="_blank"><?php echo formatPhone($b['phone_2']) ?></a><br />
          <hr />
          <?php
          if($b['facebook_profile'] > '') {
               ?>
               <a href="<?php echo $b['facebook_profile'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-fb"><i class="fab fa-facebook-f"></i></a>
               
               <?php
          }
          if($b['twitter_handle'] > '') {
               ?>
               <a href="<?php echo $b['twitter_handle'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-tw"><i class="fab fa-twitter"></i></a>
               
               <?php
          }
          if($b['instagram_name'] > '') {
               ?>
               <a href="<?php echo $b['instagram_name'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-ins"><i class="fab fa-instagram"></i></a>
               
               <?php
          }
          if($b['tumblr_id'] > '') {
               ?>
               <a href="<?php echo $b['tumblr_id'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-tu"><i class="fab fa-tumblr"></i></a>
               
               <?php
          }
          if($b['pinterest_id'] > '') {
               ?>
               <a href="<?php echo $b['pinterest'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-pin"><i class="fab fa-pinterest"></i></a>
               
               <?php
          }
          if($b['linkedin_id'] > '') {
               ?>
               <a href="<?php echo $b['linkedin_id'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-li"><i class="fab fa-linkedin"></i></a>
               
               <?php
          }
          if($b['lcms_roster_id'] > '') {
               ?>
               <a href="<?php echo $b['lcms_roster_id'] ?>" target="_blank" type="button" class="btn-floating btn-small btn-red"><i class="fas fa-arrows-alt"></i></a>
               
               <?php
          }               
          ?>
          </p>
          </div>
          </div>
          </div>
          <div class="col-lg-7">
          <div class="card">
          <div class="card-body">
          <?php echo stripslashes($b['biography']) ?>
          <hr />
          <b>Favorite Quote: </b><i><?php echo stripslashes($b['favorite_quote']) ?></i><br />
          <b>Favorite Scripture Verise: </b><i><?php echo stripslashes($b['favorite_verse']) ?></i>
          
          </div>
          </div>
          </div>
          </div>
          <?php
     }
}
?>

</div>
