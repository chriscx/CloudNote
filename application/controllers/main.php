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
				$this->load->view('main', $data);

				//get content of note and display it
			}
			else {
				$data['error_nb'] = 1;
				$this->load->view('error', $data);
			}
		}
		else
			$this->load->view('not_signed_in', $data);
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
		                echo "{\"id_note\": \"$row->id_note\", \"name_note\": \"$name\"}";
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
				$data['error_nb'] = 1;
				$this->load->view('error', $data);
			}
		}
		else
			$this->load->view('not_signed_in', $data);
    }

    public function sync() {
		$user_data = $this->session->all_userdata();

		if(isset($user_data['signed_in']) && $user_data['signed_in']) {

			if(isset($user_data['id_user'])) {
				$content_note = $_POST['content_note'];
				$id_user = $user_data['id_user'];
				$id_note = $_POST['id_note'];
				$sql = "CALL update_note($id_note, '$content_note', $id_user)";
				echo "$sql ";
		        $query = $this->db->query($sql);
		        echo 'SUCCESS';
			}
			else {
				$data['error_nb'] = 1;
				$this->load->view('error', $data);
			}
		}
		else
			$this->load->view('not_signed_in', $data);
    }

  //   public function delete($name) {
		// $user_data = $this->session->all_userdata();

		// if(isset($user_data['signed_in']) && $user_data['signed_in']) {

		// 	if(isset($user_data['id_user'])) {
				
		// 	}
		// 	else {
		// 		$data['error_nb'] = 1;
		// 		$this->load->view('error', $data);
		// 	}
		// }
		// else
		// 	$this->load->view('not_signed_in', $data);
  //   }
}