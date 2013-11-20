<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class main extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$user_data = $this->session->all_userdata();

		if(isset($user_data['signed_in']) && $user_data['signed_in']) {

			if(isset($user_data['id_user'])) {
				$user = new $this->user;
				$user->setId($user_data['id_user']);

				$user->updateListOfNotes();
				$tab = $user->getListOfNotes();
				$data['listOfNotes'] = $tab;

				$id_note = $tab[0]['id_note'];
				$id_user = $user_data['id_user'];
				$sql = "CALL get_note($id_note, $id_user)";
		        $query = $this->db->query($sql);
		        if ($query->num_rows() > 0)
		        {
		              foreach ($query->result() as $row) {
		                $data['content_note_displayed'] = $row->content;
		              }
		        }
		        $query->next_result();

		        $user->updateListOfReminders();
				$tab = $user->getListOfReminders();
				$data['listOfReminders'] = $tab;

				$this->load->view('main', $data);

				//get content of note and display it
			}
			else {
				$data['error_nb'] = 1;
				$this->load->view('error', $data);
			}
		}
		else
			header("Location: " . site_url("index.php/signin/index/"));
	}
    
    public function create() {
		$user_data = $this->session->all_userdata();

		if(isset($user_data['signed_in']) && $user_data['signed_in']) {

			if(isset($user_data['id_user'])) {
				$name = $_POST['name_note'];
				$id = $user_data['id_user'];
				$sql = "CALL create_note($id, '$name')";
		        $query = $this->db->query($sql);

		        $user = new $this->user;
				$user->setId($user_data['id_user']);
				$user->updateListOfNotes();
				$tab = $user->getListOfNotes();
				$query->next_result();
				$sql = "CALL get_last_note_created($id)";
		        $query = $this->db->query($sql);
		        if ($query->num_rows() > 0)
		        {
		              foreach ($query->result() as $row) {
		                echo "{\"id_note\": \"$row->id_note\", \"name_note\": \"$name\", \"content_note\": \"$row->content\"}";
		              }
		        }
			}
			else {
				echo "{\"error\": \"2\"}";
			}
		}
		else
			echo "{\"error\": \"1\"}";
    }

    public function load() {
		$user_data = $this->session->all_userdata();

		if(isset($user_data['signed_in']) && $user_data['signed_in']) {

			if(isset($user_data['id_user'])) {
				$id_note = $_POST['id_note'];
				$id_user = $user_data['id_user'];
				$sql = "CALL get_note($id_note, $id_user)";
		        $query = $this->db->query($sql);
		        if ($query->num_rows() > 0)
		        {
		            foreach ($query->result() as $row) {
		            	echo "{\"id_note\": \"$id_note\", \"content_note\": \"$row->content\"}";
		            }
		        }
			}
			else {
				echo "{\"error\": \"2\"}";
			}
		}
		else
			echo "{\"error\": \"1\"}";
    }

    public function sync() {
		$user_data = $this->session->all_userdata();

		if(isset($user_data['signed_in']) && $user_data['signed_in']) {

			if(isset($user_data['id_user'])) {
				$content_note = $content = str_replace("'", "\'", $_POST['content_note']);
				$id_user = $user_data['id_user'];
				$id_note = $_POST['id_note'];
				$sql = "CALL update_note($id_note, '$content_note', $id_user)";
				echo "$sql ";
		        $query = $this->db->query($sql);
		        echo 'SUCCESS';
			}
			else {
				echo "{\"error\": \"2\"}";
			}
		}
		else
			echo "{\"error\": \"1\"}";
    }

    public function delete() {
		$user_data = $this->session->all_userdata();

		if(isset($user_data['signed_in']) && $user_data['signed_in']) {

			if(isset($user_data['id_user'])) {
				$id_user = $user_data['id_user'];
				$id_note = $_POST['id_note'];
				$sql = "CALL delete_note($id_note, $id_user)";
		        $query = $this->db->query($sql);
		        echo "{\"success\": \"success\"}";
			}
			else {
				echo "{\"error\": \"2\"}";
			}
		}
		else
			echo "{\"error\": \"1\"}";
    }

    public function addReminder() {
    	$user_data = $this->session->all_userdata();

		if(isset($user_data['signed_in']) && $user_data['signed_in']) {

			if(isset($user_data['id_user'])) {

				$id_user = $user_data['id_user'];
				$id_note = $_POST['id_note'];
				$name = $_POST['name'];
				$date = $_POST['date'];
				if(strlen($date) === 5)
					$date = $date . '/' . (string)date("Y");
				$time = $_POST['time'];
				$identifier = $_POST['identifier'];
				$location = 'null';

				$sql = "SELECT create_reminder('$name', '$date', '$time', '$location', $id_note, $id_user, '$identifier', NULL) as alreadyExists";
		        $query = $this->db->query($sql);
		        if($query->num_rows() > 0)
		        {
		              foreach ($query->result() as $row) {
		               	$alreadyExists = $row->alreadyExists;
		              }
		        }

		        $query->next_result();
		        if(!$alreadyExists) {
					$sql = "CALL get_last_reminder_created($id_user)";
		        	$query = $this->db->query($sql);
		        	if ($query->num_rows() > 0)
		        	{
		        	      foreach ($query->result() as $row) {
		        	        echo "{\"id_reminder\": \"$row->id_reminder\", \"id_note\": \"$row->id_note\", \"name_r\": \"$row->name\", \"date_r\": \"$row->date\", \"time_r\": \"$row->time\" , \"location_r\": \"$row->location\"}";
		        	      }
		        	}
		    	}else
		    		echo "{\"alreadyExists\": \"$alreadyExists\"}";
			}
			else {
				echo "{\"error\": \"2\"}";
			}
		}
		else
			echo "{\"error\": \"1\"}";
    }

    public function syncReminder() {
    	$user_data = $this->session->all_userdata();

		if(isset($user_data['signed_in']) && $user_data['signed_in']) {

			if(isset($user_data['id_user'])) {
				$id_user = $user_data['id_user'];
				$id_reminder = $_POST['id_reminder'];
				$description = str_replace("'", "\'", $_POST['description_r']);
				$location = str_replace("'", "\'", $_POST['location_r']);
				$sql = "CALL update_reminder($id_reminder, $id_user, '$location', '$description')";
		        $query = $this->db->query($sql);
		        echo "{\"success\": \"success\"}";
			}
			else {
				echo "{\"error\": \"2\"}";
			}
		}
		else
			echo "{\"error\": \"1\"}";
    }

    public function deleteReminder() {
		$user_data = $this->session->all_userdata();

		if(isset($user_data['signed_in']) && $user_data['signed_in']) {

			if(isset($user_data['id_user'])) {
				$id_user = $user_data['id_user'];
				$id_reminder = $_POST['id_reminder'];
				$sql = "CALL delete_reminder($id_reminder, $id_user)";
		        $query = $this->db->query($sql);
		        echo "{\"success\": \"success\"}";
			}
			else {
				echo "{\"error\": \"2\"}";
			}
		}
		else
			echo "{\"error\": \"1\"}";
    }

    public function getIcalFile() {
		// Variables used in this script:
		//   $summary     - text title of the event
		//   $datestart   - the starting date (in seconds since unix epoch)
		//   $dateend     - the ending date (in seconds since unix epoch)
		//   $address     - the event's address
		//   $uri         - the URL of the event (add http://)
		//   $description - text description of the event
		//   $filename    - the name of this file for saving (e.g. my-event-name.ics)
		//
		// Notes:
		//  - the UID should be unique to the event, so in this case I'm just using
		//    uniqid to create a uid, but you could do whatever you'd like.
		//
		//  - iCal requires a date format of "yyyymmddThhiissZ". The "T" and "Z"
		//    characters are not placeholders, just plain ol' characters. The "T"
		//    character acts as a delimeter between the date (yyyymmdd) and the time
		//    (hhiiss), and the "Z" states that the date is in UTC time. Note that if
		//    you don't want to use UTC time, you must prepend your date-time values
		//    with a TZID property. See RFC 5545 section 3.3.5
		//
		//  - The Content-Disposition: attachment; header tells the browser to save/open
		//    the file. The filename param sets the name of the file, so you could set
		//    it as "my-event-name.ics" or something similar.
		//
		//  - Read up on RFC 5545, the iCalendar specification. There is a lot of helpful
		//    info in there, such as formatting rules. There are also many more options
		//    to set, including alarms, invitees, busy status, etc.
		//
		//      https://www.ietf.org/rfc/rfc5545.txt
		 
		// 1. Set the correct headers for this file
		header('Content-type: text/calendar; charset=utf-8');
		header('Content-Disposition: attachment; filename=' . $filename);
		 
		// 2. Define helper functions
		 
		// Converts a unix timestamp to an ics-friendly format
		// NOTE: "Z" means that this timestamp is a UTC timestamp. If you need
		// to set a locale, remove the "\Z" and modify DTEND, DTSTAMP and DTSTART
		// with TZID properties (see RFC 5545 section 3.3.5 for info)
		//
		// Also note that we are using "H" instead of "g" because iCalendar's Time format
		// requires 24-hour time (see RFC 5545 section 3.3.12 for info).
		function dateToCal($timestamp) {
		  return date('Ymd\THis\Z', $timestamp);
		}
		 
		// Escapes a string of characters
		function escapeString($string) {
		  return preg_replace('/([\,;])/','\\\$1', $string);
		}
		 
		// 3. Echo out the ics file's contents
		?>
		BEGIN:VCALENDAR
		VERSION:2.0
		PRODID:-//hacksw/handcal//NONSGML v1.0//EN
		CALSCALE:GREGORIAN
		BEGIN:VEVENT
		DTEND:<?= dateToCal($dateend) ?>
		UID:<?= uniqid() ?>
		DTSTAMP:<?= dateToCal(time()) ?>
		LOCATION:<?= escapeString($address) ?>
		DESCRIPTION:<?= escapeString($description) ?>
		URL;VALUE=URI:<?= escapeString($uri) ?>
		SUMMARY:<?= escapeString($summary) ?>
		DTSTART:<?= dateToCal($datestart) ?>
		END:VEVENT
		END:VCALENDAR
		<?php
    }
}