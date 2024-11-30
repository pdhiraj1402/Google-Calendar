<div class="modal fade" id="gc-create-event" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">        
        <h4 class="modal-title">Add Event On Google Calendar</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form name="gc_event_frm" class="gc-event-frm" id="gc-event-frm">
            <div class="form-group">
              <label for="inputAddress">Subject</label>
              <input type="text" name="summary" class="form-control summary input-gcevent-summary">
            </div>

            <div class="form-row">
              <div class="form-group col-md-8">
                  <label for="inputAddress2">Start Date </label>
                  <input type="date" name="startDate" id="startDate" class="form-control start-date input-gcevent-startdate">
                  <script>
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0');
                    var yyyy = today.getFullYear();

                    today = yyyy + '-' + mm + '-' + dd;
                    
                    // Get the input element by its ID
                    var startDateInput = document.getElementById('startDate');
                    if (startDateInput) {
                        startDateInput.min = today; // Set the min attribute
                    }
               
                    $('#startDate').attr('min',today);
                </script>
              </div>

              <div class="form-group col-md-4">
                <label for="inputAddress2">Start Time</label>
                <input type="time" name="startTime" class="form-control start-time input-gcevent-starttime" value="<?php print date("H:i"); ?>">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-8">
                <label for="inputAddress2">End Date</label>
                <input type="date" name="endDate" id="endDate" class="form-control end-date input-gcevent-enddate">
                <script>
                    var today = new Date();
                    var dd = String(today.getDate()).padStart(2, '0');
                    var mm = String(today.getMonth() + 1).padStart(2, '0');
                    var yyyy = today.getFullYear();

                    today = yyyy + '-' + mm + '-' + dd;
                    
                    // Get the input element by its ID
                    var endDateInput = document.getElementById('endDate');
                    if (endDateInput) {
                        endDateInput.min = today; // Set the min attribute
                    }

                    $('#endDate').attr('min',today);
                </script>
              </div>

              <div class="form-group col-md-4">
                <label for="inputAddress2">End Time</label>
                <input type="time" name="endTime" class="form-control end-time input-gcevent-endtime" value="<?php print date('H:i'); ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="guests" style="width: 150px;">Guest Emails</label>
              <textarea name="guests" class="form-control input-gcevent-description" rows="3"></textarea>
            </div>

            <div class="form-group">
              <label for="inputAddress">Description</label>
              <textarea name="description" class="form-control input-gcevent-description" rows="3"></textarea>
            </div>
            <button type="button" name="save_gc_event" id="save-gc-event" class="btn btn-primary"> Save Event</button>
        </form>
    
    </div>
      </div>
 
    </div>    
  </div>


  