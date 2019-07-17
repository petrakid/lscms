<?php
header("Content-type: text/css; charset: UTF-8");
session_start();
include '../ld/db.inc.php';
include '../ld/globals.inc.php';

$sql = $db->query("SELECT * from tbl_layout WHERE l_id = 1");
$c = $sql->fetch(PDO::FETCH_ASSOC);
?>

@import url('https://fonts.googleapis.com/css?family=Abel|Anton|Bitter|Crimson+Text|Dancing+Script|Dosis|Gloria+Hallelujah|Inconsolata|Indie+Flower|Josefin+Sans|Lobster|Merriweather|Open+Sans|Oswald|Pacifico|Playfair+Display|Raleway|Shadows+Into+Light|Slabo+27px|Titillium+Web');
html {
     position: relative;
     min-height: 100%;
}

body {
     padding-top: 0px !important;
     margin-bottom: <?php echo $c['footer_height'] ?>px !important;
     font-family: <?php echo $c['default_font'] ?> !important;
    --ck-z-default: 100;
    --ck-z-modal: calc( var(--ck-z-default) + 999 );
    min-height: 400px !important;
    margin-bottom: <?php echo $c['footer_height'] ?>px !important;
    clear: both !important;              
}

.body-custom {

     <?php
     if($c['background_image'] != '') {
          ?>
          background-image: url('../ast/layout/<?php echo $c['background_image'] ?>') !important;
          background-repeat: <?php echo $c['background_image_repeat'] ?> !important;
          <?php
          if($c['background_image_repeat'] == 'repeat-y') {
               ?>
               background-size: 100% !important;
               width: 100% !important;
               
               <?php
          } 
          if($c['background_image_repeat'] == 'no-repeat') {
               ?>
               background-size: 100% !important;
               width: 100%; !important;
               <?php
          }
     }
     ?>
     background-color: <?php echo $c['background_color'] ?> !important;
}

main {
     min-height: 100%;
}

.background-fixed {
     background-attachment: fixed;
}

a:link {
     color: <?php echo $c['link_color'] ?> !important;
     background-color: <?php echo $c['link_background_color'] ?> !important;
}

a:hover {
     color: <?php echo $c['link_hover_color'] ?> !important;     
     background-color: <?php echo $c['link_hover_background_color'] ?> !important;
}

a:active {
     color: <?php echo $c['link_active_color'] ?> !important;     
     background-color: <?php echo $c['link_active_background_color'] ?> !important;
}

.navbar-custom {
     background-color: <?php echo $c['navbar_color'] ?> !important;
     <?php
     if($c['mmenu_image_repeat'] != '0') {
          ?>
          background-image: url('../ast/layout/<?php echo $c['mmenu_image'] ?>') !important;
          
          <?php
     }
     ?>
     background-repeat: <?php echo $c['mmenu_image_repeat'] ?> !important;
     font-family: <?php echo $c['primary_font'] ?> !important;
}

.navbar-nav-custom {
     background-color: <?php echo $c['dropdown_color'] ?> !important;
}

.navbar-brand-custom {
     font-family: <?php echo $c['title_font'] ?> !important;
     font-size: <?php echo $c['title_font_size'] ?>px !important;
}

.custom-toggler {
     border-color: white;
}

.custom-toggler i {
     color: white;
}

.custom-toggler span {
     border-color: white;
     color: white;
}

.side-nav-custom {
     background-color: <?php echo $c['side-nav_color'] ?> !important;
}

.footer {
     position: absolute;
     bottom: 0;
     width: 100%;
     height: <?php echo $c['footer_height'] ?>px !important;
     background-color: #f5f5f5;
}

.footer-custom {
     background-color: <?php echo $c['footer_color'] ?> !important;
     <?php
     if($c['footer_image_repeat'] != '0') {
          ?>
          background-image: url('../ast/layout/<?php echo $c['footer_image'] ?>') !important;
          
          <?php
     }
     ?>
     background-repeat: <?php echo $c['footer_image_repeat'] ?> !important;
     font-family: <?php echo $c['primary_font'] ?> !important;
}

