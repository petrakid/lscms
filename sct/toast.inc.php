<?php 
if(isset($_SESSION['isLoggedIn'])) {
     ?>
     <section class="mx-2 mb-4 pg-3" id="notif_select">
     <div class="row">
     <div class="col-4">
     <select name="notif_id" class="md-form mdb-select" onchange="selectNotif(this.value)">
     <option value="" disabled selected>Select</option>
     <?php
     $nots = $db->query("SELECT m_id, m_title FROM tbl_toast_messages ORDER BY m_id");
     while($no = $nots->fetch(PDO::FETCH_ASSOC)) {
          if($no['m_status'] == 0) {
               echo '<option value="'. $no['m_id'] .'" class="red">'. $no['m_title'] .'</option>'."\n";
          } else {
               echo '<option value="'. $no['m_id'] .'" class="green">'. $no['m_title'] .'</option>'."\n";               
          }
     }
     ?>
     </select>
     <label>Select a Notification,</label>
     </div>
     <div class="col-3">
     <small class="form-text">or click to create a new Notification</small><br />
     <button class="btn btn-indigo btn-block" onclick="newNotif()"><i class="fa fa-plus"></i> Create New</button>
     </div>
     </div>
     </section>
     
     <section class="mx-2 mb-4 pb-3" id="notif_edit" style="display: none">

     </section>
     
     <script>
     function selectNotif(mid)
     {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/sct/ajax/toast.php',
               type: 'POST',
               data: {
                    'edit_notif': 1,
                    'm_id': mid
               },
               success: function(data) {
                    $('#notif_edit').show();
                    $('#notif_edit').html(data);
                    $(function() {
                         $('.mdb-select2').material_select();
                    });
                    $('.datepicker').pickadate();
                    $(function() {
                         $('[data-toggle="tooltip"]').tooltip()
                    });
                    $(function(){
                         $("form#editnotifform").submit(function(e){
                              e.preventDefault();
                              var formData = new FormData($(this)[0]);
                              formData.append("updatenotif", "1");
                              $.ajax({
                                   url: '<?php echo $gbl['site_url'] ?>/sct/ajax/toast.php',
                                   type: 'POST',
                                   data: formData,
                                   processData: false,
                                   contentType: false,                                   
                                   success: function(data) {
                                        $('#notif_edit').html(data);
                                        setTimeout(function() {
                                             window.location.reload()
                                        }, 2000);
                                   }
                              })
                         });
                    });                    
               }
          })
     }
     function newNotif()
     {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/sct/ajax/toast.php',
               type: 'POST',
               data: {
                    'new_notif': 1
               },
               success: function(data) {
                    $('#notif_edit').show();
                    $('#notif_edit').html(data);
                    $(function() {
                         $('.mdb-select2').material_select();
                    });
                    $('.datepicker').pickadate();
                    $(function() {
                         $('[data-toggle="tooltip"]').tooltip()
                    });                    
                    $(function(){
                         $("form#notifform").submit(function(e){
                              e.preventDefault();
                              var formData = new FormData($(this)[0]);
                              formData.append("addnotif", "1");
                              $.ajax({
                                   url: '<?php echo $gbl['site_url'] ?>/sct/ajax/toast.php',
                                   type: 'POST',
                                   data: formData,
                                   processData: false,
                                   contentType: false,                                   
                                   success: function(data) {
                                        $('#notif_edit').html(data);
                                        setTimeout(function() {
                                             window.location.reload()
                                        }, 2000);
                                   }
                              })
                         });
                    });                    
               }
          })          
     }
     </script>
     <?php
}
?>