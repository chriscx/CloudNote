<?php
class test_note_model extends CodeIgniterUnitTestCase
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
		$this->assertTrue(class_exists('note'));
	}

	public function test_create_note()
	{

	}
}


/* End of file test_users_model.php */
/* Location: ./tests/models/test_users_model.php */
