<?php
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
$carset = $db->query("SELECT * FROM tbl_carousel_settings WHERE cs_id = 1");
$cs = $carset->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
<div class="row">
<div class="col-md-7">
<div class="row">
<div class="col-md-12">
<div id="carousels">
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
</div>    
</div>
<div class="col-md-12">
<hr />
<div class="row">
<div class="col-6 pl-0 ml-0">
<b>Controls</b>
<div class="switch">
<label>
Off
<input id="controls" type="checkbox" onchange="changeValue('controls')" <?php if($cs['controls'] == 1) { echo 'checked="checked"'; } ?> />
<span class="lever"></span> On
</label>
</div>
<small class="form-text text-muted mb-2">(<span class="fa fa-chevron-left"></span> and <span class="fa fa-chevron-right"></span>)</small>
</div>

<div class="col-6">
<b>Indicators</b>
<div class="switch">
<label>
Off
<input id="indicatorss" type="checkbox" onchange="changeValue('indicatorss')" <?php if($cs['indicators'] == 1) { echo 'checked="checked"'; } ?> />
<span class="lever"></span> On
</label>
</div>
<small class="form-text text-muted mb-2">(dots near the bottom of each slide)</small>
</div>
</div>

<div class="row">
<div class="col-6 pl-0 ml-0">
<b>Slide Animations</b>
<div class="switch">
<label>
Off
<input id="animations" type="checkbox" onchange="changeValue('animations')" <?php if($cs['animations'] == 1) { echo 'checked="checked"'; } ?> />
<span class="lever"></span> On
</label>
</div>
<small class="form-text text-muted mb-2">If enabled, select options for Slide and Text for each slide.</small>
</div>
<div class="col-6">
<b>Hover Pause</b>
<div class="switch">
<label>
Off
<input id="hoverpause" type="checkbox" onchange="changeValue('hoverpause')" <?php if($cs['hover_pause'] == 'hover') { echo 'checked="checked"'; } ?> />
<span class="lever"></span> On
</label>
</div>
<small class="form-text text-muted mb-2">If enabled, the slide will not transition to next slide on mouse hover.</small>
</div>
</div>

<div class="row">
<div class="col-6 pl-0 ml-0">
<b>Slide Wrap</b>
<div class="switch">
<label>
Off
<input id="wrapping" type="checkbox" onchange="changeValue('wrapping')" <?php if($cs['wrapping'] == 1) { echo 'checked="checked"'; } ?> />
<span class="lever"></span> On
</label>
</div>
<small class="form-text text-muted mb-2">If enabled, the carousel will start over after the last slide.</small>
</div>
<div class="col-6">
<div class="md-form">
<input type="number" name="interval" id="interval" onchange="changeValue('interval')" min="1" max="10" class="form-control" value="<?php echo $cs['interval'] ?>" />
<label for="interval">Interval</label>
</div>
<small class="form-text text-muted mb-2">Number of seconds to delay between each slide change.</small>
</div>
</div>

</div>
</div>
</div>
<div class="col-md-5">

<div class="accordion dragarea" id="slidesEx" role="tablist" aria-multiselectable="false">

