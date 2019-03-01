<?php
session_start();
if(!isset($_SESSION['isLoggedIn'])) {
     die;
}
include '../ld/db.inc.php';
include '../ld/globals.inc.php';
?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>

<base href="<?php echo $gbl['site_url'] ?>/" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo $gbl['meta_description'] ?>" />
<meta name="generator" content="Rev. Daniel Carlson" />
<meta name="author" content="Rev. Daniel Carlson" />
<title>Menus:<?php echo $gbl['site_name'] ?></title>
<link href="<?php echo $gbl['site_url'] ?>/" rel="canonical" />

<?php
$css = $db->query("SELECT * FROM tbl_cdns WHERE cdn_location <= 4 ORDER BY cdn_location, cdn_order");
while($cs = $css->fetch(PDO::FETCH_ASSOC)) {
     echo $cs['cdn_script'] ."\r\n";
}
?>

<!-- Custom Stylesheet -->
<link rel="stylesheet" href="../css/themes/<?php echo $gbl['theme'] ?>/themestyle.css" />
<link rel="stylesheet" href="../css/themes/style.php" />

<style>
ul.mainlist
{
    float: left;
    margin: 0 20px 0 0;
    width: 500px;
    list-style-type: none;
}
ul.mainlist li
{
    background: #fff;
    border: solid 1px #ccc;
    padding: 10px;
    list-style-type: none;
    margin-bottom: 5px;
    border-radius: 10px;
    cursor: move;
}
ul.disabledlist {
    float: left;
    margin: 0 20px 0 0;
    width: 500px;
    list-style-type: none;     
}
ul.disabledlist li {
    background: firebrick;
    color: white;
    border: solid 1px #ccc;
    padding: 10px;
    list-style-type: none;
    margin-bottom: 5px;
    border-radius: 10px;
    cursor: move;     
}
.addnew {
     background-color: floralwhite;
     border: solid 1px #ccc;
     padding: 10px;
     list-style-type: none;
     border-radius: 10px;
     width: 400px;
     cursor: move;
}
.adddisabled {
     background-color: firebrick;
     border: solid 1px #ccc;
     padding: 10px;
     list-style-type: none;
     border-radius: 10px;
     width: 400px;
     cursor: move;     
}
</style>
</head>

<body>
<div class="container">
<nav class="navbar navbar-inverse navbar-static-top">
<div class="container-fluid">
<div id="navbar" class="navbar-collapse collapse">
<p class="navbar-text">Menu Editor</p>
</div>
</div>
</nav>

<div class="row">
<div class="col12">
<div class="card">
<div class="card-body">
<small class="form-text text-muted mb-2">The menu structure is on the left.  Drag and drop menu items to where you want them. Blue-colored menu items are Parent menus and beige-colored menu items are Child menus.  Gray menu items are hidden/special and not part of the menu structure.
To ADD a menu, click and drag the "ADD NEW" box on the right to the menu structure on the left.  It will be added to the Hidden Menu area (gray).  To Edit the menu's content and settings, left click on pencil in the menu item and edit its settings in the Menu Settings box.
You can also re-enable disabled menus by dragging them back into the menu structure.  When finished, click <button type="button" class="btn btn-warning" onclick="window.close();">Finish</button>.</small>
<table class="table">
<tr>
<td rowspan="3">
<ul id="list1" class="mainlist">
<?php
$pmnu = $db->query("SELECT * FROM tbl_pages WHERE menu_status <= 1 AND parent_id = 0 ORDER BY menu_order");
while($pm = $pmnu->fetch(PDO::FETCH_ASSOC)) {
     $smnu = $db->query("SELECT * FROM tbl_pages WHERE menu_status <= 1 AND parent_id = $pm[p_id] ORDER BY menu_order");
     if($smnu->rowCount() > 0) {
          if($pm['menu_status'] == 0) {
               echo '<li id="'. $pm['p_id'] .'" class="hasitems" style="background-color: darkgray; color: white; font-style: italic;">'. stripslashes($pm['menu_name']);
               if($pm['menu_order'] != 99) { echo '<i class="fas fa-pencil-alt fa-pull-right" style="cursor: pointer" onclick="editMenu('. $pm['p_id'] .', 0)"></i>'."\r\n"; }               
          } else {
               echo '<li id="'. $pm['p_id'] .'" class="hasitems" style="background-color: cornflowerblue; color: white">'. stripslashes($pm['menu_name']);
               if($pm['menu_order'] != 99) { echo '<i class="fas fa-pencil-alt fa-pull-right" style="cursor: pointer" onclick="editMenu('. $pm['p_id'] .', 0)"></i>'."\r\n"; }
          }
          echo '<ul class="sublist">'."\r\n";
          while($sm = $smnu->fetch(PDO::FETCH_ASSOC)) {
               if($sm['menu_status'] == 0) {
                    echo '<li id="'. $sm['p_id'] .'" style="background-color: darkgray; color: white; font-style: italic">'. stripslashes($sm['menu_name']) .' <i class="fas fa-pencil-alt fa-pull-right" style="cursor: pointer" onclick="editMenu('. $sm['p_id'] .', '. $sm['parent_id'].')"></i></li>'."\r\n";                    
               } else {
                    echo '<li id="'. $sm['p_id'] .'" style="background-color: floralwhite; color: green">'. stripslashes($sm['menu_name']) .' <i class="fas fa-pencil-alt fa-pull-right" style="cursor: pointer" onclick="editMenu('. $sm['p_id'] .', '. $sm['parent_id'].')"></i></li>'."\r\n";
               }
          }
          echo '</ul></li>'."\r\n";
     } else {
          if($pm['menu_status'] == 0) {
               echo '<li id="'. $pm['p_id'] .'" class="hasitems" style="background-color: darkgray; color: white; font-style: italic">'. stripslashes($pm['menu_name']) .'<i class="fas fa-pencil-alt fa-pull-right" style="cursor: pointer" onclick="editMenu('. $pm['p_id'] .', 0)"></i>'."\r\n";               
          } else {
               echo '<li id="'. $pm['p_id'] .'" class="hasitems" style="background-color: cornflowerblue; color: white">'. stripslashes($pm['menu_name']) .'<i class="fas fa-pencil-alt fa-pull-right" style="cursor: pointer" onclick="editMenu('. $pm['p_id'] .', 0)"></i>'."\r\n";
          }
          echo '<ul class="sublist"><li style="background-color: cornflowerblue; border: 0;"></li></ul></li>'."\r\n";
          
     }
}
?>
</ul>
</td>
<td style="min-height: 50px;">
<small class="form-text text-muted mb-2">To add a new menu to the site, drag the Add New container to the menu structure.</small>
<ul id="list2" class="newlist">
<li class="hasitems addnew">Add New</li>
</ul>
</td>
</tr>
<tr>
<td style="min-height: 5px;">
<p>After clicking the edit pencil for a menu, edit its settings here.</p>
<div id="editbox">

