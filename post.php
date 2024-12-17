

Implement Calendar in CodeIgniter with jQuery AJAX

codeIgniter-calendar-ajax

codeigniter-calendar

In this tutorial, We share how to Implement Calendar in CodeIgniter with jQuery AJAX. A calendar is a system of organizing task, meeting and event etc. CodeIgniter Calendar class enables you to dynamically create calendars. Your calendars can be formatted through the use of a calendar template, allowing 100% control over every aspect of its design. In addition, you can pass data to your calendar cells.


Before started to implement the CodeIgniter Calendar, look files structure:
<ul class="tree-structure"> 
  <li><i class="folder-color fa fa-folder"></i> codeIgniter-calendar
  <ul>
    <li><i class="folder-color fa fa-folder"></i> application
      <ul>
        <li><i class="folder-color fa fa-folder"></i> config
          <ul>
            <li><i class="text-muted far fa-file"></i> constants.php</li>
            <li><i class="text-muted far fa-file"></i> routes.php</li>
          </ul>
      </ul>
      <ul>
        <li><i class="folder-color fa fa-folder"></i> controllers
          <ul>
            <li><i class="text-muted far fa-file"></i> Calendar.php</li>
          </ul>
        </li>       
        <li><i class="folder-color fa fa-folder"></i> views
          <ul>
            <li><i class="folder-color fa fa-folder"></i> calendar
             <ul>
              <li><i class="text-muted far fa-file"></i> index.php</li>
            </ul>              
            </li>            
            <li><i class="folder-color fa fa-folder"></i> templates
              <ul>
               <li><i class="text-muted far fa-file"></i> header.php</li>
               <li><i class="text-muted far fa-file"></i> footer.php</li>
            </ul>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    <li><i class="folder-color fa fa-folder"></i> system</li>
    <li><i class="text-muted far fa-file"></i> index.php</li>
    <li><i class="folder-color fa fa-folder"></i> assets
      <ul>
        <li><i class="folder-color fa fa-folder"></i> css</li>
          <ul>
            <li><i class="text-muted far fa-file"></i> style.css</li>
          </ul>
          <li><i class="folder-color fa fa-folder"></i> js</li>
          <ul>
            <li><i class="text-muted far fa-file"></i> common.js</li>
          </ul>
      </ul>      
    </li>
  </ul>
</li>
</ul>



<br><<strong>Initializing the Class</strong><br>
Like most other classes in CodeIgniter, the Calendar class is initialized in your controller using the $this->load->library function:
<pre class="lang-html">
<?php
	// load calendar library
  	$this->load->library('calendar');
?>
</pre>

<br><strong>Once loaded, the Calendar object will be available using:</strong>
<pre class="lang-html">
<?php
	// load calendar library
  	$this->calendar
?>
</pre>

<br><strong>Displaying a Calendar</strong> 
<br>Here is a very simple example showing how you can display a calendar:
<pre class="lang-html">
	<?php
		$this->load->library('calendar');
		echo $this->calendar->generate();
	?>
</pre>

<strong>Step 1: Create a controller file</strong><br>
Create a controller file named <code>CICalendar.php</code> inside "application/controllers" folder. 

<pre class="lang-html">
<?php

/* * ***
 * Version: 1.0.0
 *
 * Description of My Calendar Controller
 *
 * @author CodersMag Team
 *
 * @email  info@codersmag.com
 *
 * *** */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CICalendar extends CI_Controller {

    public function __construct() {
        parent::__construct();

    }
    // index method 
    public function index() { 
        $data = array();
        $data['metaDescription'] = 'Calendar';
        $data['metaKeywords'] = 'Calendar';
        $data['title'] = "Calendar - CodersMag";
        $data['breadcrumbs'] = array('Calendar' => '#');
        $this->load->view('calendar/index', $data);
    }
    // getCalendar method
    public function getCalendar() { 
            
            $data = array();
            $curentDate = date('Y-m-d', time());
            if ($this->input->post('page') !== null) {
                $malestr = str_replace("?", "", $this->input->post('page'));
                $navigation = explode('/', $malestr);
                $getYear = $navigation[1];
                $getMonth = $navigation[2];
            } else {
                $getYear = date('Y');
                $getMonth = date('m');
            }
            if ($this->input->post('year') !== null) {
                $getYear = $this->input->post('year');
            }
            if ($this->input->post('month') !== null) {
                $getMonth = $this->input->post('month'); 
            }

            $already_selected_value = $getYear;
            $earliest_year = 1950;
            $startYear = '';
            $googleEventArr = array();
            $calendarData = array();

            $class = 'href="javascript:void(0);" data-days="{day}"';

            $startYear .= '<div class="col-md-3 col-sm-5 col-xs-7 col-md-offset-3 col-sm-offset-1"><div class="select-control"><select name="year" id="setYearVal" class="form-control">';
        foreach (range
                (date
                        ('Y') + 50, $earliest_year) as $x) {
            $startYear .= '<option value="' . $x . '"' . ($x == $already_selected_value ? ' selected="selected"' : '') . '>' . $x . '</option>';
        }
        $startYear .= '</select></div></div>';
        $startMonth = '<div class="col-md-3 col-sm-5 col-xs-7 col-md-offset-3 col-sm-offset-1"><div class="select-control"><select name="mont h" id="setMonthVal" class="form-control"><option value="0">Select Month</option>
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

        {cal_cell_other}{day}{/cal_cel_other}

        {cal_cell_end}</td>{/cal_cell_end}
        {cal_cell_end_today}</td>{/cal_cell_end_today}
        {cal_cell_end_other}</td>{/cal_cell_end_other}
        {cal_row_end}</tr>{/cal_row_end}

        {table_close}</table>{/table_close}';
        $prefs['start_day'] = 'monday';
        $prefs['day_type'] = 'short';
        $prefs['show_next_prev'] = TRUE;
        $prefs['next_prev_url'] = '?';

        // load calendar library 
        $this->load->library('calendar', $prefs);
        $data['calendar'] = $this->calendar->generate($getYear, $getMonth, $calendarData, $this->uri->segment(3), $this->uri->segment(4));
        echo $data['calendar'];
    }

}

