<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller {

  private $id;
    
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
           foreach ($query->result() as $row)
           {
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
          if ($query->num_rows() > 0)
          {
             foreach ($query->result() as $row)
             {
                $this->id = $row->id_user;
             }
          }
        }
        return $valid;    
    }
    
    public function isSignedIn(){
        return $this->session->userdata('logged_in');
    }
    
    public function signOut(){
                $newdata = array(
                   'email'     => $email,
                   'logged_in' => FALSE
               );

        $this->session->set_userdata($newdata);
    }
    
    public function getListOfNotes(){
        
        if($this->isSignedIn()){
               //get list of Id, name of notes
          $sql = "SELECT get_list_notes($email)";
          $query = $this->db->query($sql);
          if ($query->num_rows() > 0)
          {
             foreach ($query->result() as $row)
             {
                return $row->valid;
             }
          }
        }
    }
    
    public function getNote($idNote) {
        if($this->isSignedIn()){
               //get list of content of note
          $sql = "SELECT check_password('$_password', '$email') AS valid";
          $query = $this->db->query($sql);
          if ($query->num_rows() > 0)
          {
             foreach ($query->result() as $row)
             {
                return $row->valid;
             }
          }
        }
    }

    public function createNote() {

    }

    public function deleteNote() {
      
    }
}