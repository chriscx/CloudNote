<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function create($firstname, $lastname, $email, $password) {
        
        $password = sha1($password);
        $sql = "SELECT create_user('$email', '$password', '$firstname', '$lastname')";
        $result = $this->db->query($sql);
    }
    
    public function logIn($email, $password){
        
    }
    
    public function isLoggedIn(){
        
    }
    
    public function logOut(){
        
    }
    
    public function getListOfNotes(){
        
        if($this->isLoggedIn()){
               //get list of Id, name of notes
        }
    }
    
    public function getNote($idNote) {
        if($this->isLoggedIn()){
               //get list of content of note
        }
    }
}