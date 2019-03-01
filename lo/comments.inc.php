<?php
if($pg['allow_comments'] == 1) {
     ?>
     <!-- ajaxForms -->
     <script src="http://malsup.github.com/jquery.form.js"></script>
     <script>
     function submitComment()
     {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/js/ajax_queries.php',
               type: 'POST',
               data: {
                    'new_comment':true,
                    'comment_name':document.getElementById('commentname').value,
                    'comment_email':document.getElementById('commentemail').value,
                    'comment_text':document.getElementById('commenttext').value,
                    'comment_page':'<?php echo $pg['p_id'] ?>'
               },
               success: function(data) {
                    document.getElementById('comment_div').style.display = "none";
                    document.getElementById('comment_form').disabled = true;                                                  
               }
          });     
     }
     </script>
     <script>
     function approveComment(commentid)
     {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/js/ajax_queries.php',
               type: 'POST',
               data: {
                    'approve_comment':true,
                    'comment_id':commentid
               },
               success: function(data) {
                    document.getElementById('button-'+commentid).style.visibility = 'hidden';
                    document.getElementById('well-'+commentid).style.background = '';                                                 
               }
          });           
     }
     </script>
     <script>
     function deleteComment(commentid)
     {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/js/ajax_queries.php',
               type: 'POST',
               data: {
                    'delete_comment':true,
                    'comment_id':commentid
               },
               success: function(data) {
                    document.getElementById('well-'+commentid).style.display = 'none';                                                 
               }
          });           
     }
     </script>                
     <?php
     $approves = 0;
     if(isset($_SESSION['isLoggedIn']) && $_SESSION['user']['security'] >= 4) {
          $asql = $db->query("SELECT cm_id FROM $_SESSION[prefix]_comments WHERE comment_page_id = '". $_SESSION['page']['p_id'] ."' AND comment_status = 0");
          if($asql->rowCount() > 0) {
               $approves = 1;
               $csql = $db->query("SELECT * FROM $_SESSION[prefix]_comments WHERE comment_page_id = '". $_SESSION['page']['p_id'] ."' ORDER BY comment_date DESC");
          } else {
               $approves = 0;
               $csql = $db->query("SELECT * FROM $_SESSION[prefix]_comments WHERE comment_page_id = '". $_SESSION['page']['p_id'] ."' AND comment_status = 1 ORDER BY comment_date DESC");               
          }
     } else {
          $csql = $db->query("SELECT * FROM $_SESSION[prefix]_comments WHERE comment_page_id = '". $_SESSION['page']['p_id'] ."' AND comment_status = 1 ORDER BY comment_date DESC");          
     }
     ?>
     <div class="row">
     <div class="col-lg-12">
     <div class="panel">
     <div class="panel-heading panel-heading-custom">Comments</div>
     <div class="panel-body">
     <?php
     while($cmt = $csql->fetch(PDO::FETCH_ASSOC)) {
     if(isset($_SESSION['isLoggedIn']) && $_SESSION['user']['security'] >= 4 && $cmt['comment_status'] == 0) {
               $style = 'style="background: red;" ';
          } else {
               $style = '';
          }
          ?>
          <div class="col-xs-4">
          <div class="well well-sm" <?php echo $style ?> id="well-<?php echo $cmt['cm_id'] ?>">
          <p class="help-block"><?php echo date("M j Y, h:i a", strtotime($cmt['comment_date'])) ?> by <?php echo $cmt['comment_email'] ?></p>
          <?php echo stripslashes($cmt['comment_text']) ?><br /><br />
          <?php
          if(isset($_SESSION['isLoggedIn']) && $_SESSION['user']['security'] >= 4 && $cmt['comment_status'] == 0) {
               ?>
               <button type="button" id="button-<?php echo $cmt['cm_id'] ?>" class="btn btn-success btn-xs" onclick="approveComment(<?php echo $cmt['cm_id'] ?>)"><i class="glyphicon glyphicon-check"></i> Approve</button>
               <?php
          }
          if(isset($_SESSION['isLoggedIn']) && $_SESSION['user']['security'] >= 4) {
               ?>
               <button type="button" class="btn btn-danger btn-xs" onclick="deleteComment(<?php echo $cmt['cm_id'] ?>)"><i class="glyphicon glyphicon-erase"></i> Delete</button>
               <?php
          }
          ?>          
          </div>
          </div>
          <?php
     }
     ?>
     <div class="col-xs-12" id="comment_div">
     <?php
     if(!isset($_SESSION['comment_added'])) {
          ?>
          <p class="help-block">New Comment</p>
          <form id="comment_form">
          <b>Your Full Name</b><br />
          <input type="text" name="commentname" id="commentname" required="required" class="form-control" /><br />
          <b>Your Email Address</b><br />
          <input type="email" name="commentemail" id="commentemail" required="required" class="form-control" /><br />
          <b>Your comment</b><br />
          <textarea name="commenttext" id="commenttext" class="form-control" cols="75%" rows="6" maxlength="500" placeholder="Max of 500 characters"></textarea><br />
          <button type="button" data-toggle="modal" data-target="#comment_modal" onclick="submitComment()" class="btn btn-primary"><i class="glyphicon glyphicon-comment"></i> Submit Comment</button>
          </form>
          <?php
     } else {
          echo '<p class="help-block">You have already submitted a comment for this session.  Multiple comments not permitted!</p>';
     }
     ?>
     </div>     
     </div>
     <div class="panel-footer">Comment will not display until approved.</div>
     </div>
     </div>
     </div>
     
     <!-- comment response modal-->
     <div id="comment_modal" class="modal fade" tabindex="-1" role="dialog">
     <div class="modal-dialog modal-sm" role="document">
     <div class="modal-content">
     <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">Comment Submitted</h4>
     </div>
     <div class="modal-body">
     Your Comment has been saved.  An Administrator will review your comment and approve it if it is appropriate for our website.  Thank you.
     </div>
     <div class="modal-footer">
     <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
     </div>
     </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
     </div><!-- /.modal -->
     <?php
}
?>