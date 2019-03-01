
<?php
$csse = $db->query("SELECT cdn_script FROM tbl_cdns WHERE cdn_location = 5 ORDER BY cdn_order");
while($cse = $csse->fetch(PDO::FETCH_ASSOC)) {
     echo $cse['cdn_script'] ."\r\n";
}
?>

<script>
$(function() {
     $('.mdb-select').materialSelect();
});
$(function() {
     $('.card').addClass('card-custom');
     $('.card-header').addClass('card-header-custom');
     $('.nav').addClass('nav-custom');
})
$.fn.modal.Constructor.prototype.enforceFocus = function() {
     modal_this = this
     $(document).on('focusin.modal', function (e) {
          if (modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length 
               && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select') 
               && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_textarea')
               && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
                    modal_this.$element.focus()
          }
     })
};
</script>

<?php
if($l['search_form'] == 1) {
     ?>
     
     <script>
     $(function() {
          $('#searchRes').html('No Results Found.');          
          $('#searchForm').on('submit', function(e) {
               e.preventDefault();
               var sstring = $('#sitesearchtext').val();
               if(sstring == '') {
                    exit;
               }
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/js/ajax_search.php',
                    type: 'POST',
                    data: {
                         'site_search': '1',
                         'string': sstring
                    },
                    success: function(data) {
                         $('#searchModal').modal('show');
                         if(data > '') {
                              $('#searchRes').html(data);
                         }
                    }
               })               
          })
     })
     $(function() {
          $('#searchRes').html('No Results Found.');
          $('#submit_img').on('click', function() {
               var sstring = $('#sitesearchtext').val();
               if(sstring == '') {
                    exit;
               }
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/js/ajax_search.php',
                    type: 'POST',
                    data: {
                         'site_search': '1',
                         'string': sstring
                    },
                    success: function(data) {
                         $('#searchModal').modal('show');
                         if(data > '') {
                              $('#searchRes').html(data);
                         }
                    }
               })               
          })
     })     
     </script>
     <div class="modal fade right" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-side modal-top-right" role="document">
     <div class="modal-content">
     <div class="modal-header">
     <h4 class="modal-title w-100" id="searchModalLabel">Search Results</h4>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <span aria-hidden="true">&times;</span>
     </button>
     </div>
     <div class="modal-body" id="searchRes">
     No Results Found.
     </div>
     <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
     </div>
     </div>
     </div>
     </div>
     <?php
}

if(isset($_SESSION['isLoggedIn'])) {
     $cssf = $db->query("SELECT cdn_script FROM tbl_cdns WHERE cdn_location = 6 ORDER BY cdn_order");
     while($csf = $cssf->fetch(PDO::FETCH_ASSOC)) {
          echo $csf['cdn_script'] ."\r\n";
     }       
}

