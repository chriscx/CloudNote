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
        
		$this->load->view('signin');
	}
    
    public function check()
    {
        $user = new $this->user->user();
        $data['isSignedIn'] = $user->signIn($_POST['password'], $_POST['email']);
        if($data['isSignedIn']) {
        	$this->load->view("main", $data);
       	}
       	else {
       		$this->load->view("signin", $data);
       	}
    }
}