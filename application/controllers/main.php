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
				$this->load->view('main', $data);
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
				$sql = "CALL create_note('$id', '$name')";
		        $query = $this->db->query($sql);

		        $user = new $this->user;
				$user->setId($user_data['id_user']);
				$user->updateListOfNotes();
				$tab = $user->getListOfNotes();
			}
			else {
				echo 2;
			}
		}
		else
			echo 1;
    }

    public function LoadNote($name) {
		$user_data = $this->session->all_userdata();

		if(isset($user_data['signed_in']) && $user_data['signed_in']) {

			if(isset($user_data['id_user'])) {
				
			}
			else {
				$data['error_nb'] = 1;
				$this->load->view('error', $data);
			}
		}
		else
			$this->load->view('not_signed_in', $data);
    }

    public function SyncNote($name) {
		$user_data = $this->session->all_userdata();

		if(isset($user_data['signed_in']) && $user_data['signed_in']) {

			if(isset($user_data['id_user'])) {
				
			}
			else {
				$data['error_nb'] = 1;
				$this->load->view('error', $data);
			}
		}
		else
			$this->load->view('not_signed_in', $data);
    }

    public function DeleteNote($name) {
		$user_data = $this->session->all_userdata();

		if(isset($user_data['signed_in']) && $user_data['signed_in']) {

			if(isset($user_data['id_user'])) {
				
			}
			else {
				$data['error_nb'] = 1;
				$this->load->view('error', $data);
			}
		}
		else
			$this->load->view('not_signed_in', $data);
    }
}