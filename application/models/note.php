<?php 

// if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class note extends CI_Model {

  private $id;
  private $name;
  private $content;
    
    public function __construct() {
        parent::__construct();
    }
    
    public function create($id_user) {
        
        $sql = "CALL create_note($id_user, $this->name)";
        $result = $this->db->query($sql);
    }

    public function delete() {
        $sql = "CALL delete_note($this->id)";
        $result = $this->db->query($sql);
    }

    public function sync() {
        $sql = "CALL update_note($this->id, '$this->content'";
        $result = $this->db->query($sql);
    }

    public function retrieve() {
        //get list of content of note
        $sql = "CALL get_note($this->id)";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
              return $row->content;
            }
        }
    }

    // GETTERS
    public function getId() {
        return $this->id;
    }

    public function getContent() {
        return $this->content;
    }

    public function getName() {
        return $this->name;
    }

    // SETTERS
    public function setContent($newContent) {
        if(isset($newContent))
            $this->content = $newContent;
    }

    public function setName($newName) {
        if(isset($newName) AND empty($newName))
            $this->name = $newName;
    }
}