<?php 
require_once 'Database.php';
require_once 'Operations.php';


class Contacts extends Database implements Operations { 

    var $fb,$twitter,$linkedin,$instagram,$youtube,$phone,$email;

    
  
    public function Add() {
        
        return $this->RunDML("INSERT INTO contacts (id, fb, twitter, linkedin,instagram,youtube,phone) VALUES(1,?,?,?,?,?,?,?)",[$this->fb,$this->twitter,$this->linkedin,$this->instagram,$this->youtube,$this->phone,$this->email],"Contacts are Added");

    }
    
    public function Update() {

        return $this->RunDML("UPDATE contacts SET  fb = ?, twitter= ?, linkedin = ?,instagram= ?, youtube = ? ,phone= ?, email= ? WHERE id = 1",[$this->fb,$this->twitter,$this->linkedin,$this->instagram,$this->youtube,$this->phone,$this->email],"Contacts are Updated");

    }

    public function Delete() {
        return $this->RunDML("DELETE FROM contacts WHERE id = 1","Contacts Deleted!");
    }

    public function Search() {
        $result = $this->pdo->query("SELECT * FROM contacts");
     
        return $result->rowCount() > 0 ? $result->fetch(): false;
    }
    


    public function setFB($fb) {
        return $this->fb=$fb;
    }

    public function getFB() {
        return $this->fb;
    }
    public function setTwitter($twitter) {
        return $this->twitter=$twitter;
    }

    public function getTwitter() {
        return $this->twitter;
    }

    public function setLinkedin($linkedin) {
        return $this->linkedin=$linkedin;
    }

    public function getLinkedin() {
        return $this->linkedin;
    }
    public function setInstagram($instagram) {
        return $this->instagram=$instagram;
    }

    public function getInstagram() {
        return $this->instagram;
    }
    public function setYoutube($youtube) {
        return $this->youtube=$youtube;
    }

    public function getYoutube() {
        return $this->youtube;
    }
    public function setPhone($phone) {
        return $this->phone=$phone;
    }

    public function getPhone() {
        return $this->phone;
    }
    public function setEmail($email) {
        return $this->email=$email;
    }

    public function getEmail() {
        return $this->email;
    }


}

?>