?>
</pre>






<strong>Step 2: Create a view(header)</strong><br>
Create a view file named <code>header.php</code> inside <code>“application/views/templates”</code> folder <br>
This view contains the header section of the webpage. The Bootstrap library is used to provide a better UI, so, include it in the header section.<br>

<pre class="lang-html">
  <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php print $title; ?></title>
  <link rel="icon" type="image/ico" href="<?php print HTTP_IMAGE_PATH; ?>favicon.ico">
  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" />
  <!-- Custom fonts for this template -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.2/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" />
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template -->
  <link href="<?php print HTTP_CSS_PATH; ?>style.css" rel="stylesheet">
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top header-bg-dark" style="background: ##FFFFFF!;">
  <div class="container">
    <a class="navbar-brand font-weight-bold" href="https://techarise.com"><h1>Tech Arise</h1></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link" href="https://techarise.com">Home
                <span class="sr-only">(current)</span>
              </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://techarise.com/php-free-script-demos/">Live Demo</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
     
</pre>


<strong>Step 3: Create a view(footer)</strong><br>
Create a view file named <code>footer.php</code> inside <code>“application/views/templates”</code> folder <br>
This view contains the footer section of the webpage.</br>

<pre class="lang-html">
 <!-- Footer -->
  <footer class="footer bg-light footer-bg-dark">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
          <ul class="list-inline mb-2">
            <li class="list-inline-item">
              <a href="#">About</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Contact</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Terms of Use</a>
            </li>
            <li class="list-inline-item">&sdot;</li>
            <li class="list-inline-item">
              <a href="#">Privacy Policy</a>
            </li>
          </ul>
          <p class="text-muted small mb-4 mb-lg-0">Copyright &copy;  2011 - <?php print date('Y', time());?> <a href="https://techarise.com/">TECHARISE.COM</a> All rights reserved.</p>
        </div>
        <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
          <ul class="list-inline mb-0">
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fab fa-facebook fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item mr-3">
              <a href="#">
                <i class="fab fa-twitter-square fa-2x fa-fw"></i>
              </a>
            </li>
            <li class="list-inline-item">
              <a href="#">
                <i class="fab fa-instagram fa-2x fa-fw"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  <script>
    var baseurl = "<?php print site_url();?>";
  </script>
  <!-- Bootstrap core JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.js"></script>
  <script src="<?php print HTTP_JS_PATH; ?>common.js"></script>
</body>
</html>      
</pre>

<strong>Step 4: Create a view(index)</strong><br>
Create a view file named <code>index.php</code> inside “application/views/cicalendar folder
<pre class="lang-html">
 <?php $this->load->view('templates/header');?>
  <section class="showcase">
    <div class="container">
      <div class="pb-2 mt-4 mb-2 border-bottom">
        <h2>Implement Calendar Library in CodeIgniter</h2>
      </div>       
      <div id="my-calendar">
     <div class="text-center"><i class="fa fa-spinner fa-pulse fa-5x fa-fw"></i></div>
   </div>
  </div>
  </section>    
<?php $this->load->view('templates/footer');?>   
</pre>

<strong>Step 5: Create a AJAX file Create a js file named <code>application.js</code> inside “assets/js” folder</strong><br>
<pre class="lang-html">