</div>
</td>
</tr>
<tr>
<td>
<p>A list of deleted menus.  Drag them to the menu structure to undelete them.  Deleted menus will be purged annually.</p>
<ul id="list3" class="disabledlist">
<?php
$dmnu = $db->query("SELECT p_id, menu_name FROM tbl_pages WHERE menu_status = 9 ORDER BY menu_order");
while($dm = $dmnu->fetch(PDO::FETCH_ASSOC)) {
     ?>
     <li class="hasitems adddisabled" id="<?php echo $dm['p_id'] ?>"><?php echo $dm['menu_name'] ?></li>
     <?php
}
?>
</ul>
</td>
</tr>
</table>
</div>
</div>
</div>
</div>
</div>

<script>
$(function() {
     $('ul.mainlist').sortable({
          connectWith: 'ul.mainlist',
          beforeStop: function(ev, ui) {
               if($(ui.item).hasClass('hasItems') && $(ui.placeholder).parent()[0] != this) {
                    $(this).sortable('cancel');
               }
          },
          update: function(ev, ui) {
               var datas = $(this).sortable('toArray');
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/js/ajax_queries.php',
                    type: 'POST',
                    data: {
                         'change_parent_order': 1,
                         'data': datas
                    },
                    success: function(data) {
                         document.getElementById('tmpres').innerHTML = data;
                    }
               });               
          }
     });
     $('ul.sublist').sortable({
          containment: 'parent',
          connectWith: 'ul.sublist',
          beforeStop: function(ev, ui) {
               if($(ui.item).hasClass('hasItems') && $(ui.placeholder).parent()[0] != this) {
                    $(this).sortable('cancel');
               }
          },
          update: function(ev, ui) {
               var datap = $(this).sortable('toArray');
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/js/ajax_queries.php',
                    type: 'POST',
                    data: {
                         'change_child_order': 1,
                         'data': datap
                    },
                    success: function(data) {
                         document.getElementById('tmpres').innerHTML = data;
                    }
               });                               
          }
     });
     $('ul.newlist').sortable({
          connectWith: 'ul.mainlist',
          update: function(ev, ui) {
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/js/ajax_queries.php',
                    type: 'POST',
                    data: {
                         'add_menu': 1
                    },
                    success: function(data) {
                         location.reload();
                    }
               });
          }
     });
     $('ul.disabledlist').sortable({
          connectWith: 'ul.mainlist',
          update: function(ev, ui) {
               var pid = ui.item.attr("id");
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/js/ajax_queries.php',
                    type: 'POST',
                    data: {
                         'enable_menu': 1,
                         'p_id': pid
                    },
                    success: function(data) {
                         location.reload();
                    }
               });
          }
     });     
     
});
function editMenu(pid, parentid)
{
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/js/ajax_queries.php',
          type: 'POST',
          data: {
               'edit_menu': 1,
               'p_id': pid,
               'parent_id': parentid
          },
          success: function(data) {
               $('#editbox').html(data);
               $(function() {
                    $('.mdb-select').materialSelect();
               });
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
                    document.getElementById('newmenu_link').value = mlink;                     
               }
          }
     });
}
function updateMenu(pid)
{
     if($('input:radio[name=newmenu_type]:checked').val() == 'P') {
          var parent_id = 0;
     } else {
          var parent_id = document.getElementById('selected_parent').value;
     }
     $.ajax({
          url: '<?php echo $gbl['site_url'] ?>/js/ajax_queries.php',
          type: 'POST',
          data: {
               'update_menu': 1,
               'p_id': pid,
               'menu_name': document.getElementById('newmenu_name').value,
               'menu_link': document.getElementById('newmenu_link').value,
               'menu_status': $('input:radio[name=newmenu_status]:checked').val(),
               'parent_id': parent_id
          },
          success: function(data) {
               location.reload();
          }
     });
}
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
     document.getElementById('newmenu_link').value = mlink;                     
}
</script>
<?php
$cdnj = $db->query("SELECT * FROM tbl_cdns WHERE cdn_location = 5 ORDER BY cdn_order");
while($cdj = $cdnj->fetch(PDO::FETCH_ASSOC)) {
     echo $cdj['cdn_script'] ."\n";
}
?>

</body>
</html>
