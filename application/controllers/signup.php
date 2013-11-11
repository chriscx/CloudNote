<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class signup extends CI_Controller {

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

        	header("Location: " . site_url("index.php/main/index/"));
        }
        else
		$this->load->view('sign_up');
	}
    
    public function val()
    {
        $user = new $this->user->user();
        $data['user_is_created'] = $user->create($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['password']);
        if($data['user_is_created'])
        	//redirect to sign in page
        	header("Location: " . site_url("index.php/signin/index/"));
        else
        	$this->load->view('success_sign_up', $data);
    }
}