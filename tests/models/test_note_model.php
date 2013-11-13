<?php
class test_note_model extends CodeIgniterUnitTestCase
{

	public function __construct()
	{
		parent::__construct('Note Model');

		$this->load->model('note');
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
		$note = new $this->note;
		$note->setIdUser(999);
		$note->create('unit_test_note');
		$query = $this->db->query("SELECT n.id_user FROM cn_notes n WHERE n.name = 'unit_test_note'");
		if($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
              $id_user = $row->id_user;
              $this->assertTrue($id_user == 999);
            } 
		}
		else
			$this->assertTrue(FALSE);
		$query = $this->db->query("DELETE FROM cn_notes WHERE id_user = 999");
	}

	public function test_delete_note() {
		$note = new $this->note;
		$note->setIdUser(999);
		$note->create('unit_test_note');
		$query = $this->db->query("SELECT n.id_user FROM cn_notes n WHERE n.name = 'unit_test_note'");
		if($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
              $id_user = $row->id_user;
              
            } 
		}

		$note->delete();
		$query = $this->db->query("SELECT * FROM cn_notes n WHERE n.name = 'unit_test_note'");
		if($query->num_rows() > 0) {
			$this->assertTrue(FALSE);
		}
		else 
			$this->assertTrue(TRUE);
	}

	public function test_sync_note() {
		$note = new $this->note;
		$note->setIdUser(999);
		$note->create('unit_test_note');
		$query = $this->db->query("SELECT n.id_note FROM cn_notes n WHERE n.name = 'unit_test_note'");
		if($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
              $note->setIdNote($row->id_note);
              
            } 
		}

		$note->setContent('unit_test_content');
		$query = $this->db->query("SELECT n.content FROM cn_notes n WHERE n.name = 'unit_test_note'");
		if($query->num_rows() > 0) {

			foreach ($query->result() as $row) {
				if($row->content === 'unit_test_content')
             		$this->assertTrue(TRUE);
             	else
             		$this->assertTrue(FALSE);
              
            } 
		}
		$note->delete();
	}

	public function test_load_note() {

	}
}


/* End of file test_users_model.php */
/* Location: ./tests/models/test_users_model.php */
