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
					$date += '/' + date("Y");
				$time = $_POST['time'];
				$identifier = $_POST['identifier'];
				$location = 'null';

				$sql = "SELECT create_reminder('$name', '$date', '$time', '$location', $id_note, $id_user, '$identifier', NULL)";
				//echo $sql;
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
}