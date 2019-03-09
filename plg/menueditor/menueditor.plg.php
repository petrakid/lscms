<?php
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}

?>

<h4 class="card-title">Site Menu Editor</h4>
<p class="card-text">The Site Menu is the most important feature of your site.  Without it visitors couldn't get from page to page.  The following features allow
you to manipulate the structure of your site's menu along with some other features.  Keep this in mind: When you create a menu, an editable page is created along 
with it.  It's up to you to add content to your pages.</p>

<div class="container-fluid">
<div class="row">
<div class="col-12">
<div class="card-deck sortableparents" draggable="true">
<?php
$c = 1;
$parents = $db->query("SELECT p_id, menu_name, menu_order, menu_status, menu_link FROM tbl_pages WHERE menu_status != 9 AND parent_id = 0 ORDER BY menu_order");
while($par = $parents->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <div id="item-<?php echo $par['p_id'] ?>" class="card mb-4 mr-1">
     <div class="card-header h5"><i class="fa fa-pencil-alt blue-text" onclick="editMenu(<?php echo $par['p_id'] ?>)" style="cursor: pointer;"></i> <?php echo stripslashes($par['menu_name']) ?></div>
     <div class="card-body">
     
     <?php
     $children = $db->query("SELECT p_id, menu_name, menu_order, menu_status, parent_id FROM tbl_pages WHERE menu_status != 9 AND parent_id = $par[p_id] ORDER BY menu_order");
     if($children->rowCount() > 0) {
          ?>
          <ul class="list-group sortablechildren">
          
          <?php
          $ch = 1;
          while($child = $children->fetch(PDO::FETCH_ASSOC)) {
               if($child['menu_status'] == 0) {
                    ?>
                    <li id="item-<?php echo $child['p_id'] ?>" class="list-group-item list-group-item-danger" style="margin-bottom: 2px;cursor: n-resize;"><i class="fa fa-pencil-alt blue-text" onclick="editMenu(<?php echo $child['p_id'] ?>)" style="cursor: pointer;"></i> <?php echo stripslashes($child['menu_name']) ?></li>
                                        
                    <?php
               } else {
                    ?>
                    <li id="item-<?php echo $child['p_id'] ?>" class="list-group-item list-group-item-success" style="margin-bottom: 2px;cursor: n-resize;"><i class="fa fa-pencil-alt gray-text" onclick="editMenu(<?php echo $child['p_id'] ?>)" style="cursor: pointer;"></i> <?php echo stripslashes($child['menu_name']) ?></li>
               
                    <?php
               }
               $ch++;
          }
          ?>
          <li class="list-group-item list-group-item-primary no-sort" style="cursor: pointer;" onclick="addMenu(<?php echo $par['p_id'] ?>)">New Menu Item</li>
          </ul>
          
          <?php
     } else {
          if($par['menu_link'] != 'home') {
               ?>
               <ul class="list-group sortablechildren">
               <li id="item-0" class="list-group-item list-group-item-primary no-sort" style="cursor: pointer" onclick="addMenu(<?php echo $par['p_id'] ?>)">New Menu Item</li>
               </ul>
                    
               <?php
          } else {
               echo 'You can\'t add child menus to the Home page!';
          }
     }
     ?>
     </div>
     </div>
     
     <?php
     $c++;
}
if($c < 12) {
     ?>

     <div id="item-0" class="card no-sort mb-4">
     <div class="card-header h5 bg-primary" style="cursor: pointer" onclick="addMenu(0)">New Menu Item</div>
     <div class="card-body">
     </div>
     </div>
     <?php
}
?>

</div>
</div>
</div>

<div class="row">
<div class="col-12">
<div class="card-deck">
<div class="card mb-4">
<div class="card-body">
<h5 class="card-title">Menu Features</h5>
<div id="editDiv">

</div>
</div>
</div>
<div class="card mb-4">
<div class="card-body">
<h5 class="card-title">Mega Menu Content</h5>
<p class="card-text">If you select the Mega Menu option, additional html may be edited here.  Again, it saves as you type.</p>
<div id="megaDiv">

</div>
</div>
</div>
</div>
</div>
</div>
</div>

