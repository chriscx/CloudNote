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
        if(isset($user_data['logged_in']) AND $user_data['logged_in']) {
	        $data['isAlreadySignedIn'] = $user_data['logged_in'];
	    }
	    else{
	    	$data['isAlreadySignedIn'] = FALSE;
	    }
		$this->load->view('signin', $data);
		unset($data);
	}
    
    public function check()
    {
        $user = new $this->user->user();
        $data['isSignedIn'] = $user->signIn($_POST['password'], $_POST['email']);
        if($data['isSignedIn']) {
        	$this->session->set_userdata('user_obj', $user);
        	$this->load->view("main", $data);
       	}
       	else {
       		$this->load->view("signin", $data);
       	}
       	unset($data);
    }
}