<?php
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
$thm = $db->query("SELECT * FROM tbl_layout WHERE l_id = $gbl[layout]");
$t = $thm->fetch(PDO::FETCH_ASSOC);
?>

<ul class="nav nav-tabs md-tabs" id="styleTab" role="tablist">
<li class="nav-item">
<a class="nav-link active" id="colors-tab" data-toggle="tab" data-id="colors" href="#colors" role="tab" aria-controls="colors" aria-selected="true">Colors</a>
</li>
<li class="nav-item">
<a class="nav-link" id="graphics-tab" data-toggle="tab" data-id="graphics" href="#graphics" role="tab" aria-controls="graphics" aria-selected="false">Graphics</a>
</li>
<li class="nav-item">
<a class="nav-link" id="fonts-tab" data-toggle="tab" data-id="fonts" href="#fonts" role="tab" aria-controls="fonts" aria-selected="false">Fonts</a>
</li>
<li class="nav-item">
<a class="nav-link" id="layouts-tab" data-toggle="tab" data-id="layouts" href="#layouts" role="tab" aria-controls="layouts" aria-selected="false">Layout</a>
</li>
</ul>

<div class="tab-content card pt-5 card-transparent" id="styleDivs">
<div class="tab-pane fade show active" id="colors" role="tabpanel" aria-labelledby="colors-tab">
<p>The site's color scheme is based on a pre-defined "skin" or colorset. You can change the site's skin here.  If you are unhappy with specific skin colors, you can also change individual colors for the skin.  This change does NOT override the skin default colors and you can also go back to defaults.</p>
<div class="row">
<div class="col-md-4">
<?php
$skins = array('white-skin', 'black-skin', 'cyan-skin', 'mdb-skin', 'deep-purple-skin', 'navy-blue-skin', 'pink-skin', 'indigo-skin', 'light-blue-skin', 'grey-skin', 'green-skin');
?>
<small class="form-text mb-1">Select a Skin</small>
<select name="site_skin" id="site_skin" onchange="changeSkin(this.value)" class="mdb-select md-form mt-0">
<option disabled>Select a Skin</option>
<?php
foreach($skins AS $skin) {
     ?>
     <option value="<?php echo $skin ?>" <?php if($t['layout_skin'] == $skin) { echo 'selected="selected"';} ?>><?php echo str_replace("-", " ", ucwords($skin)) ?></option>
     <?php
}
?>
</select>
</div>

<div class="col-md-8">
<p>Change the color of various parts of the website.  Click "Default" to set the color to the skin's default color.</p>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="background">Site Background</label>
<div class="col-sm-5">
<input id="background" type="color" class="form-control" aria-label="Background Color" onchange="changeColor('background', this.value)" aria-describedby="background-color" value="<?php echo $t['background_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('background')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('background')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="navbar">Navigation Bar</label>
<div class="col-sm-5">
<input id="navbar" type="color" class="form-control" aria-label="Navbar Color" onchange="changeColor('navbar', this.value)" aria-describedby="navbar-color" value="<?php echo $t['navbar_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('navbar')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('navbar')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="side-nav">Side Navigation (admin)</label>
<div class="col-sm-5">
<input id="side-nav" type="color" class="form-control" aria-label="Sidenav Color" onchange="changeColor('side-nav', this.value)" aria-describedby="side-nav-color" value="<?php echo $t['side-nav_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('side-nav')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('side-nav')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="footer">Footer</label>
<div class="col-sm-5">
<input id="footer" type="color" class="form-control" aria-label="Footer Color" onchange="changeColor('footer', this.value)" aria-describedby="footer-color" value="<?php echo $t['footer_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('footer')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('footer')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="button">Buttons</label>
<div class="col-sm-5">
<input id="button" type="color" class="form-control" aria-label="Button Color" onchange="changeColor('button', this.value)" aria-describedby="button-color" value="<?php echo $t['button_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('button')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('button')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="dropdown">Dropdowns (closed)</label>
<div class="col-sm-5">
<input id="dropdown" type="color" class="form-control" aria-label="Dropdown Color" onchange="changeColor('dropdown', this.value)" aria-describedby="dropdown-color" value="<?php echo $t['dropdown_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('dropdown')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('dropdown')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="dropdown-menu">Dropdown Menus</label>
<div class="col-sm-5">
<input id="dropdown-menu" type="color" class="form-control" aria-label="Dropdown Color" onchange="changeColor('dropdown-menu', this.value)" aria-describedby="dropdown-menu-color" value="<?php echo $t['dropdown-menu_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('dropdown-menu')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('dropdown-menu')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="dropdown-item">Dropdown Menu Items</label>
<div class="col-sm-5">
<input id="dropdown-item" type="color" class="form-control" aria-label="Dropdown Item Color" onchange="changeColor('dropdown-item', this.value)" aria-describedby="dropdown-item-color" value="<?php echo $t['dropdown-item_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('dropdown-item')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('dropdown-item')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="dropdown-item-hover">Dropdown Menu Hover</label>
<div class="col-sm-5">
<input id="dropdown-item-hover" type="color" class="form-control" aria-label="Dropdown Menu Hover" onchange="changeColor('dropdown-item-hover', this.value)" aria-describedby="dropdown-item-hover-color" value="<?php echo $t['dropdown-item-hover_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('dropdown-item-hover')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('dropdown-item-hover')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="pagination">Pagination</label>
<div class="col-sm-5">
<input id="pagination" type="color" class="form-control" aria-label="Pagination" onchange="changeColor('pagination', this.value)" aria-describedby="pagination-color" value="<?php echo $t['pagination_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('pagination')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('pagination')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="input">Input (Default) Color</label>
<div class="col-sm-5">
<input id="input" type="color" class="form-control" aria-label="Input" onchange="changeColor('input', this.value)" aria-describedby="input-color" value="<?php echo $t['input_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('input')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('input')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="carousel-control">Carousel Control Color</label>
<div class="col-sm-5">
<input id="carousel-control" type="color" class="form-control" aria-label="Carousel Control" onchange="changeColor('carousel-control', this.value)" aria-describedby="carousel-control-color" value="<?php echo $t['carousel-control_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('carousel-control')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('carousel-control')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="form-header">Form Header</label>
<div class="col-sm-5">
<input id="form-header" type="color" class="form-control" aria-label="Form Header" onchange="changeColor('form-header', this.value)" aria-describedby="form-header-color" value="<?php echo $t['form-header_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('form-header')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('form-header')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="nav">Navs<br />
<small class="form-text text-muted">Includes tabs and pills</small>
</label>
<div class="col-sm-5">
<input id="nav" type="color" class="form-control" aria-label="Navs" onchange="changeColor('nav', this.value)" aria-describedby="nav-color" value="<?php echo $t['nav_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('nav')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('nav')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="card-header">Card Header</label>
<div class="col-sm-5">
<input id="card-header" type="color" class="form-control" aria-label="Card Header" onchange="changeColor('card-header', this.value)" aria-describedby="card-header-color" value="<?php echo $t['card-header_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('card-header')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('card-header')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="card">Card Background</label>
<div class="col-sm-5">
<input id="card" type="color" class="form-control" aria-label="Card Background" onchange="changeColor('card', this.value)" aria-describedby="card-color" value="<?php echo $t['card_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('card')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('card')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="breadcrumbs">Breadcrumb Color</label>
<div class="col-sm-5">
<input id="breadcrumbs" type="color" class="form-control" aria-label="Breadcrumb Color" onchange="changeColor('breadcrumb', this.value)" aria-describedby="breadcrumb-color" value="<?php echo $t['breadcrumb_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('breadcrumb')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('breadcrumb')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="spinners">Spinner <i class="spinners fa fa-circle-o-notch fa-spin spinners-custom"></i></label>
<div class="col-sm-5">
<input id="spinners" type="color" class="form-control" aria-label="Spinner" onchange="changeColor('spinners', this.value)" aria-describedby="spinners-color" value="<?php echo $t['spinners_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('spinners')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('spinners')" style="cursor: pointer;">Default</span>
</div>
</div>