$popup = $db->query("SELECT * FROM tbl_infopopup WHERE popup_status = 1 AND (popup_page = 0 OR popup_page = '$pg[p_id]') LIMIT 1");
if($popup->rowCount() > 0) {
     $pop = $popup->fetch(PDO::FETCH_ASSOC);
     if($pop['popup_frequency'] == 1) {
          $_SESSION['popupfrequency'] = 1;
     } elseif($pop['popup_frequency'] == 2) {
          $_SESSION['popupfrequency'] = 0;
     }
     ?>
     
     <div class="modal fade" id="warningModal" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">     
     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Cancel"><span aria-hidden="true">&times;</span></button>
     <h3><?php echo $pop['popup_name'] ?></h3>
     </div>
     <div class="modal-body">
     <?php echo $pop['popup_text'] ?>
     </div>
     <div class="modal-footer">
     <button type="button" class="btn btn-default" data-dismiss="modal">Continue to Site</button>
     </div>
     </div>
     </div>
     </div>
     <?php
     if($_SESSION['popupfrequency'] == 1 && !isset($_SESSION['popupvisited'])) {
          ?>
          <script type="text/javascript">
          $(function(){
               $('#warningModal').modal('show');
          });
          </script>       
          <?php
          $_SESSION['popupvisited'] = 1;
     }
     elseif($_SESSION['popupfrequency'] == 0) {
          ?>
          <script type="text/javascript">
          $(function(){
               $('#warningModal').modal('show');
          });          
          </script>       
          <?php          
     }
}
if(!isset($_SESSION['isLoggedIn'])) {
     ?>

     <div id="login_Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="loginModal">
     <div class="modal-dialog" role="document">
     <div class="modal-content form-elegant">
     <div class="modal-header text-center">
     <h3 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="loginModal">Login</h3>
     <button type="button" class="close" data-dismiss="modal" aria-label="Cancel"><span aria-hidden="true">&times;</span></button>
     </div>
     <div class="modal-body mx-4" id="results">
     <form autocomplete="off">     
     <div class="md-form mb-5">
     <i class="fa fa-envelope prefix grey-text"></i>
     <input type="email" name="username" id="username" placeholder="Email Address" class="form-control validate" autofocus="autofocus" />
     <label data-error="Invalid" data-success="Great!" for="username">Username</label>
     </div>
     
     <div class="md-form pb-3">
     <i class="fa fa-lock prefix grey-text"></i>
     <input type="password" name="password" id="password" placeholder="Password" class="form-control validate" />
     <label data-error="Invalid" data-success="Valid" for="password">Your password</label>
     <p class="font-small blue-text d-flex justify-content-end"><a href="#" onclick="forgotPass()" class="blue-text ml-1">Forgot Password?</a></p>
     </div>
     
     <div class="form-group mt-1">
     <input type="checkbox" name="rememberme" id="rememberme" value="1" class="form-check-input" />
     <label for="rememberme" class="form-check-label">Remember me</label>
     </div>
     
     <div class="text-center mb-3">
     <button type="button" onclick="loginUser()" class="btn tempting-azure-gradient btn-block btn-rounded z-depth-1a">Login</button>
     </div>
     </form>
     </div>

     </div>
     </div>
     </div>

     <script>
     function loginUser()
     {
          var user = document.getElementById("username").value;
          var password = document.getElementById("password").value;
          var rememberme = $("input[name='rememberme']:checked").val();
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/js/ajax_login.php',
               type: 'POST',
               data: {
                    'login_user':true,
                    'user_id': user,
                    'password': password,
                    'rememberme': rememberme
               },
               success: function(data) {
                    document.getElementById("results").style.display = "block";
                    document.getElementById("results").innerHTML = data;
                    setTimeout(function(){window.location.reload();}, 2500);                    
               }
          });   
     }
     function forgotPass()
     {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/js/ajax_login.php',
               type: 'POST',
               data: {
                    'forgot_pass': 1
               },
               success: function(data) {
                    $('#results').html(data);
               }
          })
     }
     function doReset()
     {
          var pwrusername = $('#pwrusername').val();
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/js/ajax_login.php',
               type: 'POST',
               data: {
                    'reset_pass': 1,
                    'pwrusername': pwrusername
               },
               success: function(data) {
                    $('#results').html(data);
                    setTimeout(function(){window.location.reload()}, 2000);
               }
          })          
     }
     </script>
             
     <?php
} else {
     ?>
     <!-- Block Edit Modal-->
     <div id="beditmodal" class="modal fade" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-lg" role="document">
     <div class="modal-content">
     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Cancel"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">Block Edit</h4>
     </div>
     <div class="modal-body">
     <div id="beresults" style="margin-top: 10px;"></div>
     </div>
     <div class="modal-footer">
     <button type="button" class="btn btn-success" onclick="saveBEdit()" id="besavebutton">Save</button>
     <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
     </div>
     </div>
     </div>
     </div> 
         
     <script>
     $(".init").sideNav();
     var sideNavScrollbar = document.querySelector('.custom-scrollbar');
     Ps.initialize(sideNavScrollbar);
     </script>
     <script>
     $.fn.modal.Constructor.prototype.enforceFocus = function() {
          modal_this = this
          $(document).on('focusin.modal', function (e) {
               if(modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length 
               && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_select') 
               && !$(e.target.parentNode).hasClass('cke_dialog_ui_input_text')) {
                    modal_this.$element.focus()
               }
               if(modal_this.$element[0] !== e.target && !modal_this.$element.has(e.target).length
               && $(e.target.parentNode).hasClass('cke_contents cke_reset')) {
                    modal_this.$element.focus()
               }          
          })
     };     
     function mouseoverPass()
     {
          var obj = document.getElementById('password');
          obj.type = "text";
     }
     function mouseoutPass()
     {
          var obj = document.getElementById('password');
          obj.type = "password";
     }
     $(document).ready(function() {
         $(document).on("click",".get_bdata", function(){
            var blockid = $(this).attr("data-id");    
            $.ajax({
                 url: '<?php echo $gbl['site_url'] ?>/js/ajax_queries.php',
                 type: "POST",
                 data: {
                    'b_id': blockid,
                    'ledit_block': '1'
                 },
                 dataType: "HTML",
                 async: false,
                 success: function(data) {
                    $('#beresults').html(data);
                    CKEDITOR.replace('bcontent',
                         {
                             filebrowserBrowseUrl : '<?php echo $gbl['site_url'] ?>/js/filemanagerck/dialog.php?type=2&editor=ckeditor&fldr=res',
     	                   filebrowserUploadUrl : '<?php echo $gbl['site_url'] ?>/js/filemanagerck/dialog.php?type=2&editor=ckeditor&fldr=res',
     	                   filebrowserImageBrowseUrl : '<?php echo $gbl['site_url'] ?>/js/filemanagerck/dialog.php?type=1&editor=ckeditor&fldr=res'
                         }
                    );                              
                }
            }); 
         });
     });
     function saveBEdit()
     {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/js/ajax_queries.php',
               type: 'POST',
               data: {
                    'update_lblock': 1,
                    'b_id':  document.getElementById('lb_id').value,
                    'block_content' : CKEDITOR.instances["bcontent"].getData()              
               },
               success: function(data) {
                    document.getElementById('beresults').innerHTML = data;
                    document.getElementById('besavebutton').style.display = "none";
                    window.location.reload();
               }
          })
     }
     </script>

     <?php
}

?>

</body>
</html>