// render calendar
if (jQuery('div#my-calendar').length > 0) {
    jQuery.ajax({
        url: baseurl + 'cicalendar/getCalendar',
        dataType: 'html',
        beforeSend: function () {
            $('#my-calendar').html('<div class="text-center mrgA padA"><i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i></div>');
        },
        complete: function () {
            jQuery('[data-caltoggle="tooltip"]').tooltip();
        },
        success: function (html) {
            jQuery('#my-calendar').html(html);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}

// render calendar with navigation
jQuery(document).on("click", "a.calnav", function (e) {
    e.preventDefault();
    var page = jQuery(this).data("calvalue");
    jQuery.ajax({
        url: baseurl + 'cicalendar/getCalendar',
        type: 'post',
        data: {page: page},
        dataType: 'html',
        beforeSend: function () {
            $('#my-calendar').html('<div class="text-center mrgA padA"><i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i></div>');
        },
        complete: function () {
            jQuery('[data-caltoggle="tooltip"]').tooltip();
        },
        success: function (html) {
            jQuery('#my-calendar').html(html);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
});


// render calendar change month 
jQuery(document).on("change", "#setMonthVal", function (e) {
    e.preventDefault();
    var month = this.value;
    var year = jQuery('#setYearVal > option:selected').val();
    jQuery.ajax({
        url: baseurl + 'cicalendar/getCalendar',
        type: 'post',
        data: {year: year, month: month},
        dataType: 'html',
        beforeSend: function () {
            $('#my-calendar').html('<div class="text-center mrgA padA"><i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i></div>');
        },
        complete: function () {
            jQuery('[data-caltoggle="tooltip"]').tooltip();
        },
        success: function (html) {
            jQuery('#my-calendar').html(html);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

});

// render calendar change year 
jQuery(document).on("change", "#setYearVal", function (e) {
    e.preventDefault();
    var year = this.value;
    var month = jQuery('#setMonthVal > option:selected').val();
    jQuery.ajax({
        url: baseurl + 'cicalendar/getCalendar',
        type: 'post',
        data: {year: year, month: month},
        dataType: 'html',
        beforeSend: function () {
            $('#my-calendar').html('<div class="text-center mrgA padA"><i class="fa fa-spinner fa-pulse fa-4x fa-fw"></i></div>');
        },
        complete: function () {
            jQuery('[data-caltoggle="tooltip"]').tooltip();
        },
        success: function (html) {
            jQuery('#my-calendar').html(html);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });

});

</pre>
<br>
<a class="btn btn-success" title="Demo" href="#" target="_blank" rel="noopener noreferrer"><i class="fa fa-fw fa-eye"></i> Demo</a>&nbsp;&nbsp;[sociallocker]<a class="btn btn-primary" title="Download" href="#" target="_blank" rel="noopener noreferrer"><i class="fa fa-fw fa-download text-right"></i> Download</a>[/sociallocker]


























SELECT * FROM `member` WHERE DATE_FORMAT(FROM_UNIXTIME(`created_date`),"%Y-%m-%d") BETWEEN '2019-04-01' AND '2019-04-30'

SELECT * 
FROM member WHERE  `created_date` 
BETWEEN UNIX_TIMESTAMP('1554076800') AND UNIX_TIMESTAMP('1556582400')






Integrate Google Calendar API with Codeigniter Calendar Library


integrate-google-calendar-api-with-codeigniter-calendar-library

Google Calendar allows users to create and edit events. Reminders can be enabled for events, with options available for type and time. Event locations can also be added, and other users can be invited to events.In this article, you will learn how to work with the Google Calendar API with Codeigniter Calendar Library. This is a very simple example, you can just copy paste and change according to your requirement.


<div>Some basic Step</a>

Register a Google Application and enable Calendar API.
In your web application, request user for authorization of the Google Application.
Get the user's timezone.
Use the primary calendar of the user.
Create an event.



<div>Setting up a Google Console Project and enable Calendar API</div>

Step-1 Create a new project in the <a herf="https://console.developers.google.com/" target="_blank">Google Developers Console</a>.

<img step-1.png>

Click the Library tab on the left. Search for "Calendar API" and enable it. 


Credentials tab on the left. In the next screen click on "OAuth consent screen". Fill out the mandatory fields. Save it

click on the "Credentials" tab (just beside "OAuth consent screen"). In the screen, click on "Create credentials". Choose "OAuth Client ID" 

<img step-2.png>

next screen fill out the name. The Application type should be "Web application"

<img step-3.png>
	
Add a redirect url in the section Authorised redirect URIs


{
	"web":{
	"client_id":"[hash-string].apps.googleusercontent.com","
	project_id":"[project-id]",
	"auth_uri":"https://accounts.google.com/o/oauth2/auth",
	"token_uri":"https://oauth2.googleapis.com/token",
	"auth_provider_x509_cert_url":"https://www.googleapis.com/oauth2/v1/certs",
	"client_secret":"[hash-string]",
	"redirect_uris":[
		"https://www.example.com/oauth2callback"
		]
	}
}


Require the Google API Client

Composer setup so first up we require the Google API client:

composer require google/apiclient:^2.0

This gives us a PHP Library to communicate with the Google APIs plus a load of helper functions for each API and OAuth2.

For More information : <a herf="https://github.com/googleapis/google-api-php-client">Google API Client</a>





