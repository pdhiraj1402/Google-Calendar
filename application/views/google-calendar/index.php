<?php $this->load->view('templates/header'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

  <style>

    /* Container for buttons positioned at the top-left */
    .calendar-container {
      display: flex;
      flex-direction: column;
      align-items: flex-start; 
    }

    /* Button container styling */
    .calendar-nav {
      display: flex;
      gap: 15px; /* Space between main button groups */
    }

    /* Styling for the button group */
    .btn-group button,
    .goto-btn {
      background-color: #333;
      color: white;
      padding: 10px 15px;
      border: none;
      /* border-radius: 10px; */
      cursor: pointer;
      margin-left: 10px;
    }

    .btn-group button:hover,
    .goto-btn:hover {
      background-color: #555;
    }

    .dropdown button{
      background-color: #333;
      color: white;
      padding: 5px 15px;
      border: none;
      cursor: pointer;
      margin-right:10px;
    }

    .dropdown button:hover {
      background-color: #555;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: white;
      min-width: 100px;
      z-index: 1;
    }

    .dropdown-content button {
      color: blue;
      padding: 5px 5px;
      text-align: left;
      background-color: white;
      border: none;
      width: 100%;
      cursor: pointer;
    }

    .dropdown-content button:hover {
      background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
      display: block;
    }

    /* Styling for event container below buttons */
    #event-calendar {
      width: 100%;
      max-width: 1000px; /* Center the calendar */
      margin: 10px auto; /* Center the calendar and add top margin */
    }
    
  </style>
  
</head>
<body>

  <section class="showcase">
    <div class="container">
      <div class="pb-2 mt-4 mb-2 border-bottom">
        <h2 style="text-align:center;">Google Calendar</h2>
        <!-- Button Navigation at the Top-Left -->
        <div class="calendar-container">
          <div class="calendar-nav">
            <div class="btn-group">

              <!-- Dropdown for calendar views -->

              <a href="javascript:void(0);" data-toggle="modal" data-target="#gc-create-event" data-year="<?php print date('Y', time()); ?>" 
                  data-month="<?php print date('m', time()); ?>" data-days="<?php print date('d', time()); ?>"  class="add-gc-event btn btn-sm btn-primary">Create Event</a>

              <div class="dropdown">
                <button class="view-btn">View</button>
                <div class="dropdown-content">
                  <button id="btn-load-weekly">Weekly</button>
                  <button id="btn-load-daily">Daily</button>
                  <button id="btn-load-monthly" class="active">Monthly</button>
                </div>
              </div>

              <a href="<?php echo base_url('GoogleCalendar/logout'); ?> " class="btn btn-sm btn-danger">log out</a>

            </div>
            
          </div>
          <br>
          <input style="width:200px;" type="date" id="date-input" class="form-control" />
          <span id="success-msg"></span>       
          <!-- Calendar positioned below the buttons -->
          <div id="event-calendar">
            <div class="text-center"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div>
          </div> 

        </div>
      </div>
    </div>
  </section>

  <?php $this->load->view('google-calendar/popup/event'); ?>   
  <?php $this->load->view('google-calendar/popup/create'); ?>      
  <?php $this->load->view('templates/footer'); ?>   

  <!-- JavaScript to handle view change -->
  <script>

     // Function to load calendar view (daily, weekly, or monthly)
      function loadCalendarView(viewType) {
          let selectedDate = $('#date-input').val(); // Get the selected date

          let url;
          if (viewType === 'daily') {
              url = baseurl + 'GoogleCalendar/getCalendarDaily';
              $('#date-input').show();
          } else if (viewType === 'weekly') {
              url = baseurl + 'GoogleCalendar/getCalendarWeekly';
              $('#date-input').show();
          } else if (viewType === 'monthly') {                
              url = baseurl + 'GoogleCalendar/getCalendar';
              $('#date-input').hide();
          }

          $.ajax({
              url: url, // Adjust the URL based on the view type
              type: 'POST',
              data: { date: selectedDate }, // Send the selected date to the controller
              success: function(response) {
                  $('#event-calendar').html(response); // Replace the calendar with the events for the selected view
              },
              error: function(xhr, status, error) {
                  console.error('Error fetching events:', error);
                  $('#event-calendar').html('<p>Error loading events.</p>');
              }
          });
      }

      $(document).ready(function() {
          $('#date-input').val(new Date().toISOString().split('T')[0]);
          $('#date-input').hide();

          // Bind click events for each button in the dropdown
          $('#btn-load-daily').on('click', function() {
              loadCalendarView('daily');
          });

          $('#btn-load-weekly').on('click', function() {
              loadCalendarView('weekly');
          });

          $('#btn-load-monthly').on('click', function() {
              loadCalendarView('monthly');
          });

          // Bind the loadCalendarView function to the date picker change event
          $('#date-input').on('change', function() {
              // Check the active view and load it based on the current selection
              let activeView = $('.dropdown-content .active').attr('id');
              if (activeView) {
                  let viewType = activeView.split('-')[2].toLowerCase(); // Get view type (daily, weekly, or monthly)
                  loadCalendarView(viewType);
              }
          });

          // Optionally, add active class to the selected button in the dropdown
          $('.dropdown-content button').on('click', function() {
              // Remove active class from all buttons
              $('.dropdown-content button').removeClass('active');

              // Add active class to the clicked button
              $(this).addClass('active');
          });
      });
    
  </script>
</body>
</html>
