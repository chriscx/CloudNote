<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class signin extends CI_Controller {

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

        	$this->load->view("already_signed_in", $data);
        }
        else
			$this->load->view('sign_in');
	}
    
    public function check()
    {
        $user = new $this->user;
        $data['verif_sign_in'] = $user->signIn($_POST['password'], $_POST['email']);
        if($data['verif_sign_in']) {

			// redirect to main address
			header("Location: " . site_url("index.php/main/index/"));
       	}
       	else {
       		$this->load->view("error_sign_in");
       	}
    }
}