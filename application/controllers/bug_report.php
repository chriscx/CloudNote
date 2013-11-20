<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class bug_report extends CI_Controller {

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

        	$this->load->view('bug_report');
        }
        else
			$this->load->view('sign_in');
	}
    
    public function send()
    {
    	$user_data = $this->session->all_userdata();

        if(isset($user_data['signed_in']) && $user_data['signed_in']) {

        	if(isset($_POST['description']) && isset($_POST['title'])) {

        		$this->load->library('email');
        		$id_user = $user_data['id_user'];
        		$sql = "SELECT u.email FROM cn_users u WHERE u.id_user = $id_user";
		        $query = $this->db->query($sql);
		        if ($query->num_rows() > 0)
		        {
		            foreach ($query->result() as $row) {
		            	$email = $row->email;
		            }
		        }

				$this->email->from($email, 'CloudNote Bug Report');
				$this->email->to('christopher.cailleaux@gmail.com'); 
				//$this->email->cc('another@another-example.com'); 
				//$this->email->bcc('them@their-example.com'); 

				$this->email->subject('[CloudNote - Bug Report]' . $_POST['title']);
				$this->email->message($_POST['description']);	

				$this->email->send();
			}
        }
   //      else
			// //$this->load->view('sign_in');
    }
}