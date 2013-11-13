<?php 

// if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once "note.php";

class user extends CI_Model {

    public $id;
    private $firstname;
    private $lastname;
    private $email;

    private $listOfNotes;
    
    public function __construct() {
        parent::__construct();
    }

    public function setId($_id) {
        $this->id = $_id;
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
    // public function isSignedIn(){
    //     return $this->session->userdata('signed_in');
    // }
    
    // public function signOut(){
    //     $this->session->set_userdata('signed_in', FALSE);
    // }
    
    public function updateListOfNotes(){
        
        // if($this->isSignedIn()){
               //get list of Id, name of notes
            $sql = "CALL get_list_notes($this->id)";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $i = 0;
                foreach ($query->result() as $row) {
                    $this->listOfNotes[$i]['id_note'] = $row->id_note;
                    $this->listOfNotes[$i]['name'] = $row->name;
                    $i++;

                }
            }
            $query->next_result();
        // }
    }

    public function getListOfNotes(){
        return $this->listOfNotes;
    }

    public function getId() {
        if(isset($this->id)) {
            return $this->id;
        }
        else
            return -1;
    }
}