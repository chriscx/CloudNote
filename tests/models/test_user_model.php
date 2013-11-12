<?php
class test_users_model extends CodeIgniterUnitTestCase
{

	public function __construct()
	{
		parent::__construct('User Model');

		$this->load->model('user');
	}

	public function setUp()
	{

    }

    public function tearDown()
	{
		
    }

	public function test_class_exists()
	{
		$this->assertTrue(class_exists('user'));
	}

	public function test_create_user()
	{
		$user = new $this->user;
		$user->create('test_firstname', 'test_lastname', 'test@test.org', 'test');
		$query = $this->db->query("SELECT u.* FROM cn_users u WHERE u.email = 'test@test.org'");
		$this->assertTrue($query->num_rows() === 1);
		if($query->num_rows() > 0) {
			$query = $this->db->query("DELETE FROM cn_users WHERE email = 'test@test.org'");
		}
	}

	// public function test_signin_user()
	// {
	// 	// $this->session->set_userdata('session_id', 'd1caa32ba1f71d3956540c048d999a34');
	// 	// $this->session->set_userdata('ip_address', '::1');
	// 	// $this->session->set_userdata('user_agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36');
	// 	// $this->session->set_userdata('last_activiy', '1384294107');
	// 	$user = new $this->user;
	// 	$user->create('test_firstname', 'test_lastname', 'test@test.org', 'test');
	// 	$query = $this->db->query("SELECT u.* FROM cn_users u WHERE u.email = 'test@test.org'");

	// 	$valid = $user->signIn('test', 'test@test.org');
	// 	$this->assertTrue($valid);
	// 	// if($query->num_rows() > 0) {
	// 	// 	$query = $this->db->query("DELETE FROM cn_users WHERE email = 'test@test.org'");
	// 	// }
	// }

	// public function test_issignedin_user()
	// {
	// 	$user = new $this->user;
	// 	$user->create('test_firstname', 'test_lastname', 'test@test.org', 'test');
	// 	$query = $this->db->query("SELECT u.* FROM cn_users u WHERE u.email = 'test@test.org'");
		
	// 	$user->signIn('test', 'test@test.org');
	// 	$this->assertTrue($user->isSignedIn());
	// 	// if($query->num_rows() > 0) {
	// 	// 	$query = $this->db->query("DELETE FROM cn_users WHERE email = 'test@test.org'");
	// 	// }
	// }

	// public function test_signout_user()
	// {

	// }

	// public function test_getlistofnotes_user()
	// {
	// 	// $user = new $this->user;
	// 	// $user->signIn("test", "test");
	// 	// $user->updateListOfNotes();
	// 	// $user->getListOfNotes();
	// }

	// public function test_add_user()
	// {
	// 	$insert_data = array(
	// 		    'user_email' => 'demo'.$this->rand.'@demo.com',
	// 		    'user_username' => 'test_'.$this->rand,
	// 		    'user_password' => 'demo_'.$this->rand,
	// 		    'user_join_date' => time(),
	// 			'user_group'	=> 1
	// 		);
	// 	$user_id = $this->users_model->add_user($insert_data);

	// 	//$this->dump($user_id);
	// 	$this->assertEqual($user_id, 1, 'user id = 1');
	// }

	// public function test_get_user_by_id()
	// {
	// 	$user = $this->users_model->get_user(1);
	// 	$this->assertEqual($user['user_id'], 1);
	// }

	// public function test_get_user_by_username()
	// {
	// 	$user = $this->users_model->get_user('test_'.$this->rand);
	// 	$this->assertEqual($user['user_id'], 1);
	// }

	// public function test_edit_user()
	// {
	// 	$insert_data = array(
	// 		    'user_email' => 'edit_demo'.$this->rand.'@demo.com',
	// 		);
	// 	$user = $this->users_model->edit_user(1, $insert_data);
	// 	$this->assertTrue($user);
	// }

	// public function test_delete_user()
	// {
	// 	$user = $this->users_model->delete_user(1);
	// 	$this->assertTrue($user);
	// }

	// public function test_username_exists()
	// {
	// 	$user = $this->users_model->username_check('test_'.$this->rand);
	// 	$this->assertFalse($user);
	// }

	// public function test_username_does_not_exists()
	// {
	// 	$user = $this->users_model->username_check('my_super_test_'.$this->rand);
	// 	$this->assertTrue($user);
	// }

	// public function test_email_exists()
	// {
	// 	$user = $this->users_model->email_check('demo'.$this->rand.'@demo.com');
	// 	$this->assertFalse($user);
	// }

	// public function test_email_does_not_exists()
	// {
	// 	$user = $this->users_model->email_check('my_super_test_'.$this->rand.'@demo.com');
	// 	$this->assertTrue($user);
	// }
}

/* End of file test_users_model.php */
/* Location: ./tests/models/test_users_model.php */
