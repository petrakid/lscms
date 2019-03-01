
<div class="row">
<?php
if(!isset($_GET['eventid'])) {
     if(isset($_SESSION['isLoggedIn'])) {
          $cal = $db->query("SELECT c_id FROM tbl_calendars WHERE page_id = '". $_SESSION['page']['p_id'] ."'");
          if($cal->rowCount() > 0) {
               $cl = $cal->fetch(PDO::FETCH_ASSOC);
               ?>
               <div class="col-4">
               <div class="card-body">
               <button class="btn btn-success btn-block" onclick="newEvent('<?php echo $cl['c_id'] ?>')"><i class="fa fa-clock"></i> New Event</button>
               </div>
               </div>
               <div class="col-4">
               <div class="card-body">
               <button class="btn btn-info btn-block" onclick="manageCalendar('<?php echo $cl['c_id'] ?>')"><i class="fa fa-calendar-alt"></i> Manage Calendar</button>
               </div>
               </div>
               <?php
          } else {
               ?>
               <div class="col-4">
               <div class="card-body">
               <button class="btn btn-warning btn-block" onclick="newCalendar()"><i class="fa fa-calendar-plus"></i> New Calendar</button>
               </div>
               </div>
               <?php
          }
     }
     ?>
     </div>
     
     <div class="row">
     <div class="col-12">
     <div class="card-body" id="calendar_data">
     
     </div>
     </div>
     </div>
     <link rel="stylesheet" href="<?php echo $gbl['site_url'] ?>/plg/calendars/calendar.css" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
     <script src="<?php echo $gbl['site_url'] ?>/plg/calendars/calendar.js"></script>
     <script>
     $(function() {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/calendars/ajax.php',
               type: 'POST',
               data: {
                    'view_calendar': 1,
                    'page_id': '<?php echo $_SESSION['page']['p_id'] ?>'
               },
               success: function(data) {
                    $('#calendar_data').html(data);
                    $(function() {
                         $('#caltable').DataTable({
                              scrollY:        "800px",
                              scrollCollapse: true,
                              paging:         false,
                              order: [0, 'asc'],
                              columnDefs: [{orderable: false, targets: '_all'}]
                         });
                    });
                    $.getScript('<?php echo $gbl['site_url'] ?>/plg/calendars/events.js', function() {
                         
                    });
               }
          })
     })
     </script>
     <?php 
     if(isset($_SESSION['isLoggedIn'])) {
          ?>
          <div class="modal fade" id="calModal" tabindex="-1" role="dialog" aria-labelledby="calModalLabel">
          <div class="modal-dialog" role="document">
          <div class="modal-content">
          <div class="modal-header">
          <h5 class="modal-title" id="calModalLabel">Calendar Settings</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cancel"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body" id="modal_res">
     
          </div>
          <div class="modal-footer">
          <button type="button" class="btn btn-info" data-dismiss="modal" id="modalCancel">Cancel</button>
          <button type="button" class="btn btn-primary" id="modalSave">Save changes</button>
          </div>
          </div>
          </div>
          </div>
          <script>
          function newEvent(calid)
          {
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/plg/calendars/ajax.php',
                    type: 'POST',
                    data: {
                         'new_event': 1,
                         'cal_id': calid
                    },
                    success: function(data) {
                     
                         $('#calModal').modal('show');
                         $('#calModal').on('shown.bs.modal', function() {
                              $(document).off('focusin.modal');
                         });                         
                         $('#calModal').removeAttr('tabindex');
                         $('#calModalLabel').html("New Event");
                         $('#modalSave').html("Add Event");
                         $('#modal_res').html(data);
                         $(function() {
                              $('.mdb-select').materialSelect();
                         });                         
                         CKEDITOR.replace('event_detail', {
                              filebrowserBrowseUrl : 'js/filemanagerck/dialog.php?type=2&editor=ckeditor&fldr=res',
                              filebrowserUploadUrl : 'js/filemanagerck/dialog.php?type=2&editor=ckeditor&fldr=res',
                              filebrowserImageBrowseUrl : 'js/filemanagerck/dialog.php?type=1&editor=ckeditor&fldr=res'
                         })
                         $('#modalSave').on("click", function() {
                              var ckdata = CKEDITOR.instances['event_detail'].getData();
                              var formdata = new FormData();
                              formdata.append('do_add_event', '1');
                              formdata.append('calendar_id', calid);
                              formdata.append('event_title', $('#event_title').val());
                              formdata.append('event_subtitle', $('#event_subtitle').val());
                              formdata.append('event_detail', ckdata);
                              formdata.append('event_image', $('input[type=file]')[0].files[0]);
                              formdata.append('event_color', $('#event_color').val());
                              formdata.append('event_font_color', $('#event_font_color').val());
                              formdata.append('event_status', $("input[name='event_status']:checked").val());
                              formdata.append('allow_signup', $("input[name='allow_signup']:checked").val());
                              formdata.append('event_start_date', $('#event_start_date').val());
                              formdata.append('event_end_date', $('#event_end_date').val());
                              formdata.append('event_start_time', $('#event_start_time').val());
                              formdata.append('event_end_time', $('#event_end_time').val());
                              formdata.append('recurring', $("input[name='recurring']:checked").val());
                              formdata.append('recurring_interval', $('#recurring_interval').val());
                              formdata.append('event_pinned', $("input[name='event_pinned']:checked").val());
                              $.ajax({
                                   url: '<?php echo $gbl['site_url'] ?>/plg/calendars/ajax.php',
                                   type: 'POST',
                                   processData: false,
                                   contentType: false,                              
                                   data: formdata,
                                   success: function(data) {
                                        $('#modalSave').hide();
                                        $('#modalCancel').html('Close');                                   
                                        $('#modal_res').html(data);
                                        $('#calModal').on('hidden.bs.modal', function(e) {
                                             window.location.reload();
                                        })                                   
                                   }
                              })
                         })                     
                    }
               })
          }
          function editEvent(eventid)
          {
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/plg/calendars/ajax.php',
                    type: 'POST',
                    data: {
                         'edit_event': 1,
                         'e_id': eventid
                    },
                    success: function(data) {
                         
                         $('#calModal').modal('show');
                         $('#calModal').on('shown.bs.modal', function() {
                              $(document).off('focusin.modal');
                         });                         
                         $('#calModal').removeAttr('tabindex');                         
                         $('#calModalLabel').html("Edit Event");
                         $('#modalSave').html("Save Changes");
                         $('#modal_res').html(data);
                         $(function() {
                              $('.mdb-select').materialSelect();
                         });                         
                         CKEDITOR.replace('event_detail', {
                              filebrowserBrowseUrl : 'js/filemanagerck/dialog.php?type=2&editor=ckeditor&fldr=res',
                              filebrowserUploadUrl : 'js/filemanagerck/dialog.php?type=2&editor=ckeditor&fldr=res',
                              filebrowserImageBrowseUrl : 'js/filemanagerck/dialog.php?type=1&editor=ckeditor&fldr=res'
                         }) 
                         $('#modalSave').on("click", function() {
                              var ckdata = CKEDITOR.instances['event_detail'].getData();
                              var formdata = new FormData();
                              formdata.append('do_edit_event', '1');
                              formdata.append('e_id', eventid);
                              formdata.append('event_title', $('#event_title').val());
                              formdata.append('event_subtitle', $('#event_subtitle').val());
                              formdata.append('event_detail', ckdata);
                              formdata.append('event_image', $('input[type=file]')[0].files[0]);
                              formdata.append('event_color', $('#event_color').val());
                              formdata.append('event_font_color', $('#event_font_color').val());
                              formdata.append('event_status', $("input[name='event_status']:checked").val());
                              formdata.append('allow_signup', $("input[name='allow_signup']:checked").val());
                              formdata.append('event_start_date', $('#event_start_date').val());
                              formdata.append('event_end_date', $('#event_end_date').val());
                              formdata.append('event_start_time', $('#event_start_time').val());
                              formdata.append('event_end_time', $('#event_end_time').val());
                              formdata.append('event_pinned', $("input[name='event_pinned']:checked").val());                                                       
                              $.ajax({
                                   url: '<?php echo $gbl['site_url'] ?>/plg/calendars/ajax.php',
                                   type: 'POST',
                                   processData: false,
                                   contentType: false,                              
                                   data: formdata,
                                   success: function(data) {
                                        $('#modalSave').hide();
                                        $('#modalCancel').html('Close');                                   
                                        $('#modal_res').html(data);
                                        $('#calModal').on('hidden.bs.modal', function (e) {
                                             window.location.reload();
                                        })                                   
                                   }
                              })
                         })
                    }
               })
          }
          function deleteEvent(eventid)
          {
               if(confirm("Are you sure?")) {
                    $.ajax({
                         url: '<?php echo $gbl['site_url'] ?>/plg/calendars/ajax.php',
                         type: 'POST',
                         data: {
                              'do_delete_event': 1,
                              'e_id': eventid
                         },
                         success: function(data) {
                              $('#event-'+ eventid).html(data);
                         }
                    })     
               }     
          }
          function manageCalendar(calid)
          {
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/plg/calendars/ajax.php',
                    type: 'POST',
                    data: {
                         'manage_calendar': 1,
                         'c_id': calid
                    },
                    success: function(data) {                         
                         $('#calModal').modal('show');
                         $('#calModal').removeAttr('tabindex');                         
                         $('#calModalLabel').html("Manage Calendar");
                         $('#modalSave').html("Save Changes");
                         $('#modal_res').html(data);
                         $(function() {
                              $('.mdb-select').materialSelect();
                         });
                         $('#modalSave').on("click", function() {
                              $.ajax({
                                   url: '<?php echo $gbl['site_url'] ?>/plg/calendars/ajax.php',
                                   type: 'POST',
                                   data: {
                                        'do_save_calendar': 1,
                                        'c_id': $('#c_id').val(),
                                        'calendar_title': $('#calendar_title').val(),
                                        'calendar_subtitle': $('#calendar_subtitle').val(),
                                        'calendar_layout_type': $("input[name='calendar_layout_type']:checked").val(),
                                        'calendar_start_day': $("input[name='calendar_start_day']:checked").val(),
                                        'calendar_start_time': $('#calendar_start_time').val(),
                                        'calendar_end_time': $('#calendar_end_time').val(),
                                        'calendar_status': $("input[name='calendar_status']:checked").val()
                                   },
                                   success: function(data) {
                                        $('#modalSave').hide();
                                        $('#modalCancel').html('Close');                                   
                                        $('#modal_res').html(data);
                                        $('#calModal').on('hidden.bs.modal', function (e) {
                                             window.location.reload();
                                        })
                                   }
                              })
                         })                                                             
                    }
               })          
          }
          function newCalendar()
          {
               $.ajax({
                    url: '<?php echo $gbl['site_url'] ?>/plg/calendars/ajax.php',
                    type: 'POST',
                    data: {
                         'new_calendar': 1,
                    },
                    success: function(data) {
                         $('#calModal').modal('show');
                         $('#calModal').removeAttr('tabindex');                         
                         $('#calModalLabel').html("New Calendar");
                         $('#modalSave').html("Add Calendar");
                         $('#modal_res').html(data);
                         $('#modalSave').on("click", function() {
                              $.ajax({
                                   url: '<?php echo $gbl['site_url'] ?>/plg/calendars/ajax.php',
                                   type: 'POST',
                                   data: {
                                        'do_add_calendar': 1,
                                        'page_id': '<?php echo $_SESSION['page']['p_id'] ?>',
                                        'calendar_title': $('#calendar_title').val(),
                                        'calendar_subtitle': $('#calendar_subtitle').val(),
                                        'calendar_layout_type': $("input[name='calendar_layout_type']:checked").val(),
                                        'calendar_start_day': $("input[name='calendar_start_day']:checked").val(),
                                        'calendar_start_time': $('#calendar_start_time').val(),
                                        'calendar_end_time': $('#calendar_end_time').val(),
                                        'calendar_status': '1'
                                   },
                                   success: function(data) {
                                        $('#modalSave').hide();
                                        $('#modalCancel').html('Close');                                   
                                        $('#modal_res').html(data);
                                        $('#calModal').on('hidden.bs.modal', function (e) {
                                             window.location.reload();
                                        })                                   
                                   }
                              })
                         })                                       
                    }
               })          
          }
          </script>          
          <?php
     }
}
if(isset($_GET['eventid'])) {
     ?>
     <div class="row">
     <div class="col-12">
     <div class="card-body" id="calendar_data">
     
     </div>
     </div>
     </div>
     <script>
     $(function() {
          $.ajax({
               url: '<?php echo $gbl['site_url'] ?>/plg/calendars/ajax.php',
               type: 'POST',
               data: {
                    'view_details': 1,
                    'event_id': '<?php echo $_GET['eventid'] ?>'
               },
               success: function(data) {
                    $('#calendar_data').html(data);
               }
          })
     })
     </script>
     <?php
}
?>

