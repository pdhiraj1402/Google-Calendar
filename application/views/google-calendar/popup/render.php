
   
    <div class="card-hover marg-bot22" style="border:1px dashed #cecccc; background: #f8f8f8;padding: 6px;" id="google-cal1">
       
       <span><?php echo date('l, F d', strtotime($event['start_date'])); ?></span>

      <br>
       Google Meet Link: 
       <a href="<?php echo htmlspecialchars($event['meetLink']); ?>" target="_blank" rel="noopener noreferrer">
           Join Meeting
       </a>

       <!-- action="<?php echo base_url('GoogleCalendar/editEvent'); ?>" -->
       <!-- Update Event Form -->
       <form id="form"   method="post">
           <div style="max-width: 600px; margin-top: 20px;">
       
               <!-- Hidden field to pass event ID -->
               <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['id'] ?? ''); ?>">

               <!-- Form Group Wrapper -->
               <div style="display: flex; flex-direction: column; gap: 15px;">

                   <!-- Label-Input Pair -->
                   <div style="display: flex; align-items: center;">
                       <label for="summary" style="width: 150px;">Subject</label>
                       <input type="text" id="summary" name="summary" value="<?php echo htmlspecialchars($event['summary'] ?? 'No Title'); ?>" style="flex: 1; padding: 8px;">
                   </div>
                   
                   <div style="display: flex; align-items: center;">
                       <label for="start_date" style="width: 150px;">Start Date</label>
                       <input type="datetime-local" id="start_date" name="start_date" min="<?php echo date('Y-m-d\TH:i'); ?>" value="<?php echo date_format(date_create($event['start_date']), 'Y-m-d\TH:i'); ?>" style="flex: 1; padding: 8px;">
                   </div>

                   <div style="display: flex; align-items: center;">
                       <label for="end_date" style="width: 150px;">End Date</label>
                       <input 
                           type="datetime-local" 
                           id="end_date" 
                           name="end_date" 
                           value="<?php echo date_format(date_create($event['end_date']), 'Y-m-d\TH:i'); ?>" 
                           min="<?php echo date('Y-m-d\TH:i'); ?>" 
                           style="flex: 1; padding: 8px;">
                   </div>


                   <div style="display: flex; align-items: center;">
                       <label for="guests" style="width: 150px;">Guest Emails</label>
                       <textarea id="guests" name="guests" style="flex: 1; padding: 8px; height:150px;"><?php echo $event['attendeeEmails']; ?></textarea>
                   </div>

                   <div style="display: flex; align-items: center;">
                       <label for="description" style="width: 150px;">Description</label>
                       <textarea id="description" name="description" style="flex: 1; padding: 8px;"><?php echo htmlspecialchars($event['description'] ?? 'No Description'); ?></textarea>
                   </div>

                   <!-- Container for buttons -->
                   <div style="display: flex; justify-content: center; gap: 10px;">
                       <!-- Update Button -->

                       <a class="btn btn-primary" 
                           onclick="editEvent(); return false;">Update
                       </a>

                       <a class="btn btn-danger" 
                           onclick="deleteEvent('<?php echo $event['id']; ?>'); return false;">Delete
                       </a>

                   </div>
               </div>
           </div>
       </form>

   </div>

   <script>

       var baseurl = "<?php print site_url();?>/";

       function deleteEvent(eventId) 
       {
           if (confirm('Are you sure you want to delete this event?')) {
               $.ajax({
                   url: baseurl + '/GoogleCalendar/deleteEvent/' + eventId,
                   type: 'POST',
                   success: function(response) {
                       if (response.status === 'success') {
                           alert(response.message);
                           $('#google-cal-data').modal('hide'); 
                           // Reload the calendar view (replace with your active view logic)
                           let activeView = $('.dropdown-content .active').attr('id');
                           activeView = activeView ? activeView : 'btn-load-monthly';

                           let viewType = activeView.split('-')[2].toLowerCase(); // Extract view type
                           loadCalendarView(viewType); // Reload the calendar
                       } else {
                           alert('Error deleting event: ' + response.message);
                       }
                   },
                   error: function(xhr, status, error) {
                       console.error('Error deleting event:', error);
                       alert('An error occurred while deleting the event. Please try again.');
                   }
               });
           }
       }

       function editEvent() 
       {   
           $.ajax({
               url: baseurl + '/GoogleCalendar/editEvent',
               type: 'POST',
               data: $('#form').serialize(),
               dataType: 'JSON',
               success: function(response) {
                   if (response.status === 'success') 
                   {
                       $('#google-cal-data').modal('hide');
                       // Reload the calendar view (replace with your active view logic)
                       let activeView = $('.dropdown-content .active').attr('id');
                       activeView = activeView ? activeView : 'btn-load-monthly';

                       let viewType = activeView.split('-')[2].toLowerCase(); // Extract view type
                       loadCalendarView(viewType); // Reload the calendar
                   } 
                   else 
                   {
                       alert('Error editing event: ' + response.message);
                   }
               },
               error: function(xhr, status, error) {
                   alert(JSON.stringify(xhr));
                   alert('An error occurred while deleting the event. Please try again.');
               }
           });
       }

   </script>