.button-custom {
     background-color: <?php echo $c['button_color'] ?> !important;
     font-family: <?php echo $c['primary_font'] ?> !important;     
}

.dropdown-custom {
     background-color: <?php echo $c['dropdown_color'] ?> !important;
     font-family: <?php echo $c['primary_font'] ?> !important;     
}

.dropdown-menu-custom {
     background-color: <?php echo $c['dropdown-menu_color'] ?> !important;
     font-family: <?php echo $c['primary_font'] ?> !important;     
}

.dropdown-item-custom {
     color: <?php echo $c['dropdown-item_color'] ?> !important;
     font-family: <?php echo $c['primary_font'] ?> !important;     
}

.dropdown-item-custom a:focus {
     background-color: <?php echo $c['dropdown-item-hover_color'] ?> !important;
}

.dropdown-item-custom a:hover {
     background-color: <?php echo $c['dropdown-item-hover_color'] ?> !important;
}

.card-header-custom {
     background-color: <?php echo $c['card-header_color'] ?> !important;
     <?php
     if($c['card_header_image_repeat'] != '0') {
          ?>
          background-image: url('../ast/layout/<?php echo $c['card_header_image'] ?>') !important;
          
          <?php
     }
     ?>
     background-repeat: <?php echo $c['card_header_image_repeat'] ?> !important;
     font-family: <?php echo $c['secondary_font'] ?> !important;          
}

.card-custom {
     background-color: <?php echo $c['card_color'] ?> !important;
     font-family: <?php echo $c['default_font'] ?> !important;
     min-height: 100% !important;
}

.card-transparent {
     background-color: transparent !important;
}

.no-shadow {
     box-shadow: none !important;
     -webkit-box-shadow: none !important;
}

.pagination-custom {
     background-color: <?php echo $c['pagination_color'] ?> !important;
}

.input-custom {
     background-color: <?php echo $c['input_color'] ?> !important;
     font-family: <?php echo $c['secondary_font'] ?> !important;     
}

.nav-custom {
     background-color: <?php echo $c['nav_color'] ?> !important;
     font-family: <?php echo $c['primary_font'] ?> !important;     
}

.carousel-control-custom {
     background-color: <?php echo $c['carousel-control_color'] ?> !important;
}

.form-header-custom {
     background-color: <?php echo $c['form-header_color'] ?> !important;
     font-family: <?php echo $c['secondary_font'] ?> !important;     
}

.breadcrumb-custom {
     background-color: <?php echo $c['breadcrumb_color'] ?> !important;
     font-family: <?php echo $c['secondary_font'] ?> !important;
     box-shadow: none !important;
     -webkit-box-shadow: none !important;     
}

.spinners-custom {
     color: <?php echo $c['spinners_color'] ?> !important;
}

.gradient-custom {
     background-color: <?php echo $c['gradients_color'] ?> !important;
}

.cke_contents{
     background-color: <?php echo $c['background_color'] ?>;
}

/*


    font-family: 'Open Sans', sans-serif;

    font-family: 'Oswald', sans-serif;

    font-family: 'Raleway', sans-serif;

    font-family: 'Merriweather', serif;

    font-family: 'Slabo 27px', serif;

    font-family: 'Playfair Display', serif;

    font-family: 'Titillium Web', sans-serif;

    font-family: 'Inconsolata', monospace;

    font-family: 'Dosis', sans-serif;

    font-family: 'Crimson Text', serif;

    font-family: 'Bitter', serif;

    font-family: 'Indie Flower', cursive;

    font-family: 'Anton', sans-serif;

    font-family: 'Josefin Sans', sans-serif;

    font-family: 'Lobster', cursive;

    font-family: 'Pacifico', cursive;

    font-family: 'Abel', sans-serif;

    font-family: 'Dancing Script', cursive;

    font-family: 'Shadows Into Light', cursive;

    font-family: 'Gloria Hallelujah', cursive;


*/
