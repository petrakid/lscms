<?php
if(isset($_SESSION['isLoggedIn'])) {
     if($_GET['page'] == 'new-form') {
          ?>
          <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
          <ul class="nav md-pills pills-secondary">
          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#panel1" role="tab">Form Builder</a></li>
          <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#panel2" role="tab">Settings</a></li>
          </ul>
          
          <div class="tab-content pt-0">
          <div class="tab-pane fade in show active" id="panel1" role="tabpanel">
          <div class="row">
          <div class="col-md-12">
          <div class="card">
          <div class="card-body">
          <h5 class="card-title">Form Creator</h5>
          <p>Use the following options to create your form, dragging and dropping them where you'd like in the form.  You can add as many fields as you like.  BE SURE to provide all of the required information for each field, as well
          as the Form Submission information.  When finished, click "Save Form".</p>
            
          <hr />
          <div class="row">
          <div class="col-md-12">
          <div id="form-editor">
          
          </div>
          </div>
          </div>
          </div>
          </div>
          </div>
          </div>
          </div>
          
          <div class="tab-pane fade in show" id="panel2" role="tabpanel">
          <div class="row">
          <div class="col-md-6">
          
          <div class="md-form">
          <input type="text" name="form-name" id="form-name" class="form-control" />
          <label for="form-name">Give this form a name</label>
          </div>
          
          <div class="md-form">
          <input type="text" name="form-subject" id="form-subject" class="form-control" />
          <label for="form-subject">Subject for Email</label>
          </div>
          
          <div class="md-form">
          <textarea name="form-heading" id="form-heading" class="md-textarea form-control" rows="4" cols="100%"></textarea>
          <label for="form-heading">Text to prepend to email</label>
          </div>
          
          <div class="md-form">
          <textarea name="form-footer" id="form-footer" class="md-textarea form-control" rows="4" cols="100%"></textarea>
          <label for="form-footer">Text to append to email</label>
          </div>     
          
          
          </div>
          <div class="col-md-6">
          <div class="md-form">
          <input type="email" name="form-from-email" id="form-from-email" class="form-control" aria-labeled-by="senderhelp" />
          <label for="form-from-email">Sender Email Address</label>
          <small id="senderhelp" class="form-text text-muted">If you leave this field blank, the sender email address will be the email address entered by the form user.</small>
          </div>
          
          <div class="md-form">
          <input type="email" name="form-to-email" id="form-to-email" class="form-control" />
          <label for="form-to-email">Receiver Email Address</label>
          </div>
          
          </div>
          </div>
          </div>
          </div>
          
          <script>
          jQuery($ => {
               var fbTemplate = $('#form-editor');
               var options = {
                    onSave: function(evt, formData) {
                         if($('#form-name').val() == '') {
                              alert('You need to give this form a name!  Click the Settings button and be sure to fill out the additional fields');
                              return false;
                         }
                         if($('#form-subject').val() == '') {
                              alert('You need to give this form a subject!  Click the Settings button and be sure to fill out the additional fields');
                              return false;
                         }
                         $.ajax({
                              url: '<?php echo $gbl['site_url'] ?>/plg/forms/ajax.php',
                              type: 'POST',
                              data: {
                                   'add_form':1,
                                   'form_name': $('#form-name').val(),
                                   'form_subject': $('#form-subject').val(),
                                   'form_data': formBuilder.actions.getData('json', true),
                                   'form_heading_text': $('#form-heading').val(),
                                   'form_footer_text': $('#form-footer').val(),
                                   'form_from_email': $('#form-from-email').val(),
                                   'form_to_email': $('#form-to-email').val()
                              },
                              success: function(data) {
                                   toastr.success('Form Saved');
                                   setTimeout(function() {
                                        window.location.reload()
                                   }, 1500)
                              }
                         })                    
                    }
               }
               var formBuilder = $(fbTemplate).formBuilder(options);
          })       
          </script>
          
          <?php
     }
     else if($_GET['page'] == 'edit-forms') {
          ?>
          <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>          
          <div class="row">
          <div class="col-md-5">
          <h3 class="responsive">Form Editor</h3>
          <p>Select the form you'd like to edit below.  After you select, the form will load for editing.</p>
          <select name="select-form" id="select-form" class="mdb-select md-form" onchange="loadForm(this.value)">
          <option value="" disabled selected>Select a Form</option>
          <?php
          $frm = $db->query("SELECT f_id, form_name FROM tbl_forms_data WHERE form_status != 9 ORDER BY form_name");
          while($fm = $frm->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <option value="<?php echo $fm['f_id'] ?>"><?php echo stripslashes($fm['form_name']) ?></option>
               
               <?php
          }          
          ?>
          </select>
          </div>
          </div>
          <hr />
          <div id="formres">
          
          </div>
          
          <script>
          function loadForm(form)
          {
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/plg/forms/ajax.php',
                    type: 'POST',
                    data: {
                         'edit_form': 1,
                         'form_id': form
                    },
                    success: function(data) {
                         $.ajax({
                              url: '<?php echo $gbl['site_url'] ?>/plg/forms/ajax.php',
                              type: 'POST',
                              data: {
                                   'get_fdata': 1,
                                   'f_id': form
                              },
                              success: function(data) {
                                   jQuery($ => {
                                        var fbTemplate = $('#form-editor');
                                        options = {
                                             formData: data,                                            
                                             onSave: function(evt, fData) {
                                                  if($('#form-name').val() == '') {
                                                       alert('You need to give this form a name!  Click the Settings button and be sure to fill out the additional fields');
                                                       return false;
                                                  }
                                                  if($('#form-subject').val() == '') {
                                                       alert('You need to give this form a subject!  Click the Settings button and be sure to fill out the additional fields');
                                                       return false;
                                                  }
                                                  $.ajax({
                                                       url: '<?php echo $gbl['site_url'] ?>/plg/forms/ajax.php',
                                                       type: 'POST',
                                                       data: {
                                                            'update_form':1,
                                                            'f_id': $('#form-id').val(),
                                                            'form_name': $('#form-name').val(),
                                                            'form_subject': $('#form-subject').val(),
                                                            'form_data': formBuilder.actions.getData('json', true),
                                                            'form_heading_text': $('#form-heading').val(),
                                                            'form_footer_text': $('#form-footer').val(),
                                                            'form_from_email': $('#form-from-email').val(),
                                                            'form_to_email': $('#form-to-email').val()
                                                       },
                                                       success: function(data) {
                                                            toastr.success(data);
                                                            setTimeout(function() {
                                                                 window.location.reload()
                                                            }, 1500)
                                                       }
                                                  })                    
                                             }
                                        }
                                        const formBuilder = $(fbTemplate).formBuilder(options);
                                   }) 
                              }
                         });                          
                         $('#formres').html(data);
                    }
               })
          }
          </script>
          
          <?php
     } else {
          ?>
          <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
          <div class="row">
          <div class="col-md-5">
          <h5 class="responsive">Select the Form you would like displayed on this page</h5>
          <select name="myForm" id="myForm" onchange="selectForm(this.value)" class="mdb-select md-form">
          <option value="" disabled selected>Select</option>
          <?php
          $frm = $db->query("SELECT f_id, form_name FROM tbl_forms_data WHERE form_status != 9 ORDER BY form_name");
          while($fm = $frm->fetch(PDO::FETCH_ASSOC)) {
               if($fm['form_block_id'] == $row['b_id']) {
                    ?>
                    <option value="<?php echo $fm['f_id'] ?>" selected="selected"><?php echo stripslashes($fm['form_name']) ?></option>                    
                    
                    <?php
               }
               ?>
               <option value="<?php echo $fm['f_id'] ?>"><?php echo stripslashes($fm['form_name']) ?></option>
               
               <?php
          }
          ?>
          </select>
          </div>
          </div>
          <div class="row">
          <div class="col-md-6 col-xs-12">
          <form class="fb-render" id="fb-render"></form>
          <div class="fb-result"></div>
          </div>
          </div>
          <script>
          function selectForm(form)
          {
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/plg/forms/ajax.php',
                    type: 'POST',
                    data: {
                         'select_form': 1,
                         'form_id': form,
                         'block_id': '<?php echo $row['b_id'] ?>'
                    },
                    success: function(data) {
                         toastr.success('Form Added');
                         setTimeout(function() {
                              window.location.reload()
                         }, 1500)
                    }
               })                
          }
          $(function() {
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/plg/forms/ajax.php',
                    type: 'POST',
                    data: {
                         'load_form': 1,
                         'block_id': '<?php echo $row['b_id'] ?>'
                    },
                    success: function(data) {
                         $(function() {
                              var fbRender = document.getElementById('fb-render'),
                              formData = data;
                              var formRenderOpts = {
                                   formData: formData
                              }
                              $(fbRender).formRender(formRenderOpts);
                         })                         
                    }
               })                 
          })
          $('.fb-render').submit(function(event) {
               var o = {};
               var a = $(".fb-render :input").serializeArray();
               $.each(a, function () {
                    if(o[this.name] !== undefined) {
                        if(!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
               });
               $.ajax({          
                    url: '<?php echo $gbl['site_url'] ?>/plg/forms/ajax.php',
                    type: "POST",
                    data: {
                         'block_id': '<?php echo $row['b_id'] ?>',
                         'sformdata': o
                    },
                    dataType: "HTML",
                    async: false,
                    success: function(data) {
                         $(".fb-render").hide();               
                         $('.fb-result').html(data);
                    }
               });
               event.preventDefault();
          });          
          </script>
          <?php     
     }
} else {
     ?>
     <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>     
     <div class="row">
     <div class="col-md-6 col-xs-12">
     <form class="fb-render" id="fb-render"></form>
     <div class="fb-result"></div>     
     </div>
     </div>     
     
     <script>
     $(function() {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/forms/ajax.php',
               type: 'POST',
               data: {
                    'load_form': 1,
                    'block_id': '<?php echo $row['b_id'] ?>'
               },
               success: function(data) {
                    $(function() {
                         var fbRender = document.getElementById('fb-render'),
                         formData = data;
                         var formRenderOpts = {
                              formData: formData
                         }
                         $(fbRender).formRender(formRenderOpts);
                    })                         
               }
          })                 
     })
     $('.fb-render').submit(function(event) {
          var o = {};
          var a = $(".fb-render :input").serializeArray();
          $.each(a, function () {
               if(o[this.name] !== undefined) {
                   if(!o[this.name].push) {
                       o[this.name] = [o[this.name]];
                   }
                   o[this.name].push(this.value || '');
               } else {
                   o[this.name] = this.value || '';
               }
          });
          $.ajax({          
               url: '<?php echo $gbl['site_url'] ?>/plg/forms/ajax.php',
               type: "POST",
               data: {
                    'block_id': '<?php echo $row['b_id'] ?>',
                    'sformdata': o
               },
               dataType: "HTML",
               async: false,
               success: function(data) {
                         $(".fb-render").hide();               
                         $('.fb-result').html(data);
               }
          });
          event.preventDefault();
     });      
     </script>   
            
     <?php     
}
?>
