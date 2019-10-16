<?php 
require_once 'Organization.php';

class Area extends Organization implements Operations {
    
    var $area_id;

    public function setAreaID($area_id) {
        return $this->area_id=$area_id;
    }

    public function getAreaID() {
        return $this->area_id;
    }

    public function Add() {
        // check if this area already exists
        $check = $this->RUNSearch('SELECT name FROM area WHERE name = ?',[$this->name]);

        if($check->fetch()){
            return "Branch already exists";
        }
        else {
            return $this->RunDML('INSERT INTO area (name) VALUES (?)',[$this->name],'Area successfully Added!');
        }
    }
    public function Update() {
        return $this->RunDML("UPDATE area SET name= ? WHERE id = ?",[$this->name,$this->area_id],"Area Updated!");
    }

    public function Delete() {
        return $this->RunDML("DELETE FROM area WHERE id = ?",[$this->area_id],"Area Deleted!");
        
    }

    public function Search() {
        return false;
    }
    
    // get all areas 
    public function getAreas() {
        $result = $this->RUNSearch('SELECT * FROM area ORDER BY name');
        return $result->rowCount() > 0 ? $result->fetchAll(): false;
    }



}

?>