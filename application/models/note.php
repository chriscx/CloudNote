<?php 

// if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class note extends CI_Model {

  private $id_note;
  private $id_user;
  private $name;
  private $content;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function create($name) {
        
        $sql = "CALL create_note($this->id_user, '$name')";
        $query = $this->db->query($sql);
        //$query->next_result();
        $sql = "CALL get_last_note_created($this->id_user)";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row)
            {
                $this->id_note = $row->id_note;
            }
        }
        $query->next_result();
    }

    public function delete() {
            $sql = "CALL delete_note($this->id_note, $this->id_user)";
            $query = $this->db->query($sql);
    }

    public function sync() {
        $sql = "CALL update_note($this->id_note, '$this->content'";
        $result = $this->db->query($sql);
    }

    public function load() {
        //get list of content of note
        $sql = "CALL get_note($this->id_note)";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
              return $row->content;
            }
        }
    }

    // GETTERS
    public function getIdNote() {
        return $this->id_note;
    }

    public function getIdUser(){
        return $this->id_user;
    }

    public function getContent() {
        return $this->content;
    }

    public function getName() {
        return $this->name;
    }

    // SETTERS
    public function setContent($newContent) {
        if(isset($newContent)) {
            $content = str_replace("'", "\'", $newContent);
            $this->content = $content;
        }
    }

    public function setName($newName) {
        if(isset($newName) AND empty($newName))
            $this->name = $newName;
    }

    public function setIdNote($_id_note) {
        $this->id_note = $_id_note;
    }

    public function setIdUser($_id_user) {
        $this->id_user = $_id_user;
    }

}