<?php
$c = 1;
$slide = $db->query("SELECT * FROM tbl_carousel ORDER BY car_order");
while($sl = $slide->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <div class="card" draggable="true" id="item-<?php echo $sl['c_id'] ?>">
     <div class="card-header" role="tab" id="slide<?php echo $c ?>">
     <a class="collapsed" data-toggle="collapse" href="#collapse<?php echo $c ?>" aria-expanded="false" aria-controls="collapse<?php echo $c ?>">
     <h5 class="mb-0">Slide <?php echo $c ?><i class="fa fa-angle-down rotate-icon"></i></h5></a>
     </div>
     <div id="collapse<?php echo $c ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?php echo $c ?>" data-parent="#slidesEx">
     <div class="view">
     <?php
     if($sl['car_url'] > '') {
          ?>
          <a href="<?php echo $sl['car_url'] ?>" target="_blank">
          <img class="card-img-top" id="slide-<?php echo $sl['c_id'] ?>" src="<?php echo $gbl['site_url'] ?>/ast/carousel/<?php echo $sl['car_image'] ?>" />
          </a>
          
          <?php
     } else {
          ?>
          <img class="card-img-top" id="slide-<?php echo $sl['c_id'] ?>" src="<?php echo $gbl['site_url'] ?>/ast/carousel/<?php echo $sl['car_image'] ?>" />
          
          <?php
     }
     if($sl['car_status'] == 0) {
          ?>
          <div id="overlay-<?php echo $sl['c_id'] ?>" class="mask flex-center rgba-black-strong">
          <p id="otext-<?php echo $sl['c_id'] ?>" class="white-text">DISABLED</p>
          </div> 
                   
          <?php
     } else {
          $exp = explode("-", $sl['car_caption_size']);
          $csize = $exp[0];
          ?>
          <div id="overlay-<?php echo $sl['c_id'] ?>" class="mask flex-center <?php echo $sl['car_mask'] ?>">
          <div class="carousel-caption">
          <<?php echo $csize ?> id="ocaption-<?php echo $sl['c_id'] ?>" class="ocaption-<?php echo $sl['c_id'] ?> <?php echo $sl['car_caption_size'] ?>"><?php echo $sl['car_caption'] ?></<?php echo $csize ?>>
          <p id="otext-<?php echo $sl['c_id'] ?>" class="white-text"><?php echo $sl['car_text'] ?></p>
          </div>
          </div> 
                   
          <?php          
     }
     ?>
     </div>
     <div class="card-body">
     <div class="row">
     <div class="col">
     <b>Visibility</b>
     <div class="switch">
     <label>
     Off
     <input id="car_status-<?php echo $sl['c_id'] ?>" type="checkbox" onchange="changeSlide('car_status', '<?php echo $sl['c_id'] ?>')" <?php if($sl['car_status'] == 1) { echo 'checked="checked"'; } ?> />
     <span class="lever"></span> On
     </label>
     </div>
     </div>
     <div class="col">
     <button type="button" class="btn btn-danger" onclick="deleteSlide('<?php echo $sl['c_id'] ?>')"><i class="fa fa-trash"></i> Delete</button>
     </div>
     </div>
     
     <div class="md-form">
     <input type="text" name="car_caption-<?php echo $sl['c_id'] ?>" id="car_caption-<?php echo $sl['c_id'] ?>" onkeyup="changeSlide('car_caption', '<?php echo $sl['c_id'] ?>')" value="<?php echo $sl['car_caption'] ?>" class="form-control" />
     <label for="car_caption-<?php echo $sl['c_id'] ?>">Slide Caption</label>
     </div>

     <label class="mb-1">Caption Size</label>
     <select name="car_caption_size-<?php echo $sl['c_id'] ?>" id="car_caption_size-<?php echo $sl['c_id'] ?>" class="mdb-select md-form mt-1" onchange="changeSlide('car_caption_size', '<?php echo $sl['c_id'] ?>')">
     <option disabled>Select a Size</option>
     <option <?php if($sl['car_caption_size'] == 'h5-responsive') { echo 'selected="selected"'; } ?> value="h5-responsive" class="h5-responsive">Extra Small</option>
     <option <?php if($sl['car_caption_size'] == 'h4-responsive') { echo 'selected="selected"'; } ?> value="h4-responsive" class="h4-responsive">Small</option>
     <option <?php if($sl['car_caption_size'] == 'h3-responsive') { echo 'selected="selected"'; } ?> value="h3-responsive" class="h3-responsive">Medium</option>
     <option <?php if($sl['car_caption_size'] == 'h2-responsive') { echo 'selected="selected"'; } ?> value="h2-responsive" class="h2-responsive">Large</option>
     <option <?php if($sl['car_caption_size'] == 'h1-responsive') { echo 'selected="selected"'; } ?> value="h1-responsive" class="h1-responsive">Extra Large</option>
     </select>
     
     <div class="md-form">
     <input type="text" name="car_text-<?php echo $sl['c_id'] ?>" id="car_text-<?php echo $sl['c_id'] ?>" onkeyup="changeSlide('car_text', '<?php echo $sl['c_id'] ?>')" value="<?php echo $sl['car_text'] ?>" class="form-control" />
     <label for="car_text-<?php echo $sl['c_id'] ?>">Slide Text</label>
     <small class="form-text text-muted mb-2">Additional text below the Caption.</small>
     </div>

     <div class="md-form">
     <input type="url" name="car_url-<?php echo $sl['c_id'] ?>" id="car_url-<?php echo $sl['c_id'] ?>" onblur="changeSlide('car_url', '<?php echo $sl['c_id'] ?>')" value="<?php echo $sl['car_url'] ?>" class="form-control" />
     <label for="car_url-<?php echo $sl['c_id'] ?>">Slide URL</label>
     <small class="form-text text-muted mt-1 mb-2">URL that opens when the slide it clicked.</small>
     </div>
     
     <label class="mb-1">Image Mask or Overlay</label>
     <select name="car_mask-<?php echo $sl['c_id'] ?>" id="car_mask-<?php echo $sl['c_id'] ?>" class="mdb-select md-form mt-1" onchange="changeSlide('car_mask', '<?php echo $sl['c_id'] ?>')">
     <option disabled selected>Select an Option</option>
     <option value="">None</option>     
     <optgroup label="Patterns"></optgroup>
     <option <?php if($sl['car_mask'] == 'pattern-1') { echo 'selected="selected"'; } ?> value="pattern-1">Overlay 1</option>
     <option <?php if($sl['car_mask'] == 'pattern-2') { echo 'selected="selected"'; } ?> value="pattern-2">Overlay 2</option>
     <option <?php if($sl['car_mask'] == 'pattern-3') { echo 'selected="selected"'; } ?> value="pattern-3">Overlay 3</option>
     <option <?php if($sl['car_mask'] == 'pattern-4') { echo 'selected="selected"'; } ?> value="pattern-4">Overlay 4</option>
     <option <?php if($sl['car_mask'] == 'pattern-5') { echo 'selected="selected"'; } ?> value="pattern-5">Overlay 5</option>
     <option <?php if($sl['car_mask'] == 'pattern-6') { echo 'selected="selected"'; } ?> value="pattern-6">Overlay 6</option>
     <option <?php if($sl['car_mask'] == 'pattern-7') { echo 'selected="selected"'; } ?> value="pattern-7">Overlay 7</option>
     <option <?php if($sl['car_mask'] == 'pattern-8') { echo 'selected="selected"'; } ?> value="pattern-8">Overlay 8</option>                               
     <optgroup label="Masks"></optgroup>
     <option <?php if($sl['car_mask'] == 'rgba-blue-light') { echo 'selected="selected"'; } ?> value="rgba-blue-light">Light Blue</option>
     <option <?php if($sl['car_mask'] == 'rgba-blue-strong') { echo 'selected="selected"'; } ?> value="rgba-blue-strong">Dark Blue</option>
     <option <?php if($sl['car_mask'] == 'rgba-blue-slight') { echo 'selected="selected"'; } ?> value="rgba-blue-slight">Slight Blue</option>
     <option <?php if($sl['car_mask'] == 'rgba-red-light') { echo 'selected="selected"'; } ?> value="rgba-red-light">Light red</option>
     <option <?php if($sl['car_mask'] == 'rgba-red-strong') { echo 'selected="selected"'; } ?> value="rgba-red-strong">Dark red</option>
     <option <?php if($sl['car_mask'] == 'rgba-red-slight') { echo 'selected="selected"'; } ?> value="rgba-red-slight">Slight red</option>               
     <option <?php if($sl['car_mask'] == 'rgba-pink-light') { echo 'selected="selected"'; } ?> value="rgba-pink-light">Light pink</option>
     <option <?php if($sl['car_mask'] == 'rgba-pink-strong') { echo 'selected="selected"'; } ?> value="rgba-pink-strong">Dark pink</option>
     <option <?php if($sl['car_mask'] == 'rgba-pink-slight') { echo 'selected="selected"'; } ?> value="rgba-pink-slight">Slight pink</option>
     <option <?php if($sl['car_mask'] == 'rgba-purple-light') { echo 'selected="selected"'; } ?> value="rgba-purple-light">Light purple</option>
     <option <?php if($sl['car_mask'] == 'rgba-purple-strong') { echo 'selected="selected"'; } ?> value="rgba-purple-strong">Dark purple</option>
     <option <?php if($sl['car_mask'] == 'rgba-purple-slight') { echo 'selected="selected"'; } ?> value="rgba-purple-slight">Slight purple</option>
     <option <?php if($sl['car_mask'] == 'rgba-indigo-light') { echo 'selected="selected"'; } ?> value="rgba-indigo-light">Light indigo</option>
     <option <?php if($sl['car_mask'] == 'rgba-indigo-strong') { echo 'selected="selected"'; } ?> value="rgba-indigo-strong">Dark indigo</option>
     <option <?php if($sl['car_mask'] == 'rgba-indigo-slight') { echo 'selected="selected"'; } ?> value="rgba-indigo-slight">Slight indigo</option>
     <option <?php if($sl['car_mask'] == 'rgba-cyan-light') { echo 'selected="selected"'; } ?> value="rgba-cyan-light">Light cyan</option>
     <option <?php if($sl['car_mask'] == 'rgba-cyan-strong') { echo 'selected="selected"'; } ?> value="rgba-cyan-strong">Dark cyan</option>
     <option <?php if($sl['car_mask'] == 'rgba-cyan-slight') { echo 'selected="selected"'; } ?> value="rgba-cyan-slight">Slight cyan</option>
     <option <?php if($sl['car_mask'] == 'rgba-green-light') { echo 'selected="selected"'; } ?> value="rgba-green-light">Light green</option>
     <option <?php if($sl['car_mask'] == 'rgba-green-strong') { echo 'selected="selected"'; } ?> value="rgba-green-strong">Dark green</option>
     <option <?php if($sl['car_mask'] == 'rgba-green-slight') { echo 'selected="selected"'; } ?> value="rgba-green-slight">Slight green</option>
     <option <?php if($sl['car_mask'] == 'rgba-yellow-light') { echo 'selected="selected"'; } ?> value="rgba-yellow-light">Light yellow</option>
     <option <?php if($sl['car_mask'] == 'rgba-yellow-strong') { echo 'selected="selected"'; } ?> value="rgba-yellow-strong">Dark yellow</option>
     <option <?php if($sl['car_mask'] == 'rgba-yellow-slight') { echo 'selected="selected"'; } ?> value="rgba-yellow-slight">Slight yellow</option>
     <option <?php if($sl['car_mask'] == 'rgba-orange-light') { echo 'selected="selected"'; } ?> value="rgba-orange-light">Light orange</option>
     <option <?php if($sl['car_mask'] == 'rgba-orange-strong') { echo 'selected="selected"'; } ?> value="rgba-orange-strong">Dark orange</option>
     <option <?php if($sl['car_mask'] == 'rgba-orange-slight') { echo 'selected="selected"'; } ?> value="rgba-orange-slight">Slight orange</option>
     <option <?php if($sl['car_mask'] == 'rgba-blue-gray-light') { echo 'selected="selected"'; } ?> value="rgba-blue-gray-light">Light blue-gray</option>
     <option <?php if($sl['car_mask'] == 'rgba-blue-gray-strong') { echo 'selected="selected"'; } ?> value="rgba-blue-gray-strong">Dark blue-gray</option>
     <option <?php if($sl['car_mask'] == 'rgba-blue-gray-slight') { echo 'selected="selected"'; } ?> value="rgba-blue-gray-slight">Slight blue-gray</option>
     <option <?php if($sl['car_mask'] == 'rgba-stylish-light') { echo 'selected="selected"'; } ?> value="rgba-stylish-light">Light stylish</option>
     <option <?php if($sl['car_mask'] == 'rgba-stylish-strong') { echo 'selected="selected"'; } ?> value="rgba-stylish-strong">Dark stylish</option>
     <option <?php if($sl['car_mask'] == 'rgba-stylish-slight') { echo 'selected="selected"'; } ?> value="rgba-stylish-slight">Slight stylish</option>                    
     </select>
     
     
     </div>
     </div>          
     </div>
     <?php
     $c++;
}
?>

