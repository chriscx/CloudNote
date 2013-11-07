<?php 

// if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "note.php";

class user extends CI_Model {

    private $id;
    private $firstname;
    private $lastname;
    private $email;

    private $listOfNotes;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function create($firstname, $lastname, $email, $password) {
        
        $_password = $this->encrypt->sha1($password);
        $sql = "SELECT create_user('$email', '$_password', '$firstname', '$lastname')";
        $result = $this->db->query($sql);
    }
    
    public function signIn($password, $email){
        
        $_password = $this->encrypt->sha1($password);
        $sql = "SELECT check_password('$_password', '$email') AS valid";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0)
        {
              foreach ($query->result() as $row) {
                $valid = $row->valid;
              }
        }

        if($valid) {
            $newdata = array(
                'email'     => $email,
                'logged_in' => TRUE
            );

            $this->session->set_userdata($newdata);

            $sql = "SELECT u.id_user AS id_user FROM cn_users u WHERE u.email = '$email'";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row)
                {
                    $this->id = $row->id_user;
                }
            }
        }
        return $valid;    
    }
    
    /*
        returns TRUE or FALSE
    */
    public function isSignedIn(){
        return $this->session->userdata('logged_in');
    }
    
    public function signOut(){
        $this->session->unset_userdata('user_obj');
        $this->session->set_userdata('logged_in', FALSE);
    }
    
    public function updateListOfNotes(){
        
        if($this->isSignedIn()){
               //get list of Id, name of notes
            $sql = "CALL get_list_notes($id)";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $i = 0;
                foreach ($query->result() as $row) {
                    $this->listOfNotes[$i]['id_note'] = $row->id_note;
                    $this->listOfNotes[$i]['name'] = $row->name;

                }
            }
        }
    }

    public function getListOfNotes(){
        return $this->getListOfNotes;
    }
}