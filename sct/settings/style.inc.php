<?php
$tm = $db->query("SELECT theme_name, theme_folder FROM $_SESSION[prefix]_themes WHERE theme_folder = '". $gbl['theme'] ."'");
$sthm = $tm->fetch(PDO::FETCH_ASSOC);
?>
<script>
function loadTheme(theme)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/js/ajax_settings.php',
          type: 'POST',
          data: {
               'theme': theme
          },
          success: function(data) {
               document.getElementById('themeres').innerHTML = data;
          }
     });      
}
</script>
<script>
$('#styletabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
</script>
<div class="col-xs-12">
<div class="well well-sm">
<h4>Style Settings</h4>
<p class="help-block">You can change SOME of the theme options below.  To add or edit themes, use the Theme Editor.</p>
</div>
</div>

<ul class="nav nav-tabs" id="styletabs" role="tablist">
<li role="presentation"><a href="#theme" aria-controls="settings" role="tab" data-toggle="tab">Site Theme</a></li>
<li role="presentation"><a href="#files" aria-controls="settings" role="tab" data-toggle="tab">Theme Files</a></li>
<li role="presentation"><a href="#grid" aria-controls="settings" role="tab" data-toggle="tab">Header Grid</a></li>
<li role="presentation"><a href="#general" aria-controls="settings" role="tab" data-toggle="tab">General Options</a></li>
<li role="presentation"><a href="#colors" aria-controls="settings" role="tab" data-toggle="tab">Feature Colors</a></li>
<li role="presentation"><a href="#fonts" aria-controls="settings" role="tab" data-toggle="tab">Site Fonts</a></li>
<li role="presentation"><a href="#layouts" aria-controls="settings" role="tab" data-toggle="tab">Other Layout Options</a></li>
</ul>

<p>&nbsp;</p>

<div class="tab-content">
     
     <div role="tabpanel" class="tab-pane" id="theme">
     <div class="col-xs-4">
     <div class="well well-sm">
     <h4>Site Theme</h4>
     <p class="help-block">Select a Theme from the list.  Your currently active theme is already selected.  You may also change some of the style settings of any theme.  For advanced changes (layout, functionality, etc.) you need to speak to the Administrator.</p>
     <select name="activetheme" id="activetheme" onchange="submitForm('theme', 9, this.value);">
     <?php
     $sql = $db->query("SELECT * FROM $_SESSION[prefix]_themes ORDER BY t_id ASC");
     while($thm = $sql->fetch(PDO::FETCH_ASSOC)) {
          if($thm['theme_name'] == $sthm['theme_name']) {
               echo '<option value="'. $thm['theme_folder'] .'" selected="selected">'. $thm['theme_name'] .'</option>';
          } else {
               echo '<option value="'. $thm['theme_folder'] .'">'. $thm['theme_name'] .'</option>';
          }
     }
     ?>
     </select><br /><br />
     <button type="button" class="btn btn-warning btn-block" onclick="reloadMe(1)">Reload Page</button>
     </div>
     </div>
     </div>

     <div role="tabpanel" class="tab-pane" id="files">
     <div class="col-xs-8">
     <div class="well well-sm">
     <p class="help-block">You can upload and manage images uses in the style selected in this section.  When you modify images here, they will also be modified in the list of available images in the style options.</p>
     <div id="fileman">
     <iframe src="<?php echo $gbl['site_url'] ?>/js/pgrfilemanager/PGRFileManager.php?mode=style" frameborder="0" width="100%" height="450" style="padding:0;margin-top:8px;border-radius:4px;border: 1px solid #6B6B6B;box-shadow:0 0 4px #6B6B6B;"></iframe>
     </div>
     </div>
     </div>
     </div>

     <?php
     $tsql = $db->query("SELECT * FROM $_SESSION[prefix]_style WHERE style_name = '$sthm[theme_folder]'");
     $thmr = $tsql->fetch(PDO::FETCH_ASSOC);
     ?>

     <div role="tabpanel" class="tab-pane" id="grid">     
     <div class="col-xs-12">
     <div class="well well-sm">
     <p class="help-block">You can change the width of each section of the header area to meet your needs.  Keep in mind that the final total width MUST equal 12 or your header will look very strange.</p>
     <div class="row">
     <div class="col-xs-4">
     <h5>Left Grid Area (site logo)</h5>
     <select name="leftgrid" id="leftgrid" onchange="submitForm('grid1width',9,this.value)">
     <?php
     for($i=0;$i<=12;$i++) {
          if($i == $thmr['grid1width']) {
               echo '<option selected="selected" value="'. $i .'">Width '. $i .'</option>';
          } else {
               echo '<option value="'. $i .'">Width '. $i .'</option>';
          }
     }
     ?>
     </select>
     <p class="help-block">Remember to modify the other header section widths so that they final number is equal to 12</p>
     </div>
     
     <div class="col-xs-4">
     <h5>Center Grid Area (site slogan)</h5>
     <select name="centergrid" id="centergrid" onchange="submitForm('grid2width',9,this.value)">
     <?php
     for($i=0;$i<=12;$i++) {
          if($i == $thmr['grid2width']) {
               echo '<option selected="selected" value="'. $i .'">Width '. $i .'</option>';
          } else {
               echo '<option value="'. $i .'">Width '. $i .'</option>';
          }
     }
     ?>
     </select>
     <p class="help-block">Remember to modify the other header section widths so that they final number is equal to 12</p>
     </div>
     
     <div class="col-xs-4">
     <h5>Right Grid Area (social)</h5>
     <select name="rightgrid" id="rightgrid" onchange="submitForm('grid3width',9,this.value)">
     <?php
     for($i=0;$i<=12;$i++) {
          if($i == $thmr['grid3width']) {
               echo '<option selected="selected" value="'. $i .'">Width '. $i .'</option>';
          } else {
               echo '<option value="'. $i .'">Width '. $i .'</option>';
          }
     }
     ?>
     </select>
     <p class="help-block">Remember to modify the other header section widths so that they final number is equal to 12</p>
     </div>
     </div>
     </div>
     </div>
     
     <div class="col-xs-6">
     <div class="well well-sm">
     <h4>Heading Text or Logo</h4>
     <p class="help-block">You can choose to use the selected logo image or simply enter text to take the place of the logo.</p>
     <input type="radio" name="logotext" id="logotext" required="required" value="1" <?php if($thmr['logotext'] == 1) { echo 'checked="checked"'; } ?> onchange="submitForm('logotext', 9, 1)" /> Logo Image<br />
     <input type="radio" name="logotext" id="logotext" value="3" <?php if($thmr['logotext'] == 3) { echo 'checked="checked"'; } ?> onchange="submitForm('logotext', 9, 3)" /> Site Name Text<br />
     <input type="radio" name="logotext" id="logotext" value="2" <?php if($thmr['logotext'] == 2) { echo 'checked="checked"'; } ?> onchange="submitForm('logotext', 9, 2)" /> Custom Text<br />
     <input type="text" name="headingtext" id="headingtext" onchange="submitForm('headingtext', 9, this.value)" value="<?php echo $thmr['headingtext'] ?>" class="form-control" />
     </div>
     </div>
     
     <div class="col-xs-6">
     <div class="well well-sm">
     <h4>Heading Text Style Options</h4>
     <p class="help-block">You can style the heading text with one of these options.</p>
     <select name="htextstyle" id="htextstyle" onchange="submitForm('htextstyle',9,this.value)">
     <option <?php if($thmr['fonteffect'] == '') { echo 'selected="selected"'; } ?> value="">Default (no style)</option>
     <option <?php if($thmr['fonteffect'] == 'inset-text') { echo 'selected="selected"'; } ?> value="inset-text">Inset Style 1</option>
     <option <?php if($thmr['fonteffect'] == 'inset2') { echo 'selected="selected"'; } ?> value="inset2">Inset Style 2</option>
     <option <?php if($thmr['fonteffect'] == '3dtext') { echo 'selected="selected"'; } ?> value="3dtext">3D Text</option>
     <option <?php if($thmr['fonteffect'] == 'embossed') { echo 'selected="selected"'; } ?> value="embossed">Embossed</option>
     <option <?php if($thmr['fonteffect'] == 'gradient') { echo 'selected="selected"'; } ?> value="gradient">Gradient</option>
     </select>
     </div>
     </div>
     
     <div class="col-xs-6 col-xs-offset-6">
     <div class="well well-sm">
     <h4>Heading Text Font Size</h4>
     <p class="help-block">Setting the font size of the heading text will separate its font size from the rest of the site.</p>
     <input type="text" name="headingtextfontsize" id="headingtextfontsize" onchange="submitForm('headingtextfontsize', 9, this.value)" value="<?php echo $thmr['headingtextfontsize'] ?>" class="form-control" />
     </div>
     </div>      
     </div>

     <div role="tabpanel" class="tab-pane" id="general">
     <div class="col-xs-3">
     <div class="well well-sm">
     <b>Width Type</b><br />
     <input onchange="submitForm('widthtype', 9, this.value);" type="radio" name="widthtype" id="widthtype" value="container" <?php if($thmr['widthtype'] == 'container') { echo 'checked="checked"';} ?> /> Fixed Width (set width below)<br />
     <input onchange="submitForm('widthtype', 9, this.value);" type="radio" name="widthtype" id="widthtype" value="container-fluid" <?php if($thmr['widthtype'] == 'container-fluid') { echo 'checked="checked"';} ?> /> Fluid Width<br /><br />
     
     <b>Site Width (if Fixed)</b><br />
     <input onchange="submitForm('sitewidth', 9, this.value);" type="number" min="100" max="1500" name="sitewidth" id="sitewidth" value="<?php echo $thmr['sitewidth'] ?>" class="form-control" disabled="disabled" />
     <p class="help-block">This option has been disabled and will be removed on a later update.  A "fixed width" is determined by screen size and device instead.</p>
     </div>
     </div>
     
     <div class="col-xs-3">
     <div class="well well-sm">     
     <b>Carousel Height</b><br />
     <input onchange="submitForm('carouselheight', 9, this.value);" type="number" min="100" max="1500" name="carouselheight" id="carouselheight" value="<?php echo $thmr['carouselheight'] ?>" class="form-control" /><br />
     <b>Carousel Width</b><br />
     <input onchange="submitForm('carouselwidth', 9, this.value);" type="number" min="100" max="1500" name="carouselwidth" id="carouselwidth" value="<?php echo $thmr['carouselwidth'] ?>" class="form-control" />     
     <p class="help-block">The Carousel width should always be wider than the height.  Don't make it too wide or you'll have to produce specially-shot images to fill it.  Don't make it too high or your users won't see page content.  Default size is 800 W by 450 H.</p>
     </div>
     </div>
     
     <div class="col-xs-3">
     <div class="well well-sm">     
     <b>Site Background Color</b><br />
     <input onchange="submitForm('backgroundcolor', 9, this.value);" type="color" name="backgroundcolor" id="backgroundcolor" value="<?php echo $thmr['backgroundcolor'] ?>" class="form-control" /><br />
     <b>Background Overlay Image</b><br />
     <input onchange="submitForm('backgroundimage', 9, this.value);" type="text" name="backgroundimage" id="backgroundimage" value="<?php echo $thmr['backgroundimage'] ?>" class="form-control" />
     <p class="help-block">You will need to upload this image to the themes/<?php echo $thmr['style_name'] ?>/images folder using an FTP client.</p>
     </div>
     </div>
     
     <div class="col-xs-3">
     <div class="well well-sm">
     <b>Menu Bar Location</b><br />
     <input onchange="submitForm('menulocation', 9, this.value);" type="radio" name="menulocation" id="menulocation" value="1" <?php if($thmr['menu_location'] == 1) { echo 'checked="checked"'; } ?> /> Top of Page (fixed)<br />
     <input onchange="submitForm('menulocation', 9, this.value);" type="radio" name="menulocation" id="menulocation" value="2" <?php if($thmr['menu_location'] == 2) { echo 'checked="checked"'; } ?> /> Below Header
     </div>
     </div>
     </div>

     <div role="tabpanel" class="tab-pane" id="colors">
     <div class="col-xs-3">
     <div class="well well-sm">
     <b>Header Color</b>
     <input onchange="submitForm('headbackgroundcolor', 9, this.value);" type="color" name="headbackgroundcolor" id="headbackgroundcolor" value="<?php echo $thmr['headbackgroundcolor'] ?>" class="form-control" /><br />
     <b>Header Image</b><br />
     <input onchange="submitForm('headbackgroundimage', 9, this.value);" type="text" name="headbackgroundimage" id="headbackgroundimage" value="<?php echo $thmr['headbackgroundimage'] ?>" class="form-control" />     
     <p class="help-block">You will need to upload this image to the themes/<?php echo $thmr['style_name'] ?>/images folder using an FTP client.</p> 
     </div>
     </div>
     <div class="col-xs-3">
     <div class="well well-sm">     
     <b>Row/Block Heading Color</b><br />
     <input onchange="submitForm('rowheadcolor', 9, this.value);" type="color" name="rowheadcolor" id="rowheadcolor" value="<?php echo $thmr['rowheadcolor'] ?>" class="form-control" /><br />
     <b>Row/Block Heading Overlay Image</b><br />
     <input onchange="submitForm('rowheadimage', 9, this.value);" type="text" name="rowheadimage" id="rowheadimage" value="<?php echo $thmr['rowheadimage'] ?>" class="form-control" />     
     <p class="help-block">You will need to upload this image to the themes/<?php echo $thmr['style_name'] ?>/images folder using an FTP client.</p>     
     </div>
     </div>
     <div class="col-xs-3">
     <div class="well well-sm">       
     <b>Footer Color</b><br />
     <input onchange="submitForm('footercolor', 9, this.value);" type="color" name="footercolor" id="footercolor" value="<?php echo $thmr['footercolor'] ?>" class="form-control" /><br />
     <b>Footer Overlay Image</b><br />
     <input onchange="submitForm('footerimage', 9, this.value);" type="text" name="footerimage" id="footerimage" value="<?php echo $thmr['footerimage'] ?>" class="form-control" />     
     <p class="help-block">You will need to upload this image to the themes/<?php echo $thmr['style_name'] ?>/images folder using an FTP client.</p>  
     </div>
     </div>
     </div>



     <div role="tabpanel" class="tab-pane" id="fonts">
     <div class="col-xs-6">
     <div class="well well-sm">
     
     <b>Google Fonts CSS Import String</b><br />
     <input onchange="submitForm('googlefontimport', 9, this.value);" type="text" name="googlefontimport" id="googlefontimport" value="<?php echo $thmr['googlefontimport'] ?>" class="form-control" />
     <p class="help-block">You can go to <a href="http://fonts.google.com" target="_blank">Google Fonts</a> and create a font library.  When finished, select the "Import" option, then copy and paste everything between the &lt;style&gt;&lt;/style&gt; tags into this field.  Doing this incorrectly could cause problems.</p>
     <div id="gfcontainer"></div>
     <div id="sink">
     <h1>HTML Ipsum Presents</h1>           
     <p><strong>Pellentesque habitant morbi tristique</strong> senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. <em>Aenean ultricies mi vitae est.</em> Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, <code>commodo vitae</code>, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. <a href="#">Donec non enim</a> in turpis pulvinar facilisis. Ut felis.</p>
     <h2>Header Level 2</h2>                
     <ol>
     <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
     <li>Aliquam tincidunt mauris eu risus.</li>
     </ol>
     <blockquote><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus magna. Cras in mi at felis aliquet congue. Ut a est eget ligula molestie gravida. Curabitur massa. Donec eleifend, libero at sagittis mollis, tellus est malesuada tellus, at luctus turpis elit sit amet quam. Vivamus pretium ornare est.</p></blockquote>     
     <h3>Header Level 3</h3>
     <ul>
     <li>Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</li>
     <li>Aliquam tincidunt mauris eu risus.</li>
     </ul>
     </div>     

     </div>
     </div>
     
     
     
     
     <!--<div class="col-xs-3">
     <div class="well well-sm">     
     <b>Default Site Font</b><br />
     <input onchange="submitForm('defaultfont', 9, this.value);" type="text" name="defaultfont" id="defaultfont" value="<?php echo $thmr['defaultfont'] ?>" class="form-control" />
     <p class="help-block">From the same Google Fonts screen copy and paste the correct "font-family:" rule.  You only need to paste the font itself (everything after the ':'), and only ONE font family if you created more than one.</p>
     </div>
     </div>-->
     
     
     <div class="col-xs-3">
     <div class="well well-sm">     
     <b>Heading 1 Font</b><br />
     <input onchange="submitForm('h1font', 9, this.value);" type="text" name="h1font" id="h1font" value="<?php echo $thmr['h1font'] ?>" class="form-control" />
     <p class="help-block">Enter the full style class for Heading 1.  The property MUST be declared as follows: font-style, font-variant, font-weight, font-size/line-height, font-family;.  If you aren't sure how to do this, leave it blank and the global theme will manage this.</p>
     <b>Heading 2 Font</b><br />
     <input onchange="submitForm('h2font', 9, this.value);" type="text" name="h2font" id="h2font" value="<?php echo $thmr['h2font'] ?>" class="form-control" />
     <p class="help-block">Enter the full style class for Heading 2.  The property MUST be declared as follows: font-style, font-variant, font-weight, font-size/line-height, font-family;.  If you aren't sure how to do this, leave it blank and the global theme will manage this.</p>     
     <b>Heading 3 Font</b><br />
     <input onchange="submitForm('h3font', 9, this.value);" type="text" name="h3font" id="h3font" value="<?php echo $thmr['h3font'] ?>" class="form-control" />
     <p class="help-block">Enter the full style class for Heading 3.  The property MUST be declared as follows: font-style, font-variant, font-weight, font-size/line-height, font-family;.  If you aren't sure how to do this, leave it blank and the global theme will manage this.</p>
     <b>Heading 4 Font</b><br />
     <input onchange="submitForm('h4font', 9, this.value);" type="text" name="h4font" id="h4font" value="<?php echo $thmr['h4font'] ?>" class="form-control" />
     <p class="help-block">Enter the full style class for Heading 4.  The property MUST be declared as follows: font-style, font-variant, font-weight, font-size/line-height, font-family;.  If you aren't sure how to do this, leave it blank and the global theme will manage this.</p>     
     </div>
     </div>
     <div class="col-xs-3">
     <div class="well well-sm">
     <b>Global Font Color</b><br />
     <input onchange="submitForm('primaryfontcolor', 9, this.value);" type="color" name="primaryfontcolor" id="primaryfontcolor" value="<?php echo $thmr['primaryfontcolor'] ?>" class="form-control" />     
     <p class="help-block">This color will affect all fonts unless you specify differently in your content, OR as set in the following options.</p>
     <b>Header/Site Title Font Color</b><br />
     <input onchange="submitForm('headingfontcolor', 9, this.value);" type="color" name="headingfontcolor" id="headingfontcolor" value="<?php echo $thmr['headingfontcolor'] ?>" class="form-control" /><br />     
     <b>Slogan Font Color</b><br />
     <input onchange="submitForm('sloganfontcolor', 9, this.value);" type="color" name="sloganfontcolor" id="sloganfontcolor" value="<?php echo $thmr['sloganfontcolor'] ?>" class="form-control" /><br /> 
     <b>Row/Block Head Font Color</b><br />
     <input onchange="submitForm('rowheadfontcolor', 9, this.value);" type="color" name="rowheadfontcolor" id="rowheadfontcolor" value="<?php echo $thmr['rowheadfontcolor'] ?>" class="form-control" /><br /> 
     <b>Footer Area Font Color</b><br />
     <input onchange="submitForm('footerfontcolor', 9, this.value);" type="color" name="footerfontcolor" id="footerfontcolor" value="<?php echo $thmr['footerfontcolor'] ?>" class="form-control" /><br />
     <b>Site Menu Font Color</b><br />
     <input onchange="submitForm('menufontcolor', 9, this.value);" type="color" name="menufontcolor" id="menufontcolor" value="<?php echo $thmr['menufontcolor'] ?>" class="form-control" />     
     </div>
     </div>
     </div>

     <div role="tabpanel" class="tab-pane" id="layouts">
     <div class="col-xs-3">
     <div class="well well-sm">
     <div class="help-block">Header/Footer Layout</div>
     <b>Header Height</b><br />
     <input onchange="submitForm('headerheight', 9, this.value);" type="text" name="headerheight" id="headerheight" value="<?php echo $thmr['headerheight'] ?>" class="form-control" />     
     <b>Footer Height</b><br />
     <input onchange="submitForm('footerheight', 9, this.value);" type="text" name="footerheight" id="footerheight" value="<?php echo $thmr['footerheight'] ?>" class="form-control" />
     <p class="help-block">Both the header and footer height is the MINIMUM height.  Don't set this too high!  The header should be about 1/4 the height of the footer or less.</p>     
     </div>
     </div>
     </div>

</div>

<script>
var FragBuilder = (function() {
    var applyStyles = function(element, style_object) {
        for (var prop in style_object) {
            element.style[prop] = style_object[prop];
        }
    };
    var generateFragmentFromJSON = function(json) {
        var tree = document.createDocumentFragment();
        json.forEach(function(obj) {
            if (!('tagName' in obj) && 'textContent' in obj) {
                tree.appendChild(document.createTextNode(obj['textContent']));
            } else if ('tagName' in obj) {
                var el = document.createElement(obj.tagName);
                delete obj.tagName;
                for (part in obj) {
                    var val = obj[part];
                    switch (part) {
                    case ('textContent'):
                        el.appendChild(document.createTextNode(val));
                        break;
                    case ('style'):
                        applyStyles(el, val);
                        break;
                    case ('childNodes'):
                        el.appendChild(generateFragmentFromJSON(val));
                        break;
                    default:
                        if (part in el) {
                            el[part] = val;
                        }
                        break;
                    }
                }
                tree.appendChild(el);
            } else {
                throw "Error: Malformed JSON Fragment";
            }
        });
        return tree;
    };
    var generateFragmentFromString = function(HTMLstring) {
        var div = document.createElement("div"),
            tree = document.createDocumentFragment();
        div.innerHTML = HTMLstring;
        while (div.hasChildNodes()) {
            tree.appendChild(div.firstChild);
        }
        return tree;
    };
    return function(fragment) {
        if (typeof fragment === 'string') {
            return generateFragmentFromString(fragment);
        } else {
            return generateFragmentFromJSON(fragment);
        }
    };
}());

function jsonp(url) {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = url;
    document.getElementsByTagName('body')[0].appendChild(script);
}

function replacestyle(url) {
    if (!document.getElementById('style_tag')) {
        var style_tag = document.createElement('link');
        style_tag.rel = 'stylesheet';
        style_tag.id = 'style_tag';
        style_tag.type = 'text/css';
        document.getElementsByTagName('head')[0].appendChild(style_tag);
        replacestyle(url);
    }
    document.getElementById('style_tag').href = url;
}

function loadFonts(json) {
    var select_frag = [
        {
        'tagName': 'select',
        'id': 'font-selection',
        'childNodes': [
            {
            'tagName': 'option',
            'value': 'default',
            'textContent': 'Default'}
        ]}
    ];
    json['items'].forEach(function(item) {
        var family_name = item.family,
            value = family_name.replace(/ /g, '+');

        if (item.variants.length > 0) {
            item.variants.forEach(function(variant) {
                value += ':' + variant;
            });
        }

        select_frag[0].childNodes.push({
            'tagName': 'option',
            'value': value,
            'textContent': family_name
        });
    });

    document.getElementById('gfcontainer').appendChild(FragBuilder(select_frag));
    document.getElementById('font-selection').onchange = function(e) {
        var font = this.options[this.selectedIndex].value,
            name = this.options[this.selectedIndex].textContent;
        if (font === 'default') {
            document.getElementById('sink').style.fontFamily = 'inherit';
        } else {
            document.getElementById('sink').style.fontFamily = name;
            replacestyle('https://fonts.googleapis.com/css?family=' + font);
        }
    };
}

jsonp("https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyA2-dSN4DUI9HdUsGDx_GqAHgFwJPdUgKA&sort=trending&callback=loadFonts")
</script>