<div class="card not-sortable" id="not-sortable">
<div class="card-header" role="tab" id="">
<a class="collapsed" data-toggle="collapse" href="#collapse<?php echo $c ?>" aria-expanded="false" aria-controls="collapse<?php echo $c ?>">
<h5 class="mb-0">New Slide<i class="fa fa-angle-down rotate-icon"></i></h5></a>
</div>
<div id="collapse<?php echo $c ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?php echo $c ?>" data-parent="#slidesEx">
<p>&nbsp;</p>
<div class="file-field">
<div class="btn btn-primary btn-sm float-left">
<span>Choose file</span>
<input type="file" name="car_image" id="car_image" />
</div>
<div class="file-path-wrapper">
<input class="file-path validate" type="text" placeholder="Upload your file" readonly="readonly" />
</div>
</div>

<div class="card-body">
<b>Visibility</b>
<div class="switch">
<label>
Off
<input id="car_status" type="checkbox" />
<span class="lever"></span> On
</label>
</div>

<div class="md-form">
<input type="text" name="car_caption" id="car_caption" class="form-control" />
<label for="car_caption">Slide Caption</label>
</div>

<label class="mb-1">Caption Size</label>
<select name="car_caption_size" id="car_caption_size" class="mdb-select md-form mt-1">
<option value="" disabled selected>Select a Size</option>
<option value="h5-responsive" class="h5-responsive">Extra Small</option>
<option value="h4-responsive" class="h4-responsive">Small</option>
<option value="h3-responsive" class="h3-responsive">Medium</option>
<option value="h2-responsive" class="h2-responsive">Large</option>
<option value="h1-responsive" class="h1-responsive">Extra Large</option>
</select>