<div class="form-group row">
<label class="col-sm-4 col-form-label" for="gradients">Gradients</label>
<div class="col-sm-5">
<input id="gradients" type="color" class="form-control" aria-label="Gradients" onchange="changeColor('gradients', this.value)" aria-describedby="gradients-color" value="<?php echo $t['gradients_color'] ?>" />
</div>
<div class="col-sm-3">
<span class="blue-text" onclick="setTransparent('gradients')" style="cursor: pointer;">Transparent</span>
<span class="green-text" onclick="setDefault('gradients')" style="cursor: pointer;">Default</span>
</div>
</div>

</div>
</div>

</div>

<div class="tab-pane fade" id="graphics" role="tabpanel" aria-labelledby="graphics-tab">
<p>You can add or remove various graphics or textures from parts of the site.  Be sure to select the correct X,Y, or both repeat.</p>
<div class="row">
<div class="col-md-4">
<h5 class="h5">Graphics</h5>
<small class="text-muted">The following graphical images are already available for use on the site.  To use one, click and drag it to the location on the right.  You may also upload additional items.</small>

<form class="md-form" id="backgroundform">
<div class="file-field">
<div class="btn btn-primary btn-sm float-left">
<span>Choose file</span>
<input type="file" id="background_image" name="background_image" accept="image/*" oninput="uploadFile()" />
</div>
<div class="file-path-wrapper">
<input readonly="readonly" class="file-path validate" id="graphic_filename" type="text" placeholder="Add a Graphic" />
</div>
</div>
</form>

<hr />
<div class="clearfix"></div>
<div id="deleteimage" data-toggle="tooltip" title="Drag image here to delete" ondrop="drop('delete', event)" ondragover="allowDrop(event)" class="alert alert-danger hoverable" style="text-align: center;"><i class="fa fa-trash"></i></div>
<div id="graphicsdiv">
<?php
$i = 1;
foreach(glob($gbl['doc_root'] .'ast/layout/*') AS $graphic) {
     ?>
     <img id="drag_graphic_<?php echo $i ?>" style="cursor: move;" data-id="<?php echo basename($graphic) ?>" draggable="draggable" ondragstart="drag(event)" src="<?php echo $gbl['site_url'] .'/ast/layout/'. basename($graphic) ?>" class="img-thumbnail float-left" width="80" />
     
     <?php
     $i++;
}

?>
</div>
</div>

<div class="col-md-8">
<h5 class="h5">Locations</h5>

