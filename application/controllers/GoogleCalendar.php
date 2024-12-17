<?php

/* * ***
 * Version: 1.0.0
 *
 * Description of Google Calendar Controller
 *
 * @author TechArise Team
 *
 * @email  info@techarise.com
 *
 * *** */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class GoogleCalendar extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //load library  
        $this->load->library('googleapi');
        $this->calendarapi = new Google_Service_Calendar($this->googleapi->client());

    }

    public function index() { 
        if (!$this->isLogin()) {
            $this->session->sess_destroy();    
            redirect('gc/auth/login');
        } else {
            $data = array();
            $data['metaDescription'] = 'Google Calendar';
            $data['metaKeywords'] = 'Google Calendar';
            $data['title'] = "Google Calendar - TechArise";
            $data['breadcrumbs'] = array('Google Calendar' => '#');

            $this->load->view('google-calendar/index', $data);
        }
    }
    
    // index method

    public function getCalendar() 
    { 
        if (!$this->isLogin()) {
            $this->session->sess_destroy();    
            redirect('gc/auth/login');
        } 
        else {     
            $data = array();
            $curentDate = date('Y-m-d', time());
    
            if ($this->input->post('page') !== null) {
                $malestr = str_replace("?", "", $this->input->post('page'));
                $navigation = explode('/', $malestr);
                $getYear = $navigation[1];
                $getMonth = $navigation[2];
                $start = date($getYear.'-'.$getMonth.'-01').' 00:00:00';
                $end = date($getYear.'-'.$getMonth.'-t').' 23:59:59';
            } else {
                $getYear = date('Y');
                $getMonth = date('m');
                $start = date('Y-m-01').' 00:00:00';
                $end = date('Y-m-t').' 23:59:59';
            }
    
            if ($this->input->post('year') !== null) {
                $getYear = $this->input->post('year');
                $start = date($getYear.'-m-01').' 00:00:00';
                $end = date($getYear.'-m-t').' 23:59:59';
            }
    
            if ($this->input->post('month') !== null) {
                $getMonth = $this->input->post('month');    
                $start = date($getYear.'-'.$getMonth.'-01').' 00:00:00';
                $end = date($getYear.'-'.$getMonth.'-t').' 23:59:59';
            }
    
            $already_selected_value = $getYear;
            $earliest_year = 1950;
            $startYear = '';
            $googleEventArr = array();
            $calendarData = array();
    
            // Fetch events for the month range
            $eventData = $this->getEvents('primary', $start, $end, 40);   
    
            foreach ($eventData as $element) {
                $day = ltrim(date('d', strtotime($element['start_date'])), '0');
                $eventSummary = htmlspecialchars(isset($element['summary']) ? $element['summary'] : '', ENT_QUOTES);
    
                // Check if there are already events for that day
                if (!isset($googleEventArr[$day])) {
                    // If no events exist yet, create a new entry
                    $googleEventArr[$day] = '<a style="cursor:pointer;" data-google_event="' . ltrim(date('Y-m-d', strtotime($element['start_date'])), '0') . 
                        '" data-event-id="' . $element['id'] . '" data-caltoggle="tooltip" data-placement="bottom" title="' . $eventSummary . '" class="small google-event event-summary" ' . 
                        'data-toggle="modal" data-target="#google-cal-data"><strong>' . $eventSummary . '</strong></a>'; 
                } else {
                    // If there are already events, append the new event
                    $googleEventArr[$day] .= '<br><a  style="cursor:pointer;" data-google_event="' . ltrim(date('Y-m-d', strtotime($element['start_date'])), '0') . 
                        '" data-event-id="' . $element['id'] . '" data-caltoggle="tooltip" data-placement="bottom" title="' . $eventSummary . '" class="small google-event event-summary" ' . 
                        'data-toggle="modal" data-target="#google-cal-data"><strong>' . $eventSummary . '</strong></a>';
                }
            }
    
            // Build the calendar data for display
            foreach (array_keys($googleEventArr) as $key) {
                $calendarData[$key] = '<div class="calendar-dot-area small" style="position: relative;z-index: 2;">' . 
                    (isset($googleEventArr[$key]) ? $googleEventArr[$key] : '') . '</div>';
            }
    
            $class = 'href="#" data-currentdate="' . $curentDate . '" class="add-gc-event pointer" data-toggle="modal" data-target="#gc-create-event" data-year="' . 
                    $getYear . '" data-month="' . $getMonth . '" data-days="{day}"';
    
            $startYear .= '<div class="col-md-3 col-sm-5 col-xs-7 col-md-offset-3 col-sm-offset-1"><div class="select-control"><select name="year" id="setYearVal" class="form-control">';
            foreach (range(date('Y') + 50, $earliest_year) as $x) {
                $startYear .= '<option value="' . $x . '"' . ($x == $already_selected_value ? ' selected="selected"' : '') . '>' . $x . '</option>';
            }
            $startYear .= '</select></div></div>';
    
            $startMonth = '<div class="col-md-3 col-sm-5 col-xs-7 col-md-offset-3 col-sm-offset-1"><div class="select-control"><select name="month" id="setMonthVal" class="form-control"><option value="0">Select Month</option>
                <option value="01" ' . ('01' == $getMonth ? ' selected="selected"' : '') . '>January</option>
                <option value="02" ' . ('02' == $getMonth ? ' selected="selected"' : '') . '>February</option>
                <option value="03" ' . ('03' == $getMonth ? ' selected="selected"' : '') . '>March</option>
                <option value="04" ' . ('04' == $getMonth ? ' selected="selected"' : '') . '>April</option>
                <option value="05" ' . ('05' == $getMonth ? ' selected="selected"' : '') . '>May</option>
                <option value="06" ' . ('06' == $getMonth ? ' selected="selected"' : '') . '>June</option>
                <option value="07" ' . ('07' == $getMonth ? ' selected="selected"' : '') . '>July</option>
                <option value="08" ' . ('08' == $getMonth ? ' selected="selected"' : '') . '>August</option>
                <option value="09" ' . ('09' == $getMonth ? ' selected="selected"' : '') . '>September</option>
                <option value="10" ' . ('10' == $getMonth ? ' selected="selected"' : '') . '>October</option>
                <option value="11" ' . ('11' == $getMonth ? ' selected="selected"' : '') . '>November</option>
                <option value="12" ' . ('12' == $getMonth ? ' selected="selected"' : '') . '>December</option>
            </select></div></div>';
    
            // CSS for the cursor style
            $css = '<style>
                .event-summary {
                    cursor: default; /* Change to desired cursor style */
                }
            </style>';
    
            $prefs['template'] = '
                {table_open}<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" class="calendar">{/table_open}
    
                {heading_row_start}<tr style="border:none;">{/heading_row_start}
    
                {heading_previous_cell}<th style="border:none;" class="padB"><a class="calnav" data-calvalue="{previous_url}" href="javascript:void(0);"><i class="fa fa-chevron-left fa-fw"></i></a></th>{/heading_previous_cell}
                {heading_title_cell}<th style="border:none;" colspan="{colspan}"><div class="row">' . $startMonth . '' . $startYear . '</div></th>{/heading_title_cell}
                {heading_next_cell}<th style="border:none;" class="padB"><a class="calnav" data-calvalue="{next_url}" href="javascript:void(0);"><i class="fa fa-chevron-right fa-fw"></i></a></th>{/heading_next_cell}
    
                {heading_row_end}</tr>{/heading_row_end}
    
                {week_row_start}<tr>{/week_row_start}
                {week_day_cell}<th>{week_day}</th>{/week_day_cell}
                {week_row_end}</tr>{/week_row_end}
    
                {cal_row_start}<tr>{/cal_row_start}
                {cal_cell_start}<td>{/cal_cell_start}
                {cal_cell_start_today}<td>{/cal_cell_start_today}
                {cal_cell_start_other}<td class="other-month">{/cal_cell_start_other}
    
                {cal_cell_content}<a ' . $class . '>{day}</a>{content}{/cal_cell_content}
                {cal_cell_content_today}<a ' . $class . '>{day}</a>{content}<div class="highlight"></div>{/cal_cell_content_today}
    
                {cal_cell_no_content}<a ' . $class . '>{day}</a>{/cal_cell_no_content}
                {cal_cell_no_content_today}<a ' . $class . '>{day}</a><div class="highlight"></div>{/cal_cell_no_content_today}
    
                {cal_cell_blank}&nbsp;{/cal_cell_blank}
    
                {cal_cell_other}{day}{/cal_cell_other}
    
                {cal_cell_end}</td>{/cal_cell_end}
                {cal_cell_end_today}</td>{/cal_cell_end_today}
                {cal_cell_end_other}</td>{/cal_cell_end_other}
                {cal_row_end}</tr>{/cal_row_end}
    
                {table_close}</table>{/table_close}';
            $prefs['start_day'] = 'monday';
            $prefs['day_type'] = 'short';
            $prefs['show_next_prev'] = TRUE;
            $prefs['next_prev_url'] = '?';
    
            // Generate the calendar with populated data
            $this->load->library('calendar', $prefs);
            $data['calendar'] = $this->calendar->generate($getYear, $getMonth, $calendarData);
    
            // Echo the calendar and CSS
            echo $css . $data['calendar'];
        }
    }

    // login method
    public function login() {  
        if ($this->session->userdata('is_authenticate_user') == TRUE) {
                redirect('gc/auth/index');
        } else {        
            $data = array();
            $data['metaDescription'] = 'Google Plus Login';
            $data['metaKeywords'] = 'Google Plus Login';
            $data['title'] = "Google Plus Login - Demo";
            $data['breadcrumbs'] = array('Google Plus Login' => '#');
            $data['loginUrl'] = $this->loginUrl();
            $this->load->view('google-calendar/login', $data);
        }
    }

    // oauth method
    public function oauth() {
        $code = $this->input->get('code', true);
        $this->oauthLogin($code);
        redirect(base_url(), 'refresh');
    }
    // check login session
    public function isLogin() {
        $token = $this->session->userdata('google_calendar_access_token');
        if ($token) {
            $this->googleapi->client->setAccessToken($token);
        }
        if ($this->googleapi->isAccessTokenExpired()) {
            return false;
        }
        return $token;
    }

    public function loginUrl() {
        return $this->googleapi->loginUrl();
    }

    // oauthLogin
    public function oauthLogin($code) {
        $login = $this->googleapi->client->authenticate($code);
        if ($login) {
            $token = $this->googleapi->client->getAccessToken();
            $this->session->set_userdata('google_calendar_access_token', $token);
            $this->session->set_userdata('is_authenticate_user', TRUE);
            return true;
        }
    }

    // get User Info
    public function getUserInfo() {
        return $this->googleapi->getUser();
    }
    
    // get Events
    public function getEvents($calendarId = 'primary', $timeMin = false, $timeMax = false, $maxResults = 40) 
    {

        if (!$timeMin) {
            $timeMin = date("c", strtotime(date('Y-m-d ') . ' 00:00:00'));
        } else {
            $timeMin = date("c", strtotime($timeMin));
        }
    
        if (!$timeMax) {
            $timeMax = date("c", strtotime(date('Y-m-d ') . ' 23:59:59'));
        } else {
            $timeMax = date("c", strtotime($timeMax));
        }
    
        $optParams = array(
            'maxResults' => $maxResults,
            'orderBy' => 'startTime',
            'singleEvents' => true,
            'timeMin' => $timeMin,
            'timeMax' => $timeMax,
            'timeZone' => 'Asia/Kolkata',
        );
    
        $results = $this->calendarapi->events->listEvents($calendarId, $optParams);
        
        $data = array();
        foreach ($results->getItems() as $item) {
            if (!empty($item->getStart()->date) && !empty($item->getEnd()->date)) {
                $startDate = date('d-m-Y H:i', strtotime($item->getStart()->date));
                $endDate = date('d-m-Y H:i', strtotime($item->getEnd()->date));
            } else {
                $startDate = date('d-m-Y H:i', strtotime($item->getStart()->dateTime));
                $endDate = date('d-m-Y H:i', strtotime($item->getEnd()->dateTime));
            }
            
            $created = date('d-m-Y H:i', strtotime($item->getCreated()));
            $updated = date('d-m-Y H:i', strtotime($item->getUpdated()));
    
            // Get attendees
            $attendees = [];
            if ($item->getAttendees()) {
                foreach ($item->getAttendees() as $attendee) {
                    $attendees[] = [
                        'email' => $attendee->getEmail(),
                        'displayName' => $attendee->getDisplayName(),
                        'responseStatus' => $attendee->getResponseStatus(),
                    ];
                }
            }
    
            // Get Google Meet link
            $meetLink = '';
            if ($item->getConferenceData() && $item->getConferenceData()->getEntryPoints()) {
                foreach ($item->getConferenceData()->getEntryPoints() as $entryPoint) {
                    if ($entryPoint->getEntryPointType() === 'video') {
                        $meetLink = $entryPoint->getUri();
                        break; // Get the first video entry point
                    }
                }
            }
    
            array_push(
                $data,
                array(
                    'id' => $item->getId(),
                    'summary' => trim($item->getSummary()),
                    'description' => trim($item->getDescription()),
                    'creator' => $item->getCreator()->getEmail(),
                    'organizer' => $item->getOrganizer()->getEmail(),
                    'creatorDisplayName' => $item->getCreator()->getDisplayName(),
                    'organizerDisplayName' => $item->getOrganizer()->getDisplayName(),
                    'created' => $created,
                    'updated' => $updated,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => $item->getStatus(),
                    'attendees' => $attendees, // Add attendees field
                    'meetLink' => $meetLink, // Add Google Meet link
                )
            );
        }
        return $data;
    }

    public function getEventById($eventId, $calendarId = 'primary')
    {
        try {
            // Use the Google Calendar API to fetch event details
            $event = $this->calendarapi->events->get($calendarId, $eventId);

            // Extract details from the event
            $startDate = !empty($event->getStart()->dateTime) 
                ? date('d-m-Y H:i', strtotime($event->getStart()->dateTime)) 
                : date('d-m-Y', strtotime($event->getStart()->date));

            $endDate = !empty($event->getEnd()->dateTime) 
                ? date('d-m-Y H:i', strtotime($event->getEnd()->dateTime)) 
                : date('d-m-Y', strtotime($event->getEnd()->date));

            $created = date('d-m-Y H:i', strtotime($event->getCreated()));
            $updated = date('d-m-Y H:i', strtotime($event->getUpdated()));

            // Get attendees
            $attendees = [];
            if ($event->getAttendees()) {
                foreach ($event->getAttendees() as $attendee) {
                    $attendees[] = [
                        'email' => $attendee->getEmail(),
                        'displayName' => $attendee->getDisplayName(),
                        'responseStatus' => $attendee->getResponseStatus(),
                    ];
                }
            }

            // Get Google Meet link
            $meetLink = '';
            if ($event->getConferenceData() && $event->getConferenceData()->getEntryPoints()) {
                foreach ($event->getConferenceData()->getEntryPoints() as $entryPoint) {
                    if ($entryPoint->getEntryPointType() === 'video') {
                        $meetLink = $entryPoint->getUri();
                        break;
                    }
                }
            }

            return array(
                    'id' => $event->getId(),
                    'summary' => trim($event->getSummary()),
                    'description' => trim($event->getDescription()),
                    'creator' => $event->getCreator()->getEmail(),
                    'organizer' => $event->getOrganizer()->getEmail(),
                    'creatorDisplayName' => $event->getCreator()->getDisplayName(),
                    'organizerDisplayName' => $event->getOrganizer()->getDisplayName(),
                    'created' => $created,
                    'updated' => $updated,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => $event->getStatus(),
                    'attendees' => $attendees, // Add attendees field
                    'meetLink' => $meetLink, // Add Google Meet link
            );
            

        } catch (Exception $e) {
            // Handle errors
            log_message('error', 'Google Calendar API error: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    // add google calendar event
    public function addEvent() 
    {
        if (!$this->isLogin()) 
        {
            $this->session->sess_destroy();    
            redirect(base_url(), 'refresh');
        } 
        else 
        {
            $json = array();
            $calendarId = 'primary';
            $post = $this->input->post();

            // Validate required inputs
            if (!isset($post['summary']) || empty(trim($post['summary']))) {
                $json['error']['summary'] = 'Please enter summary.';
            }
            if (!isset($post['startDate']) || empty(trim($post['startDate']))) {
                $json['error']['startdate'] = 'Please enter start date.';
            }
            if (!isset($post['startTime']) || empty(trim($post['startTime']))) {
                $json['error']['starttime'] = 'Please enter start time.';
            }
            if (!isset($post['endDate']) || empty(trim($post['endDate']))) {
                $json['error']['enddate'] = 'Please enter end date.';
            }
            if (!isset($post['endTime']) || empty(trim($post['endTime']))) {
                $json['error']['endtime'] = 'Please enter end time.';
            }
            if (!isset($post['description']) || empty(trim($post['description']))) {
                $json['error']['description'] = 'Please enter description.';
            }

            // Process guest emails
            $guests = [];
            if (isset($post['guests']) && !empty($post['guests'])) {
                $guestsInput = $post['guests']; // Input from the textarea
                $guestEmails = explode(',', $guestsInput); // Split by commas
                $guestEmails = array_map('trim', $guestEmails); // Trim whitespace
                
                // Validate and format emails for attendees
                foreach ($guestEmails as $email) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $guests[] = ['email' => $email];
                    }
                }
            }

            // Proceed if no validation errors
            if (empty($json['error'])) {
                $event = array(
                    'summary'     => trim($post['summary']),
                    'start'       => $post['startDate'] . 'T' . $post['startTime'] . ':00+05:30',
                    'end'         => $post['endDate'] . 'T' . $post['endTime'] . ':00+05:30',
                    'description' => trim($post['description']),
                    'attendees'   => $guests, // List of guest emails
                );

                // Call actionEvent to insert event into Google Calendar
                $data = $this->actionEvent($calendarId, $event);
                
                if ($data) {
                    $json['message'] = ($data->status == 'confirmed') ? 1 : 0;
                } else {
                    $json['message'] = 0;
                }
            }

            // Output response in JSON format
            $this->output->set_header('Content-Type: application/json');
            echo json_encode($json);
        }
    }
    // actionEvent

    public function actionEvent($calendarId, $data) 
    {
        $event = new Google_Service_Calendar_Event(
            array(
                'summary'     => $data['summary'],
                'description' => $data['description'],
                'start'       => array(
                    'dateTime' => $data['start'],
                    'timeZone' => 'Asia/Kolkata',
                ),
                'end'         => array(
                    'dateTime' => $data['end'],
                    'timeZone' => 'Asia/Kolkata',
                ),
                'attendees'   => $data['attendees'], // Pass the attendees array as is
                'conferenceData' => array(
                    'createRequest' => array(
                        'requestId' => uniqid(),
                        'conferenceSolutionKey' => array(
                            'type' => 'hangoutsMeet'
                        ),
                    ),
                ),
                'status' => 'confirmed',
            )
        );

        // Enable conference data (Google Meet link)
        $event->setConferenceData($event->conferenceData);

        return $this->calendarapi->events->insert($calendarId, $event, array(
            'conferenceDataVersion' => 1,
            'sendUpdates' => 'all'
        ));
    }

    // get event list
    public function viewEvent() 
    {        
        $json = array();
        if (!$this->isLogin()) {
            $this->session->sess_destroy();    
            redirect(base_url(), 'refresh');
        } 
        else 
        {            
            $eventid = $this->input->post('eventid');
            $eventData = $this->getEventById($eventid, 'primary'); 

            if (isset($eventData['attendees']) && is_array($eventData['attendees'])) {
                // Extract and concatenate attendee emails into a comma-separated string
                $emails = array_column($eventData['attendees'], 'email');
                $eventData['attendeeEmails'] = implode(", ", $emails);
            } else {
                $eventData['attendeeEmails'] = 'No Email';
            }

             
              
            $json['event'] = $eventData;

            $this->output->set_header('Content-Type: application/json');
            $this->load->view('google-calendar/popup/render', $json);
        }

    }

    // render Event Form
    public function renderEventForm() {        
        $json = array();
        if (!$this->isLogin()) {
            $this->session->sess_destroy();    
            redirect(base_url(), 'refresh');
        } else { 
            $datetime = $this->input->post('datetime');                   
            $json['datetime'] = $datetime;
            $this->output->set_header('Content-Type: application/json');
            $this->load->view('google-calendar/popup/renderadd', $json);
        }

    }

    //logout method
    public function logout() {
        $this->googleapi->revokeToken();
        $this->session->unset_userdata('is_authenticate_user');
        $this->session->sess_destroy();
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
        redirect('gc/auth/login');
    }      
    
    //  new functions 

    public function getCalendarWeekly() 
    {
        if (!$this->isLogin()) {
            $this->session->sess_destroy();    
            redirect('gc/auth/login');
        } 
        else 
        {      
            // Determine the selected date
            $selectedDate = $this->input->post('date');

            // Calculate the start and end of the week (Monday to Sunday)
            $startOfWeek = date('Y-m-d', strtotime('monday this week', strtotime($selectedDate)));
            $endOfWeek = date('Y-m-d', strtotime('sunday this week', strtotime($selectedDate)));

            // Fetch events for the week
            $eventData = $this->getEvents('primary', $startOfWeek . '00:00:00', $endOfWeek . ' 23:59:59', 40);

            // Initialize the array to hold events for each day of the week (Monday to Sunday)
            $weeklyEvents = array_fill_keys([ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], []);

            // Populate the events into the weeklyEvents array
            foreach ($eventData as $event) {
                $dayOfWeek = date('l', strtotime($event['start_date']));
                $weeklyEvents[$dayOfWeek][] = $event;
            }

            // Start building the HTML output
            $html = '<h1>Week View: ' . date('F j', strtotime($startOfWeek)) . ' - ' . date('F j, Y', strtotime($endOfWeek)) . '</h1>';
            $html .= '<div class="weekly-calendar">';

            // Header Row: Days of the Week (ensure order from Monday to Sunday)
            $html .= '<div class="header-row"><div class="time-label">All-Day</div>';
            
            // Display the days of the week correctly ordered from Monday to Sunday
            foreach (array_keys($weeklyEvents) as $day) {
                $html .= '<div class="day-header">' . date('D d/m', strtotime($startOfWeek . ' + ' . array_search($day, array_keys($weeklyEvents)) . ' days')) . '</div>';
            }
            $html .= '</div>';

            // Generate the Time and Events Grid
            for ($hour = 6; $hour <= 30; $hour++) {
                $html .= '<div class="hour-row">';
                $html .= '<div class="time-label">' . date("ga", strtotime("$hour:00")) . '</div>';

                foreach ($weeklyEvents as $day => $events) {
                    $html .= '<div class="event-cell">';

                    foreach ($events as $event) {
                        $eventStartHour = date('G', strtotime($event['start_date']));
                        $start_date = date_format(date_create($event['start_date']), 'Y-m-d\TH:i');
                        $end_date = date_format(date_create($event['end_date']), 'Y-m-d\TH:i');

                        if ($hour == $eventStartHour) {
                            // $html .= '<div class="google-event" data-event-id="' . $event['id'] . '" onclick="openEditModal(\'' . $event['id'] . '\', \'' . htmlspecialchars($event['summary'], ENT_QUOTES) . '\', \'' . htmlspecialchars($event['description'], ENT_QUOTES) . '\', \'' . htmlspecialchars($event['attendeeEmails'] ?? '', ENT_QUOTES) . '\', \'' . $start_date . '\', \'' . $end_date . '\', \'' . htmlspecialchars($event['cpscstatus'] ?? '', ENT_QUOTES) . '\', \'' . htmlspecialchars($event['CManager'] ?? '', ENT_QUOTES) . '\')">';
                            $html .= '<div class="google-event" data-google_event="' . ltrim(date('Y-m-d', strtotime($event['start_date'])), '0') . '" data-event-id="' . $event['id'] . '"
                                         data-toggle="modal" data-target="#google-cal-data">';
                            $html .= '<strong>' . htmlspecialchars($event['summary'], ENT_QUOTES) . '</strong>';
                            $html .= '</div>';                           
                        }                     
                    }

                    $html .= '</div>'; // Close event cell
                }

                $html .= '</div>'; // Close hour row
            }

            $html .= '</div>'; // Close weekly-calendar div
            // Inline CSS and JavaScript
            $html .= '<style>
                .weekly-calendar { display: grid; grid-template-columns: 80px repeat(7, 1fr); background-color: #f4f4f4; font-family: Arial, sans-serif; border: 1px solid #ccc; border-right: none; }
                .header-row, .hour-row { display: contents; }
                .day-header { text-align: center; font-weight: bold; padding: 10px; background-color: #f0f0f0; border-right: 1px solid #ccc; border-bottom: 1px solid #ddd; }
                .time-label { padding: 10px; text-align: right; border-bottom: 1px solid #ddd; font-weight: bold; background-color: #f0f0f0; border-right: 1px solid #ccc; }
                .event-cell { position: relative; min-height: 60px; border-bottom: 1px dashed #e0e0e0; border-right: 1px solid #ddd; overflow: hidden; }
                .google-event { cursor: pointer; position: relative; width: 95%; color:white; padding: 5px; margin: 2px auto; font-size: 0.8em; background-color: #007bff; border: 1px solid #0056b3;  border-radius: 3px;  }
            </style>';

            echo $html;
        }
    }

    public function getCalendarDaily()
    { 
        if (!$this->isLogin()) 
        {
            $this->session->sess_destroy();    
            redirect('gc/auth/login');
        } 
        else
        {     
            $currentDate = date('Y-m-d', time());
            
            // Determine the selected date
            $selectedDate = $this->input->post('date') ?? $currentDate;

            // Fetch events for the selected date
            $startOfDay = $selectedDate . ' 00:00:00';
            $endOfDay = $selectedDate . ' 23:59:59';
            $eventData = $this->getEvents('primary', $startOfDay, $endOfDay, 40);

            // Organize events by hour
            $hourlyEvents = array_fill(0, 24, []);
            foreach ($eventData as $event) {
                $eventStartHour = (int) date('G', strtotime($event['start_date']));
                $hourlyEvents[$eventStartHour][] = $event;
            }

            // Start building the HTML output
            $html = '<h1>Events for ' . date('F j, Y', strtotime($selectedDate)) . '</h1>';
            $html .= '<div class="hourly-calendar">';

            // Generate the hourly slots with events
            for ($hour = 0; $hour < 24; $hour++) {
                $html .= '<div class="hour-slot">';
                $html .= '<div class="hour-label">' . sprintf('%02d:00', $hour) . '</div>';
                $html .= '<div class="events">';
                
                if (!empty($hourlyEvents[$hour])) {
                    foreach ($hourlyEvents[$hour] as $event) {

                        $eventStartHour = date('G', strtotime($event['start_date']));
                        $start_date = date_format(date_create($event['start_date']), 'Y-m-d\TH:i');
                        $end_date = date_format(date_create($event['end_date']), 'Y-m-d\TH:i');

                        $html .= '<div class="google-event" data-google_event="' . ltrim(date('Y-m-d', strtotime($event['start_date'])), '0') . '" data-event-id="' . $event['id'] . '"
                                     data-toggle="modal" data-target="#google-cal-data">';
                        $html .= '<strong>' . htmlspecialchars($event['summary'], ENT_QUOTES) . '</strong>';
                        $html .= '</div>'; 
                    }
                } 

                $html .= '</div>'; // Close events div
                $html .= '</div>'; // Close hour-slot div
            }

            $html .= '</div>'; // Close hourly-calendar div


            // Inline CSS and JavaScript
            $html .= '<style>
                
                /* Hourly Calendar Styles */
                .hourly-calendar { display: grid; flex-direction: column; border: 1px solid #ccc; }
                .hour-slot { display: flex; align-items: stretch; border-bottom: 1px solid #ddd;  }
                .hour-label { width: 80px; font-weight: bold; text-align: right; padding: 10px;  border-right: 1px solid #ccc; display: flex; align-items: center;}
                .events { flex-grow: 1; font-size: 0.8em; padding: 5px;  }
                .google-event { margin-bottom: 5px; cursor: pointer; color:white; padding: 5px; background-color: #007bff; border: 1px solid #0056b3;  border-radius: 3px;  }
            </style>';

            // Return the HTML response
            $this->output->set_content_type('text/html')->set_output($html);
        }
    }

    public function editEvent()
    {
        if (!$this->isLogin()) 
        {
            // If the user is not logged in, destroy the session and redirect to login page
            $this->session->sess_destroy();
            redirect(base_url(), 'refresh');
        } 
        else 
        {
            // Retrieve the event details from the POST request 
                 
            $eventId = $this->input->post('event_id');
            $summary = $this->input->post('summary');
            $description = $this->input->post('description');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $guests = $this->input->post('guests'); // Assumes comma-separated guest emails

            $startDateTime = new DateTime($start_date);
            $endDateTime = new DateTime($end_date);

            // Validate the event ID and other required fields
            if ($eventId && $summary && $start_date && $end_date) {
                $calendarId = 'primary'; // Default calendar ID (could be dynamic)

                // Create a new Google_Service_Calendar_Event object
                $event = new Google_Service_Calendar_Event();
                $event->setSummary($summary);
                $event->setDescription($description);
                $event->setStart(new Google_Service_Calendar_EventDateTime(array(
                    'dateTime' => date('c', strtotime($start_date)), // Convert to correct datetime format
                    'timeZone' => 'Asia/Kolkata'
                )));
                $event->setEnd(new Google_Service_Calendar_EventDateTime(array(
                    'dateTime' => date('c', strtotime($end_date)),
                    'timeZone' => 'Asia/Kolkata'
                )));

                // Add guests if provided
                $guestEmails = array_map('trim', explode(',', $guests)); // Convert comma-separated string to array
                $attendees = [];
                $guestEmails = array_unique($guestEmails);

                // Create attendee structure for the Google Calendar API
                foreach ($guestEmails as $email) {
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $attendees[] = new Google_Service_Calendar_EventAttendee(array('email' => $email));
                    }
                }
                $event->setAttendees($attendees);

                try 
                {
                    // Use the Calendar API to update the event and send email notifications to all attendees
                    $updatedEvent = $this->calendarapi->events->update($calendarId, $eventId, $event, array(
                        'sendUpdates' => 'all' // Send notifications to all attendees
                    ));
                    
                    $response = array('status' => 'success', 'message' => 'Event updated successfully.');
                    echo json_encode($response);          
                } 
                catch (Exception $e) 
                {
                    // Handle API errors
                    $response = array('status' => 'error', 'message' => 'Error updating event: ' . $e->getMessage());
                    $this->output->set_content_type('application/json');
                    echo json_encode($response);
                }
            } 
            else {
                // If required fields are missing
                $response = array('status' => 'error', 'message' => 'Required fields are missing.');
                $this->output->set_content_type('application/json');
                echo json_encode($response);
            }
        }
    }

    public function deleteEvent( $eventId) 
    {
        if (!$this->isLogin()) 
        {
            $this->session->sess_destroy();    
            // redirect(base_url(), 'refresh');
            $response = array('status' => 'error', 'message' => 'User not logged in.');
            $this->output->set_header('Content-Type: application/json');
            echo json_encode($response);
            return;

        } 
        else 
        {
            if ($eventId) 
            {
                $calendarId = 'primary';
                try {
                    $this->calendarapi->events->delete($calendarId, $eventId, array(
                        'sendUpdates' => 'all' ));
                    $response = array('status' => 'success', 'message' => 'Event deleted successfully.');
                    // redirect(base_url('index.php/gc/auth/index'), 'refresh');
                } catch (Exception $e) {
                    $response = array('status' => 'error', 'message' => 'Error deleting event: ' . $e->getMessage());
                }
            } else {
                $response = array('status' => 'error', 'message' => 'No event ID provided.');
            }

            $this->output->set_header('Content-Type: application/json');
            echo json_encode($response);
        }
    }


}

