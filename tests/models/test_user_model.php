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

	public function test_signin_user()
	{
		// $this->session->set_userdata('session_id', 'd1caa32ba1f71d3956540c048d999a34');
		// $this->session->set_userdata('ip_address', '::1');
		// $this->session->set_userdata('user_agent', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36');
		// $this->session->set_userdata('last_activiy', '1384294107');
		// $cookie = array(
		// 	'session_id' => 'd1caa32ba1f71d3956540c048d999a34',
		//     'ip_address'=> '::1',
		//     'user_agent'=> 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36',
		//     'last_activiy'=> '1384294107'
		// );

		// $this->input->set_cookie($cookie);

		$user = new $this->user;
		$user->create('test_firstname', 'test_lastname', 'test@test.org', 'test');
		$query = $this->db->query("SELECT u.* FROM cn_users u WHERE u.email = 'test@test.org'");

		$valid = $user->signIn('test', 'test@test.org');
		$this->assertTrue($valid);
		if($query->num_rows() > 0) {
			$query = $this->db->query("DELETE FROM cn_users WHERE email = 'test@test.org'");
		}
	}

	public function test_getlistofnotes_user()
	{
		$user = new $this->user;
		$user->create('test_firstname', 'test_lastname', 'test@test.org', 'test');
		$query = $this->db->query("SELECT u.* FROM cn_users u WHERE u.email = 'test@test.org'");

		$valid = $user->signIn('test', 'test@test.org');
		$this->assertTrue($user->getListOfNotes() === null);

		$query = $this->db->query("DELETE FROM cn_users WHERE email = 'test@test.org'");
	}


	public function test_updatelistofnotes_user()
	{
		$user = new $this->user;
		$user->create('test_firstname', 'test_lastname', 'test@test.org', 'test');
		$query = $this->db->query("SELECT u.* FROM cn_users u WHERE u.email = 'test@test.org'");

		$valid = $user->signIn('test', 'test@test.org');
		$query = $this->db->query("INSERT INTO cn_notes(id_user, content, name) VALUES((SELECT u.id_user FROM cn_users u WHERE u.email = 'test@test.org'), 'test', 'test')");
		$user->updateListOfNotes();
		//create note
		$this->assertFalse($user->getListOfNotes() === null);
		
		$query = $this->db->query("DELETE FROM cn_users WHERE email = 'test@test.org'");
		$query = $this->db->query("DELETE FROM cn_notes WHERE name = 'test'");

	}

}


/* End of file test_users_model.php */
/* Location: ./tests/models/test_users_model.php */