<div class="md-form">
<input type="text" name="car_text" id="car_text" class="form-control" />
<label for="car_text">Slide Text</label>
<small class="form-text text-muted mb-2">Additional text below the Caption.</small>
</div>

<div class="md-form">
<input type="url" name="car_url" id="car_url" class="form-control" />
<label for="car_url">Slide URL</label>
<small class="form-text text-muted mt-1 mb-2">URL that opens when the slide it clicked.</small>
</div>

<label class="mb-1">Image Mask or Overlay</label>
<select name="car_mask" id="car_mask" class="mdb-select md-form mt-1">
<option value="" disabled selected>Select an Option</option>
<option value="">None</option>     
<optgroup label="Patterns"></optgroup>
<option value="pattern-1">Overlay 1</option>
<option value="pattern-2">Overlay 2</option>
<option value="pattern-3">Overlay 3</option>
<option value="pattern-4">Overlay 4</option>
<option value="pattern-5">Overlay 5</option>
<option value="pattern-6">Overlay 6</option>
<option value="pattern-7">Overlay 7</option>
<option value="pattern-8">Overlay 8</option>                               
<optgroup label="Masks"></optgroup>
<option value="rgba-blue-light">Light Blue</option>
<option value="rgba-blue-strong">Dark Blue</option>
<option value="rgba-blue-slight">Slight Blue</option>
<option value="rgba-red-light">Light red</option>
<option value="rgba-red-strong">Dark red</option>
<option value="rgba-red-slight">Slight red</option>               
<option value="rgba-pink-light">Light pink</option>
<option value="rgba-pink-strong">Dark pink</option>
<option value="rgba-pink-slight">Slight pink</option>
<option value="rgba-purple-light">Light purple</option>
<option value="rgba-purple-strong">Dark purple</option>
<option value="rgba-purple-slight">Slight purple</option>
<option value="rgba-indigo-light">Light indigo</option>
<option value="rgba-indigo-strong">Dark indigo</option>
<option value="rgba-indigo-slight">Slight indigo</option>
<option value="rgba-cyan-light">Light cyan</option>
<option value="rgba-cyan-strong">Dark cyan</option>
<option value="rgba-cyan-slight">Slight cyan</option>
<option value="rgba-green-light">Light green</option>
<option value="rgba-green-strong">Dark green</option>
<option value="rgba-green-slight">Slight green</option>
<option value="rgba-yellow-light">Light yellow</option>
<option value="rgba-yellow-strong">Dark yellow</option>
<option value="rgba-yellow-slight">Slight yellow</option>
<option value="rgba-orange-light">Light orange</option>
<option value="rgba-orange-strong">Dark orange</option>
<option value="rgba-orange-slight">Slight orange</option>
<option value="rgba-blue-gray-light">Light blue-gray</option>
<option value="rgba-blue-gray-strong">Dark blue-gray</option>
<option value="rgba-blue-gray-slight">Slight blue-gray</option>
<option value="rgba-stylish-light">Light stylish</option>
<option value="rgba-stylish-strong">Dark stylish</option>
<option value="rgba-stylish-slight">Slight stylish</option>                    
</select>
<button type="button" class="btn btn-success" id="addButton" onclick="addSlide()"><i class="fa fa-plus"></i> Add</button>
<button type="button" class="btn btn-unique" id="refreshButton" style="display: none" onclick="window.location.reload()">Refresh</button><br />
<div id="addResult" style="display: none"></div>
</div>
</div>          
</div>