<div class="card-deck">
<div class="card mb-4">
<div class="view overlay" ondrop="drop('background', event)" ondragover="allowDrop(event)">
<img class="card-img-top" id="background_img" height="175" src="<?php echo $gbl['site_url']. '/ast/layout/'. $t['background_image'] ?>" alt="Background Image" />
<a href="javascript:void();">
<div class="mask rgba-white-slight"></div>
</a>
</div>
<div class="card-body">
<h5 class="card-title">Background Image</h5>
<p class="card-text">Drag an image from the left onto this card to replace.</p>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('background', '0')" type="radio" id="nonebb" name="background_repeat" value="0" <?php if($t['background_image_repeat'] == '0') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="nonebb">No Image</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('background', 'repeat-x')" type="radio" id="repeatbx" name="background_repeat" value="repeat-x" <?php if($t['background_image_repeat'] == 'repeat-x') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="repeatbx">Repeat Horizontal</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('background', 'repeat-y')" type="radio" id="repeatby" name="background_repeat" value="repeat-y" <?php if($t['background_image_repeat'] == 'repeat-y') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="repeatby">Repeat Vertical</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('background', 'repeat')" type="radio" id="repeatbb" name="background_repeat" value="repeat" <?php if($t['background_image_repeat'] == 'repeat') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="repeatbb">Repeat Both</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('background', 'no-repeat')" type="radio" id="repeatbn" name="background_repeat" value="no-repeat" <?php if($t['background_image_repeat'] == 'no-repeat') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="repeatbn">No Repeat</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeFixed()" type="checkbox" id="backgroundfixed" name="background_fixed" <?php if($t['background_fixed'] == 1) { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="backgroundfixed">Fixed Background?</label>
</div>
</div>
</div>

<div class="card mb-4">
<div class="view overlay" ondrop="drop('mmenu', event)" ondragover="allowDrop(event)">
<img class="card-img-top" id="mmenu_img" height="175" src="<?php echo $gbl['site_url']. '/ast/layout/'. $t['mmenu_image'] ?>" alt="Menu Image" />
<a href="javascript:void();">
<div class="mask rgba-white-slight"></div>
</a>
</div>
<div class="card-body">
<h5 class="card-title">Menu Image</h5>
<p class="card-text">Drag an image from the left onto this card to replace.</p>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('mmenu', '0')" type="radio" id="nonemm" name="mmenu_repeat" value="0" <?php if($t['mmenu_image_repeat'] == '0') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="nonemm">No Image</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('mmenu', 'repeat-x')" type="radio" id="repeatmx" name="mmenu_repeat" value="repeat-x" <?php if($t['mmenu_image_repeat'] == 'repeat-x') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="repeatmx">Repeat Horizontal</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('mmenu', 'repeat-y')" type="radio" id="repeatmy" name="mmenu_repeat" value="repeat-y" <?php if($t['mmenu_image_repeat'] == 'repeat-y') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="repeatmy">Repeat Vertical</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('mmenu', 'repeat')" type="radio" id="repeatmb" name="mmenu_repeat" value="repeat" <?php if($t['mmenu_image_repeat'] == 'repeat') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="repeatmb">Repeat Both</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('mmenu', 'no-repeat')" type="radio" id="repeatmn" name="mmenu_repeat" value="no-repeat" <?php if($t['mmenu_image_repeat'] == 'no-repeat') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="repeatmn">No Repeat</label>
</div>
</div>
</div>

<div class="card mb-4">
<div class="view overlay" ondrop="drop('card_header', event)" ondragover="allowDrop(event)">
<img class="card-img-top" id="card_header_img" height="175" src="<?php echo $gbl['site_url']. '/ast/layout/'. $t['card_header_image'] ?>" alt="Card Header Image" />
<a href="javascript:void();">
<div class="mask rgba-white-slight"></div>
</a>
</div>
<div class="card-body">
<h5 class="card-title">Card Header Image</h5>
<p class="card-text">Drag an image from the left onto this card to replace.</p>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('card_header', '0')" type="radio" id="nonecc" name="card_header_repeat" value="0" <?php if($t['card_header_image_repeat'] == '0') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="nonecc">No Image</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('card_header', 'repeat-x')" type="radio" id="repeatcx" name="card_header_repeat" value="repeat-x" <?php if($t['card_header_image_repeat'] == 'repeat-x') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="repeatcx">Repeat Horizontal</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('card_header', 'repeat-y')" type="radio" id="repeatcy" name="card_header_repeat" value="repeat-y" <?php if($t['card_header_image_repeat'] == 'repeat-y') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="repeatcy">Repeat Vertical</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('card_header', 'repeat')" type="radio" id="repeatcb" name="card_header_repeat" value="repeat" <?php if($t['card_header_image_repeat'] == 'repeat') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="repeatcb">Repeat Both</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('card_header', 'no-repeat')" type="radio" id="repeatcn" name="card_header_repeat" value="no-repeat" <?php if($t['card_header_image_repeat'] == 'no-repeat') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="repeatcn">No Repeat</label>
</div>
</div>
</div>
</div>

<div class="card-deck">
<div class="card mb-4">
<div class="view overlay" ondrop="drop('footer', event)" ondragover="allowDrop(event)">
<img class="card-img-top" id="footer_img" height="175" src="<?php echo $gbl['site_url']. '/ast/layout/'. $t['footer_image'] ?>" alt="Footer Image" />
<a href="javascript:void();">
<div class="mask rgba-white-slight"></div>
</a>
</div>
<div class="card-body">
<h5 class="card-title">Footer Image</h5>
<p class="card-text">Drag an image from the left onto this card to replace.</p>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('footer', '0')" type="radio" id="frepeatn" name="footer_repeat" value="0" <?php if($t['footer_image_repeat'] == '0') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="frepeatn">No Image</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('footer', 'repeat-x')" type="radio" id="frepeatx" name="footer_repeat" value="repeat-x" <?php if($t['footer_image_repeat'] == 'repeat-x') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="frepeatx">Repeat Horizontal</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('footer', 'repeat-y')" type="radio" id="frepeaty" name="footer_repeat" value="repeat-y" <?php if($t['footer_image_repeat'] == 'repeat-y') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="frepeaty">Repeat Vertical</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('footer', 'repeat')" type="radio" id="frepeatb" name="footer_repeat" value="repeat" <?php if($t['footer_image_repeat'] == 'repeat') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="frepeatb">Repeat Both</label>
</div>
<div class="form-check">
<input class="form-check-input" onclick="changeRepeat('footer', 'no-repeat')" type="radio" id="frepeatno" name="footer_repeat" value="no-repeat" <?php if($t['footer_image_repeat'] == 'no-repeat') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="frepeatno">No Repeat</label>
</div>
</div>
</div>

<div class="card mb-4">
<div class="view overlay">
<img class="card-img-top" id="" height="175" src="" alt="" />
<a href="javascript:void();">
<div class="mask rgba-white-slight"></div>
</a>
</div>
<div class="card-body">

</div>
</div>

<div class="card mb-4">
<div class="view overlay">
<img class="card-img-top" id="" height="175" src="" alt="" />
<a href="javascript:void();">
<div class="mask rgba-white-slight"></div>
</a>
</div>
<div class="card-body">

</div>
</div>

</div>

</div>
</div>
</div>

<div class="tab-pane fade" id="fonts" role="tabpanel" aria-labelledby="fonts-tab">
<?php
$fontlist = array('Open Sans' => '\'Open Sans\', sans-serif', 'Oswald' => '\'Oswald\', sans-serif', 'Raleway' => '\'Raleway\', sans-serif', 'Merriweather' => '\'Merriweather\', serif', 'Slabo' => '\'Slabo 27px\', serif', 'Playfair Display' => '\'Playfair Display\', serif', 'Titillium Web' => '\'Titillium Web\', sans-serif', 'Inconsolata' => '\'Inconsolata\', monospace', 'Dosis' => '\'Dosis\', sans-serif', 'Crimson Text' => '\'Crimson Text\', serif', 'Bitter' => '\'Bitter\', serif', 'Indie Flower' => '\'Indie Flower\', cursive', 'Anton' => '\'Anton\', sans-serif', 'Josefin' => '\'Josefin Sans\', sans-serif', 'Lobster' => '\'Lobster\', cursive', 'Pacifico' => '\'Pacifico\', cursive', 'Abel' => '\'Abel\', sans-serif', 'Dancing Script' => '\'Dancing Script\', cursive', 'Shadows Into Light' => '\'Shadows Into Light\', cursive', 'Gloria Hallelujah' => '\'Gloria Hallelujah\', cursive');
?>
<p>You can change the fonts for the primary, secondary, and default fonts on the website.  The Primary font is things like titles, menus, button text, etc.  The Secondary font consists of things like subheadings, captions, tooltips, etc.  The Default font is pretty much anything else.  Keep your font selections simple.  Folks do not like odd or crazy fonts all over the place, and they do not like huge variations of fonts.</p>
<div class="card-deck">
<div class="card mb-4">
<div class="card-body">
<h4 class="card-title">Primary Font</h4>
<div class="card-text">
<select class="mdb-select md-form" name="primary-font" id="primary-font" onchange="updateFont('primary', this.value)">
<option value="" disabled>Select a Font</option>
<option value="" <?php if($t['primary_font'] == '') { echo 'selected="selected"';} ?>>Skin Default</option>
<?php
foreach($fontlist AS $name => $font) {
     ?>
     <option value="<?php echo $font ?>" <?php if($t['primary_font'] == $font) { echo 'selected="selected"';} ?>><?php echo $name ?></option>
     
     <?php
}
?>
</select>
<hr />
<p id="sampleTextp" style="font-family: <?php echo $t['primary_font'] ?>">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas luctus, ante vel varius condimentum, metus elit luctus massa, sit amet iaculis augue diam in est. Praesent vitae justo eu tortor feugiat cursus a non purus. Suspendisse porttitor sed mauris at efficitur. Pellentesque condimentum elit in tortor dictum, sit amet blandit risus gravida. Sed hendrerit accumsan felis. In hac habitasse platea dictumst. Vivamus diam magna, bibendum a dolor sagittis, tincidunt varius erat. Nulla non mauris vel sem suscipit fringilla. Duis non enim vitae dolor tristique egestas. 
</p>
</div>
</div>
</div>

<div class="card mb-4">
<div class="card-body">
<h4 class="card-title">Secondary Font</h4>
<div class="card-text">
<select class="mdb-select md-form" name="secondary-font" id="secondary-font" onchange="updateFont('secondary', this.value)">
<option value="" disabled>Select a Font</option>
<option value="" <?php if($t['secondary_font'] == '') { echo 'selected="selected"';} ?>>Skin Default</option>
<?php
foreach($fontlist AS $name => $font) {
     ?>
     <option value="<?php echo $font ?>" <?php if($t['secondary_font'] == $font) { echo 'selected="selected"';} ?>><?php echo $name ?></option>
     
     <?php
}
?>
</select>
<hr />
<p id="sampleTexts" style="font-family: <?php echo $t['secondary_font'] ?>">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas luctus, ante vel varius condimentum, metus elit luctus massa, sit amet iaculis augue diam in est. Praesent vitae justo eu tortor feugiat cursus a non purus. Suspendisse porttitor sed mauris at efficitur. Pellentesque condimentum elit in tortor dictum, sit amet blandit risus gravida. Sed hendrerit accumsan felis. In hac habitasse platea dictumst. Vivamus diam magna, bibendum a dolor sagittis, tincidunt varius erat. Nulla non mauris vel sem suscipit fringilla. Duis non enim vitae dolor tristique egestas. 
</p>
</div>
</div>
</div>

<div class="card mb-4">
<div class="card-body">
<h4 class="card-title">Default Font</h4>
<div class="card-text">
<select class="mdb-select md-form" name="default-font" id="default-font" onchange="updateFont('default', this.value)">
<option value="" disabled>Select a Font</option>
<option value="" <?php if($t['default_font'] == '') { echo 'selected="selected"';} ?>>Skin Default</option>
<?php
foreach($fontlist AS $name => $font) {
     ?>
     <option value="<?php echo $font ?>" <?php if($t['default_font'] == $font) { echo 'selected="selected"';} ?>><?php echo $name ?></option>
     
     <?php
}
?>
</select>
<hr />
<p id="sampleTextd" style="font-family: <?php echo $t['default_font'] ?>">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas luctus, ante vel varius condimentum, metus elit luctus massa, sit amet iaculis augue diam in est. Praesent vitae justo eu tortor feugiat cursus a non purus. Suspendisse porttitor sed mauris at efficitur. Pellentesque condimentum elit in tortor dictum, sit amet blandit risus gravida. Sed hendrerit accumsan felis. In hac habitasse platea dictumst. Vivamus diam magna, bibendum a dolor sagittis, tincidunt varius erat. Nulla non mauris vel sem suscipit fringilla. Duis non enim vitae dolor tristique egestas. 
</p>
</div>
</div>
</div>

<div class="card mb-4">
<div class="card-body">
<h4 class="card-title">Site Title Font</h4>
<div class="card-text">
<select class="mdb-select md-form" name="title-font" id="title-font" onchange="updateFont('title', this.value)">
<option value="" disabled>Select a Font</option>
<option value="" <?php if($t['title_font'] == '') { echo 'selected="selected"';} ?>>Skin Default</option>
<?php
foreach($fontlist AS $name => $font) {
     ?>
     <option value="<?php echo $font ?>" <?php if($t['title_font'] == $font) { echo 'selected="selected"';} ?>><?php echo $name ?></option>
     
     <?php
}
?>
</select>
<hr />
<p id="sampleTextt" style="font-family: <?php echo $t['title_font'] ?>; font-size: <?php echo $t['title_font_size'] ?>px;">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas luctus, ante vel varius condimentum, metus elit luctus massa, sit amet iaculis augue diam in est. Praesent vitae justo eu tortor feugiat cursus a non purus. Suspendisse porttitor sed mauris at efficitur. Pellentesque condimentum elit in tortor dictum, sit amet blandit risus gravida. Sed hendrerit accumsan felis. In hac habitasse platea dictumst. Vivamus diam magna, bibendum a dolor sagittis, tincidunt varius erat. Nulla non mauris vel sem suscipit fringilla. Duis non enim vitae dolor tristique egestas. 
</p>
</div>
<div class="md-form input-group mb-2">
<input type="text" name="title-font-size" id="title-font-size" onblur="updateFont('title_font', this.value)" class="form-control" value="<?php echo $t['title_font_size'] ?>" />
<div class="input-group-apppend">
<span class="input-group-text md-addon">px.</span>
</div>
<label for="title-font-size">Font Size for Title</label>
</div>
</div>
</div>

</div>

</div>

<div class="tab-pane fade" id="layouts" role="tabpanel" aria-labelledby="layouts-tab">
<p>Change some of the global content throughout the site such as footers or headers.</p>
<div class="row">
<div class="col-md-12">
<div class="card-deck">

<div class="card mb-3">
<div class="card-body">
<h5 class="card-title h5">Menu Bar Position</h5>
<p class="card-text">Select top, bottom or sticky top.</p>
<div class="form-check">
<input class="form-check-input" type="radio" name="menu_location" id="menu_locationt" onclick="changeLayout('menu_location', this.value)" value="fixed-top" <?php if($t['menu_location'] == 'fixed-top') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="menu_locationt">Top (fixed)</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="menu_location" id="menu_locationb" onclick="changeLayout('menu_location', this.value)" value="fixed-bottom" <?php if($t['menu_location'] == 'fixed-bottom') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="menu_locationb">Bottom (fixed)</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="menu_location" id="menu_locationst" onclick="changeLayout('menu_location', this.value)" value="sticky-top" <?php if($t['menu_location'] == 'sticky-top') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="menu_locationst">Sticky Top</label>
</div>
</div>
</div>

<div class="card mb-3">
<div class="card-body">
<h5 class="card-title h5">Menu Alignment</h5>
<p class="card-text">Set to your liking</p>
<div class="form-check">
<input class="form-check-input" type="radio" name="menu_alignment" id="menu_alignmentl" onclick="changeLayout('menu_alignment', this.value)" value="mr-auto" <?php if($t['menu_alignment'] == 'mr-auto') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="menu_alignmentl">Left Align</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="menu_alignment" id="menu_alignmentr" onclick="changeLayout('menu_alignment', this.value)" value="ml-auto" <?php if($t['menu_alignment'] == 'ml-auto') { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="menu_alignmentr">Right Align</label>
</div>
</div>
</div>

<div class="card mb-3">
<div class="card-body">
<h5 class="card-title h5">Site Search Box</h5>
<p class="card-text">Disabling removes this feature from the site.</p>
<div class="form-check">
<input class="form-check-input" type="radio" name="search_form" id="search_form1" onclick="changeLayout('search_form', this.value)" value="1" <?php if($t['search_form'] == 1) { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="search_form1">Enabled</label>
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="search_form" id="search_form0" onclick="changeLayout('search_form', this.value)" value="0" <?php if($t['search_form'] == 0) { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="search_form0">Disabled</label>
</div>
</div>
</div>

<div class="card mb-3">
<div class="card-body">
<h5 class="card-title h5">Menu Height</h5>
<p class="card-text">Change to your liking (in pixels)</p>
<div class="md-form input-group">
<input type="number" min="10" max="300" name="menu_height" id="menu_height" onblur="changeLayout('menu_height', this.value)" value="<?php echo $t['menu_height'] ?>" />
<div class="input-group-apppend">
<span class="input-group-text md-addon">px.</span>
</div>
</div>
</div>
</div>
</div>

</div>
</div>

<div class="row">
<div class="col-md-12">
<div class="card-deck">

<div class="card mb-3">
<div class="card-body">
<h5 class="card-title h5">Breadcrumbs</h5>
<p class="card-text">This is the small text above the Footer showing the user which page or child page he is viewing.</p>
<div class="form-check">
<input class="form-check-input" type="radio" name="breadcrumbs" id="breadcrumbs1" onclick="changeLayout('breadcrumbs', this.value)" value="1" <?php if($t['breadcrumbs'] == 1) { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="breadcrumbs1">Enabled</label> 
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="breadcrumbs" id="breadcrumbs0" onclick="changeLayout('breadcrumbs', this.value)" value="0" <?php if($t['breadcrumbs'] == 0) { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="breadcrumbs0">Disabled</label> 
</div>
</div>
</div>

<div class="card mb-3">
<div class="card-body">
<h5 class="card-title h5">Print Friendly Icons</h5>
<p class="card-text">This is the feature which allows a user to print the page in a friendly-looking manner.</p>
<div class="form-check">
<input class="form-check-input" type="radio" name="print_friendly" id="print_friendly1" onclick="changeLayout('print_friendly', this.value)" value="1" <?php if($t['print_friendly'] == 1) { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="print_friendly1">Enabled</label> 
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="print_friendly" id="print_friendly0" onclick="changeLayout('print_friendly', this.value)" value="0" <?php if($t['print_friendly'] == 0) { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="print_friendly0">Disabled</label> 
</div>
</div>
</div>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="card-deck">

<div class="card mb-3">
<div class="card-body">
<h5 class="card-title h5">Footer Columns</h5>
<p class="card-text">You can have from 1 to 4 Footer Columns in the main Footer section.  4 is default</p>
<div class="form-check">
<input class="form-check-input" type="radio" name="footer_columns" id="footer_columns1" onclick="changeLayout('footer_columns', this.value)" value="1" <?php if($t['footer_columns'] == 1) { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="footer_columns1">One</label> 
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="footer_columns" id="footer_columns2" onclick="changeLayout('footer_columns', this.value)" value="2" <?php if($t['footer_columns'] == 2) { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="footer_columns2">Two</label> 
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="footer_columns" id="footer_columns3" onclick="changeLayout('footer_columns', this.value)" value="3" <?php if($t['footer_columns'] == 3) { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="footer_columns3">Three</label> 
</div>
<div class="form-check">
<input class="form-check-input" type="radio" name="footer_columns" id="footer_columns4" onclick="changeLayout('footer_columns', this.value)" value="4" <?php if($t['footer_columns'] == 4) { echo 'checked="checked"';} ?> />
<label class="form-check-label" for="footer_columns4">Four</label> 
</div>
</div>
</div>

<div class="card mb-3">
<div class="card-body">
<h5 class="card-title h5">Column 1 Content</h5>
<p class="card-text">Enter your HTML content below.  Content saves as you type.</p>
<textarea name="footer_content_1" id="footer_content_1"><?php echo $t['footer_content_1'] ?></textarea>
<script>
                                                                                       
CKEDITOR.replace('footer_content_1', {
     enterMode: CKEDITOR.ENTER_BR,
     customConfig: '<?php echo $gbl['site_url'] ?>/js/ckeditor_config.js'                      
})
.on('blur', function(e){
     setTimeout(function(){
          changeLayout('footer_content_1', e.editor.getData());
     },10);
});
</script>
</div>
</div>

<div class="card mb-3">
<div class="card-body">
<h5 class="card-title h5">Column 2 Content</h5>
<p class="card-text">Enter your HTML content below.  Content saves as you type.</p>
<textarea name="footer_content_2" id="footer_content_2"><?php echo $t['footer_content_2'] ?></textarea>
<script>
CKEDITOR.replace('footer_content_2', {
     enterMode: CKEDITOR.ENTER_BR,
     customConfig: '<?php echo $gbl['site_url'] ?>/js/ckeditor_config.js'                    
})
.on('blur', function(e){
     setTimeout(function(){
          changeLayout('footer_content_1', e.editor.getData());
     },10);
});
</script>
</div>
</div>

<div class="card mb-3">
<div class="card-body">
<h5 class="card-title h5">Column 3 Content</h5>
<p class="card-text">Enter your HTML content below.  Content saves as you type.</p>
<textarea name="footer_content_3" id="footer_content_3"><?php echo $t['footer_content_3'] ?></textarea>
<script>
CKEDITOR.replace('footer_content_3', {
     enterMode: CKEDITOR.ENTER_BR,
     customConfig: '<?php echo $gbl['site_url'] ?>/js/ckeditor_config.js'                    
})
.on('blur', function(e){
     setTimeout(function(){
          changeLayout('footer_content_1', e.editor.getData());
     },10);
});
</script>
</div>
</div>

<div class="card mb-3">
<div class="card-body">
<h5 class="card-title h5">Column 4 Content</h5>
<p class="card-text">Enter your HTML content below.  Content saves as you type.</p>
<textarea name="footer_content_4" id="footer_content_4"><?php echo $t['footer_content_4'] ?></textarea>
<script>                                                                                        
CKEDITOR.replace('footer_content_4', {
     enterMode: CKEDITOR.ENTER_BR,
     customConfig: '<?php echo $gbl['site_url'] ?>/js/ckeditor_config.js'                     
})
.on('blur', function(e){
     setTimeout(function(){
          changeLayout('footer_content_1', e.editor.getData());
     },10);
});
</script>
</div>
</div>

</div>
</div>
</div>
</div>


</div>

<script>
function changeLayout(f,v)
{ 
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/style/ajax.php',
          type: 'POST',
          data: {
               'change_layout': 1,
               'field': f,
               'value': v
          },
          success: function(data) {
               switch(f) {
                    case 'menu_location':
                         $('#mainNavigation').removeClass('fixed-bottom');
                         $('#mainNavigation').removeClass('fixed-top');
                         $('#mainNavigation').removeClass('sticky-top');
                         $('#mainNavigation').addClass(v);
                         break;
                    case 'menu_alignment':
                         $('#mainNavmenu').removeClass('mr-auto');
                         $('#mainNavmenu').removeClass('ml-auto');
                         $('#mainNavmenu').addClass(v);                    
                         break;
                    case 'search_form':
                         if(v == 1) {
                              $('#searchForm').show();
                         }
                         if(v == 0) {
                              $('#searchForm').hide();
                         }
                         break;
                    case 'menu_height':
                         $('#mainNavigation').prop('style', 'height: '+ v +'px;');
                         break;
                    case 'breadcrumbs':
                         if(v == 1) {
                              $('#breadcrumbss').css('display', 'inherit');
                         }
                         if(v == 0) {
                              $('#breadcrumbss').css('display', 'none');
                         }
                         break;
                    case 'print_friendly':
                         if(v == 1) {
                              $('#printfriendly').css('display', 'inherit');                              
                         }
                         if(v == 0) {
                              $('#printfriendly').css('display', 'none');                              
                         }
                         break;
                    case 'footer_content_1':
                         $('#f1').html(v);
                         break;
                    case 'footer_content_2':
                         $('#f2').html(v);
                         break;
                    case 'footer_content_3':
                         $('#f3').html(v);
                         break;
                    case 'footer_content_4':
                         $('#f4').html(v);
                         break;
                    default:
                         break;
               }
          }
     })
}
function changeSkin(skin)
{
     $('body').prop("class", skin);
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/style/ajax.php',
          type: 'POST',
          data: {
               'change_skin': 1,
               'new_skin': skin
          }
     })
}
function setDefault(myclass)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/style/ajax.php',
          type: 'POST',
          data: {
               'set_default': 1,
               'class': myclass
          },
          success: function(data) {
               switch(myclass) {
                    case 'spinners':
                         $('.' + myclass).prop("style", "");
                         $('#'+ myclass).val('');                         
                         break;
                    case 'breadcrumb':
                         $('.' + myclass + 'bar').prop("style", "");
                         $('#'+ myclass +'s').val('');                          
                         break;
                    default:
                         $('.'+ myclass).removeClass(myclass +'-custom');
                         $('.' + myclass).prop("style", "");
                         $('#'+ myclass).val('');
                         break;                         
               }               
          }
     })
}
function setTransparent(myclass)
{
     $('.'+ myclass).removeClass(myclass +'-custom');
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/style/ajax.php',
          type: 'POST',
          data: {
               'set_transparent': 1,
               'class': myclass
          },
          success: function(data) {
               switch(myclass) {
                    case 'spinners':
                         $('.' + myclass).prop("style", "color: transparent !important;");
                         $('#'+ myclass).val('transparent');                    
                         break;
                    case 'breadcrumb':
                         $('.' + myclass +'bar').prop("style", "background-color: transparent !important");
                         $('#'+ myclass +'s').val('transparent');                    
                         break;
                    default:
                         $('.' + myclass).prop("style", "background-color: transparent !important");
                         $('#'+ myclass).val('transparent');
                         break;                    
               }
          }             
     })     
}
function changeColor(myclass, mycolor)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/style/ajax.php',
          type: 'POST',
          data: {
               'change_color': 1,
               'class': myclass,
               'color': mycolor
          },
          success: function(data) {
               switch(myclass) {
                    case 'spinners':
                         $('.' + myclass).prop("style", "color: " + mycolor +" !important;");
                         break;
                    case 'breadcrumb':
                         $('.'+ myclass +'bar').removeClass(myclass +'-custom');                    
                         $('.' + myclass +'bar').prop("style", "background-color: " + mycolor +" !important;");
                         break;
                    case 'background':
                         $('.body-custom').prop("style", "background-color: " + mycolor +" !important;");                    
                         break;
                    default:
                         $('.'+ myclass).removeClass(myclass +'-custom');                    
                         $('.' + myclass).prop("style", "background-color: " + mycolor +" !important;");
                         break;                         
               }
          }          
     })
}
function uploadFile()
{
     var formData = new FormData();
     formData.append('background_image', $('#background_image')[0].files[0]);
     formData.append('add_graphic', '1');
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/style/ajax.php',
          type: 'POST',
          processData: false,
          contentType: false,
          data: formData,
          success: function(data) {
               $('#graphic_filename').val('');
               $('#graphicsdiv').html(data);
          }
     })
}
function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function drop(dest, ev) {
     ev.preventDefault();
     var datas = ev.dataTransfer.getData("text");
     var file = $('#'+datas).attr('data-id');
     ev.target.appendChild(document.getElementById(datas));
     if(dest == 'delete') {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/style/ajax.php',
               type: 'POST',
               data: {
                    'delete_image': '1',
                    'filename': file
               },
               success: function(data) {
                    $('#'+ datas).remove();                    
               }
          })
     } else {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/style/ajax.php',
               type: 'POST',
               data: {
                    'update_graphic': 1,
                    'graphic_location': dest,
                    'graphic_file': file
               },
               success: function(data) {
                    switch(dest) {
                         case 'background':
                              $('.body-main').removeClass('body-custom');
                              $('.body-main').css({'background-image':'url(<?php echo $gbl['site_url'] ?>/ast/layout/'+ file +')', 'background-repeat':'no-repeat'});
                              break;
                         case 'menu':
                              $('.navbar-main').removeClass('navbar-custom');
                              $('.navbar-main').css({'background-image':'url(<?php echo $gbl['site_url'] ?>/ast/layout/'+ file +')', 'background-repeat':'no-repeat'});
                              break;
                         case 'card-header':
                              $('.card-header').removeClass('card-header-custom');
                              $('.card-header').css({'background-image':'url(<?php echo $gbl['site_url'] ?>/ast/layout/'+ file +')', 'background-repeat':'no-repeat'});
                              break;
                         case 'footer':
                              $('.footer').removeClass('footer-custom');
                              $('.footer').css({'background-image':'url(<?php echo $gbl['site_url'] ?>/ast/layout/'+ file +')', 'background-repeat':'no-repeat'});
                              break;                    
                         default:
                              break;
                    }
                    $('#'+ dest +'_img').prop('src', data);
                    $('#'+ dest +'_img').prop('style', 'background-repeat: no-repeat');
                    var rad = $('input:radio[name='+dest+'_repeat]');
                    rad.filter('[value=no-repeat]').prop('checked', true);
                    $('#'+ datas).remove();
               }
          })
     }
}
function changeRepeat(location, repeattype)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/style/ajax.php',
          type: 'POST',
          data: {
               'change_repeat': '1',
               'location': location,
               'val': repeattype
          },
          success: function(data) {
               switch(location) {
                    case 'background':
                         if(repeattype == 0) {
                              $('.body-custom').prop('style', '');
                              $('#'+ location +'_img').prop('src', '');
                         } else {
                              $('.body-main').css('background-repeat', repeattype +'');
                         }
                         break;
                    case 'menu':
                         if(repeattype == 0) {
                              $('.navbar-main').prop('style', ''); 
                              $('.navbar').removeClass('navbar-custom');
                              $('#'+ location +'_img').prop('src', '');                                                                                          
                         } else {
                              $('.navbar-main').css('background-repeat', repeattype +'');
                              $('.navbar').addClass('navbar-custom');
                         }
                         break;
                    case 'card-header':
                         if(repeattype == 0) {
                              $('.card-header-custom').prop('style', '');
                              $('.card-header').removeClass('card-header-custom');
                              $('#'+ location +'_img').prop('src', '');                              
                         } else {
                              $('.card-header').css('background-repeat', repeattype +'');
                              $('.card-header').addClass('card-header-custom');                              
                         }
                         break;
                    case 'footer':
                         if(repeattype == 0) {
                              $('.footer-custom').prop('style', '');
                              $('.footer').removeClass('footer-custom');
                              $('#'+ location +'_img').prop('src', '');                              
                         } else {
                              $('.footer').css('background-repeat', repeattype +'');
                              $('.footer').addClass('footer-custom');                              
                         }
                         break;                    
                    default:
                         break;
               }               
          }
     })
}
function changeFixed()
{
     if($('#backgroundfixed').prop('checked')) {
          chk = 1;
     } else {
          chk = 0;
     }
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/style/ajax.php',
          type: 'POST',
          data: {
               'change_fixed': '1',
               'checked': chk,
          },
          success: function(data) {
               if(chk == 0) {
                    $('body').removeClass('background-fixed');
               }
               if(chk == 1) {
                    $('body').addClass('background-fixed');
               }
          }
     })
}
function updateFont(psd, family)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/style/ajax.php',
          type: 'POST',
          data: {
               'update_font': 1,
               'psd': psd,
               'family': family
          },
          success: function(data) {
               switch(psd) {
                    case 'primary':
                         $('#sampleTextp').prop('style', 'font-family: '+ family);
                         break;
                    case 'secondary':
                         $('#sampleTexts').prop('style', 'font-family: '+ family);
                         break;
                    case 'default':
                         $('#sampleTextd').prop('style', 'font-family: '+ family);
                         break;
                    case 'title':
                         $('#sampleTextt').prop('style', 'font-family: '+ family);
                         $('#navbrand').css('cssText', 'font-family: '+family+' !important;');                         
                         break;
                    case 'title_font':
                         $('#sampleTextt').css('font-size', family +'px');
                         $('#navbrand').css('cssText', 'font-size: '+family+'px !important;');
                         break;                    
                    default:
                         break;
               }               
          }
     })
}
</script>