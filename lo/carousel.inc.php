<?php
if($pg['show_slider'] == 1) {
     $sqlc = $db->query("SELECT * FROM tbl_carousel_settings WHERE cs_id = 1");
     $cars = $sqlc->fetch(PDO::FETCH_ASSOC);
     if($cars['carousel_full'] == 1) {
          ?>
          <div id="carousel-image" class="d-none d-lg-block carousel slide carousel-fade <?php if($l['menu_location'] == 'fixed-top') { echo 'mt-5'; } ?>" data-ride="carousel">
          <?php
     } else {
          ?>
          <div id="carousel-image" class="carousel slide carousel-fade w-60 ml-auto mr-auto pt-3 <?php if($l['menu_location'] == 'fixed-top') { echo 'mt-5'; } ?>" data-ride="carousel">
          <?php
     }
     
     $c = 0;
     $sql2 = $db->query("SELECT * FROM tbl_carousel WHERE car_status = 1 ORDER by car_order ASC");
     if($sql2->rowCount() == 0) {
          echo '';
     } else {
          ?>
          <div class="carousel-inner" role="listbox">          
          <?php
          while($car = $sql2->fetch(PDO::FETCH_ASSOC)) {
               $c++;
               $exp = explode("-", $car['car_caption_size']);
               $csize = $exp[0];               
               if($car['car_url'] > '') {
                    echo '<div class="carousel-item'.($c == 1 ? ' active">' : '">')."\n";
                    echo '<a href="'. $car['car_url'] .'" target="_blank" style="cursor: pointer">'."\n";
                    echo '<div class="view">'."\n";
                    echo '<img class="d-block w-100" src="'. $gbl['site_url'] .'/ast/carousel/'. $car['car_image'] .'" />'."\n";
                    echo '<div class="mask '. $car['car_mask'] .' d-flex justify-content-center align-items-center">'."\n";
                    echo '</div></div>'."\n";
                    echo '<div class="carousel-caption">'."\n";
                    echo '<'. $csize .' class="'. $car['car_caption_size'] .'">'. $car['car_caption'] .'</'. $csize .'>'."\n";
                    echo '<p>'. $car['car_text'] .'</p>'."\n";
                    echo '</div></a></div>'."\n";
               } else {
                    echo '<div class="carousel-item'.($c == 1 ? ' active">' : '">')."\n";
                    echo '<div class="view">'."\n";
                    echo '<img class="d-block w-100" src="'. $gbl['site_url'] .'/ast/carousel/'. $car['car_image'] .'" />'."\n";
                    echo '<div class="mask '. $car['car_mask'] .' d-flex justify-content-center align-items-center">'."\n";
                    echo '</div></div>'."\n";
                    echo '<div class="carousel-caption">'."\n";
                    echo '<'. $csize .' class="'. $car['car_caption_size'] .'">'. $car['car_caption'] .'</'. $csize .'>'."\n";
                    echo '<p>'. $car['car_text'] .'</p>'."\n";                   
                    echo '</div></div>'."\n";                    
               }
          }
          ?>
          </div>
          
          <a class="carousel-control-prev carousel-control-custom" href="#carousel-image" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next carousel-control-custom" href="#carousel-image" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
          </a>
          <?php
     }
     ?>
     </div>
     <?php
} else {
     if($pg['jumbotron_image'] == '') {
          ?>
          
          <div class="row mb-5"></div>
          <?php
     }
}
?>

</header>