</div>

</div>
</div>
</div>
<script>
function changeValue(data)
{
     switch(data) {
          case 'controls':
               if($('#controls').prop("checked") == true) {
                    $('#controlsl').show();
                    $('#controlsr').show();
                    var field = 'controls';
                    var value = 1;
               }
               if($('#controls').prop("checked") == false) {
                    $('#controlsl').hide();
                    $('#controlsr').hide();
                    var field = 'controls';
                    var value = 0;                    
               }
               break;
          case 'indicatorss':
               if($('#indicatorss').prop("checked") == true) {
                    $('#indicators').show();
                    var field = 'indicators';
                    var value = 1;                    
               }
               if($('#indicatorss').prop("checked") == false) {
                    $('#indicators').hide();
                    var field = 'indicators';
                    var value = 0;
               }
               break;
          case 'animations':
               if($('#animations').prop("checked") == true) {
                    $('.slideimage').addClass('animated');
                    var field = 'animations';
                    var value = 1;                    
               }
               if($('#animations').prop("checked") == false) {
                    $('.slideimage').removeClass('animated');
                    var field = 'animations';
                    var value = 0;                    
               }
               break;
          case 'hoverpause':
               if($('#hoverpause').prop("checked") == true) {
                    $('#carousel-editor').attr('data-pause', 'hover');
                    $('#carousel-editor').data('pause', 'hover');
                    var field = 'hover_pause';
                    var value = 'hover';                    
               }
               if($('#hoverpause').prop("checked") == false) {
                    $('#carousel-editor').attr('data-pause', 'false');
                    $('#carousel-editor').data('pause', 'false');
                    var field = 'hover_pause';
                    var value = 'false';  
               }
               break;
          case 'wrapping':
               if($('#wrapping').prop("checked") == true) {
                    $('#carousel-editor').attr('data-wrap', 'true');
                    $('#carousel-editor').data('wrap', 'true');
                    var field = 'wrapping';
                    var value = '1';                                           
               }
               if($('#wrapping').prop("checked") == false) {
                    $('#carousel-editor').attr('data-wrap', 'false');
                    $('#carousel-editor').data('wrap', 'false');
                    var field = 'wrapping';
                    var value = '0'; 
               }
               break;
          case 'interval':
               $('#carousel-editor').attr('data-interval', $('#interval').val() + '000');
               $('#carousel-editor').data('interval', $('#interval').val() + '000');
               var field = 'interval';
               var value = $('#interval').val();
               break;                
          default:
               break;
     }
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/carousel/ajax.php',
          type: 'POST',
          data: {
               'update_carousel': 1,
               'field': field,
               'value': value
          },
          success: function(data) {
               $('#carousels').html(data);
               $('.carousel').carousel();
          }
     })
}
function deleteSlide(slide)
{
     if(confirm("Are you SURE?  This cannot be undone!")) {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/carousel/ajax.php',
               type: 'POST',
               data: {
                    'delete_slide': 1,
                    'c_id': slide
               },
               success: function(data) {
                    window.location.reload();
               }
          })
     }
}
$(function() {
     $(".dragarea").sortable({
          cancel: ".not-sortable",
          axis: 'y',
          update: function (event, ui) {
               var data = $(this).sortable('serialize');
               $.ajax({
                    data: data,
                    type: 'POST',
                    url: '<?php echo $gbl['site_url'] ?>/plg/carousel/ajax.php',
                    success: function(data) {
                         window.location.reload();
                    }
               });
          }
     });
     $(".dragarea").disableSelection();
});
function changeSlide(field,slide)
{
     var input = field +'-'+ slide;
     var c_id = slide;
     switch(field) {
          case 'car_status':
               if($('#'+input).prop("checked") == false) {
                    $('#overlay-'+ slide).addClass('rgba-black-strong');
                    $('#otext-'+ slide).show();
                    var field = 'car_status';
                    var value = 0;
               }
               if($('#'+input).prop("checked") == true) {
                    $('#overlay-'+ slide).removeClass('rgba-black-strong');
                    $('#otext-'+ slide).hide();
                    var field = 'car_status';
                    var value = 1;
               }
               break;
          case 'car_caption':
               $('#ocaption-'+ slide).html($('#car_caption-'+ slide).val());
               var field = 'car_caption';
               var value = $('#car_caption-'+ slide).val();               
               break;
          case 'car_caption_size':
               $('#ocaption-' + slide).prop("class", "ocaption-"+ slide +" "+ $('#car_caption_size-'+ slide).val() +"");
               var field = 'car_caption_size';
               var value = $('#car_caption_size-'+ slide).val();               
               break;
          case 'car_url':
               var field = 'car_url';
               var value = $('#car_url-'+ slide).val();
               break;
          case 'car_mask':
               $('#overlay-' + slide).prop("class", "mask flex-center " + $('#car_mask-' + slide).val());
               var field = 'car_mask';
               var value = $('#car_mask-' + slide).val();
               break;
          case 'car_text':
               $('#otext-' + slide).html($('#car_text-'+ slide).val());
               var field = 'car_text';
               var value = $('#car_text-'+ slide).val();
               break;               
          default:
               break;
     }
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/carousel/ajax.php',
          type: 'POST',
          data: {
               'update_slide': 1,
               'c_id': c_id,
               'field': field,
               'value': value
          },
          success: function(data) {
               $('#carousels').html(data);
               $('.carousel').carousel();
          }
     })
}
function addSlide()
{
     $('#addButton').html('Please wait...<i class="fa fa-spinner"></i>');
     $('#addButton').prop("disabled",true);
     $('#refreshButton').hide();
     $('#addResult').hide();     
     var formData = new FormData();
     formData.append('car_image', $('input[name=car_image]')[0].files[0]);
     formData.append('car_caption', $('#car_caption').val());
     formData.append('car_text', $('#car_text').val());
     formData.append('car_status', $('input[name="car_status"]:checked').val());
     formData.append('car_caption_size', $('#car_caption_size').val());
     formData.append('car_url', $('#car_url').val());
     formData.append('car_mask', $('#car_mask').val());
     formData.append('new_slide', '1');
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/carousel/ajax.php',
          type: 'POST',
          processData: false,
          contentType: false,
          data: formData,
          success: function(data) {
               $('#addButton').hide()
               $('#addResult').show();
               $('#refreshButton').show();               
               $('#addResult').html(data);
          }          
     })     
}
$(function() {
     $('.mdb_upload').mdb_upload();
});
</script>