<script>
function changeMenuLink(mname)
{
     var mlink;
     mlink = mname.toString();
     mlink = mlink.normalize('NFD');
     mlink = mlink.replace(/[\u0300-\u036f]/g,'');
     mlink = mlink.replace(/\s+/g,'-');
     mlink = mlink.toLowerCase();
     mlink = mlink.replace(/&/g,'-and-');
     mlink = mlink.replace(/[^a-z0-9\-]/g,'');
     mlink = mlink.replace(/-+/g,'-');
     mlink = mlink.replace(/^-*/,'');
     mlink = mlink.replace(/-*$/,'');
     $('#new_menu_link').val(mlink);
     $('#e_menu_link').val(mlink);                          
}
function makeLink(purl)
{
     var lval = $('#new_menu_link').val();
     var plink = purl + lval;
     $('#pageurl').html("<small class=\"form-text text-muted\">Page URL: <a href=\"" + plink + "\">" + plink + "</a></small>");
}
function checkMega(pid)
{
     if(pid == 0) {
          $('#megamenucheck').show();
     }
     if(pid > 0) {
          $('#megamenucheck').hide();          
     }
}
function addMenu(pid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/menueditor/ajax.php',
          type: 'POST',
          data: {
               'new_menu': 1,
               'parent_id': pid
          },
          success: function(data) {
               $('html, body').animate({
                    scrollTop: $("#editDiv").offset().top
               }, 1000);             
               $('#editDiv').html(data);
               $('.mdb-selecta').materialSelect();
               $('#new_mega_menu').on("click", function() {
                    if($('#new_mega_menu').prop('checked')) {
                         $.ajax({
                              url: '<?php echo $gbl['site_url'] ?>/plg/menueditor/ajax.php',
                              type: 'POST',
                              data: {
                                   'new_mega': 1
                              },
                              success: function(data) {
                                   $('#megaDiv').html(data);
                              }                              
                         })
                    } else {
                         $('#megaDiv').html("");
                    }
               })
          }
     })
}
function editMenu(pid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/menueditor/ajax.php',
          type: 'POST',
          data: {
               'edit_menu': 1,
               'pid': pid
          },
          success: function(data) {
               $('html, body').animate({
                    scrollTop: $("#editDiv").offset().top
               }, 1000);               
               $('#editDiv').html(data);
               $('.mdb-selecta').materialSelect();
               $('#e_mega_menu').on("click", function() {
                    if($('#e_mega_menu').prop('checked')) {
                         $.ajax({
                              url: '<?php echo $gbl['site_url'] ?>/plg/menueditor/ajax.php',
                              type: 'POST',
                              data: {
                                   'edit_mega': 1
                              },
                              success: function(data) {
                                   $('#megaDiv').html(data);
                              }                              
                         })
                    } else {
                         $('#megaDiv').html("");
                    }
               })               
          }
     })
}
function saveNew()
{
     if($('#new_mega_menu').prop('checked')) {
          mega = 1;
     } else {
          mega = 0;
     }
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/menueditor/ajax.php',
          type: 'POST',
          data: {
               'add_menu': 1,
               'menu_name': $('#new_menu_name').val(),
               'menu_link': $('#new_menu_link').val(),
               'page_title': $('#new_page_title').val(),
               'parent_id': $('select[name="new_parent_id"]').val(),
               'menu_url': $('#new_menu_url').val(),
               'menu_target': $('select[name="new_menu_target"]').val(),
               'mega_menu': mega,
               'mega_menu_html': '0'
          },
          success: function(data) {
               toastr.success('New Menu Created!  Refreshing...', "Success!");
               setTimeout(function() {
                    window.location.reload()
               }, 1800)
          }
     })
}
function saveMenu()
{
     if($('#e_mega_menu').prop('checked')) {
          mega = 1;
     } else {
          mega = 0;
     }
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/plg/menueditor/ajax.php',
          type: 'POST',
          data: {
               'update_menu': 1,
               'p_id': $('#p_id').val(),
               'menu_name': $('#e_menu_name').val(),
               'menu_link': $('#e_menu_link').val(),
               'page_title': $('#e_page_title').val(),
               'parent_id': $('select[name="e_parent_id"]').val(),
               'menu_url': $('#e_menu_url').val(),
               'menu_status': $('input[name=e_menu_status]:checked').val(),               
               'menu_target': $('select[name="e_menu_target"]').val(),
               'mega_menu': mega,
               'mega_menu_html': '0'
          },
          success: function(data) {
               toastr.success('Menu Updated!  Refreshing...', "Success!");
               setTimeout(function() {
                    window.location.reload()
               }, 1800)
          }
     })    
}
function deleteMenu(pid)
{
     if(confirm("Are you sure?")) {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/menueditor/ajax.php',
               type: 'POST',
               data: {
                    'delete_menu': 1,
                    'pid': pid
               },
               success: function(data) {
                    toastr.warning("The menu item has been removed.", "Done.");
                    setTimeout(function() {
                         window.location.reload()
                    }, 1500)
               }
          })
     }
}
$(function() {
     $('.sortableparents').sortable({
          revert: true,
          axis: 'x',
          cursor: 'w-resize',
          placeholder: 'ui-state-highlight',
          filter: ':not(.no-sort), :not(li)',
          cancel: '.no-sort, i',
          helper: 'clone',
          placeholder: "drop-area",
          forcePlaceholderSize: true,
          curserAt: { left: 20 },
          start: function(e, ui){
               $(ui.placeholder).hide(300);
          },
          change: function (e,ui){
               $(ui.placeholder).hide().show(300);
          },          
          update: function (event, ui) {
               var data = $(this).sortable('serialize');          
               $.ajax({
                    data: data,
                    type: 'POST',
                    url: '<?php echo $gbl['site_url'] ?>/plg/menueditor/ajax.php'
               });
          }          
     });
     $(".sortableparents").disableSelection();
})
$(function() {
     $('.sortablechildren').sortable({
          axis: 'y',
          placeholder: 'ui-state-highlight',        
          filter: ':not(.no-sort), :not(div)',
          cancel: '.no-sort',
          start: function(e, ui){
               $(ui.placeholder).hide(300);
          },
          change: function (e,ui){
               $(ui.placeholder).hide().show(300);
          },                    
          update: function (event, ui) {
               var data = $(this).sortable('serialize');          
               $.ajax({
                    data: data,
                    type: 'POST',
                    url: '<?php echo $gbl['site_url'] ?>/plg/menueditor/ajax.php'
               });
          }          
     });
     $(".sortablechildren").disableSelection();     
})
</script>