<?php 
require_once 'Database.php';
require_once 'Operations.php';

class About_us extends Database implements Operations { 
    var $id,$details;



    public function CheckAboutUs() 
    {
        $result = $this->RUNSearch("SELECT * FROM about_us");
        
        if($result->rowCount() > 0){
            $result->closeCursor();
            return '<br><h3> About is contains text, please use Edit section</h3> <br>';
        }

        return false;
    
    }
        public function Add() {
        // check if table has values first
        $check = $this->CheckAboutUs();
        if(!$check) 
            return $this->RunDML("INSERT INTO about_us (id,details) VALUES(1,?)",[$this->details],"About Us Added");
        else
            return  $check;

    }
    public function Update() {
        return $this->RunDML("UPDATE about_us SET details = ?",[$this->details],"About Us Updated");

    }
    public function Delete() {
        $result = $this->RunDML("DELETE FROM about_us WHERE id = ?",[1],"About Us Deleted");
        

    }
    public function Search() {
        $result = $this->RUNSearch('SELECT * FROM about_us WHERE id = 1');
       
        if($result->rowCount() > 0){
            $res = $result->fetch();
            $result->closeCursor();
            return $res;
        }

        return false;

    }

    public function getStats() {
        $result = $this->RUNSearch('SELECT COUNT(CASE WHEN u.user_type_id = 4 THEN 1 END) AS organizations, COUNT(CASE WHEN u.user_type_id = 1 THEN 1 END) AS customers,s.num AS tickets FROM users u , statistics s');
       
        if($result->rowCount() > 0){
            $res = $result->fetch();
            $result->closeCursor();
            return $res;
        }
        return false;
        
    }

    public function getAdminStats() {
        $result = $this->RUNSearch('SELECT * FROM admin_stats');
       
        if($result->rowCount() > 0){
            $res = $result->fetch();
            $result->closeCursor();
            return $res;
        }
        return false;
        
    }

    
    public function setID($id) {
        return $this->id=$id;
    }

    public function getID() {
        return $this->id;
    }
    public function setDetails($details) {
        return $this->details=$details;
    }

    public function getDetails() {
        return $this->aboudetailst_us;
    }

}
