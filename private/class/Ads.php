<?php 
require_once 'Database.php';
require_once 'Operations.php';

class Ads extends Database implements Operations { 
    var $ad_id, $name, $details, $start_date, $end_date, $url;


    public function Add() {
        return $this->RunDML("INSERT INTO ads (name, details, start_date, end_date, url) VALUES(?,?,?,?,?)",[$this->name,$this->details,$this->start_date,$this->end_date,$this->url],"Ad is Added");

    }
    public function Update() {
        return $this->RunDML("UPDATE ads SET name = ?, details = ?, start_date = ?, end_date = ?, url = ? WHERE id = ?",[$this->name,$this->details,$this->start_date,$this->end_date,$this->url,$this->ad_id],"Ad is Updated");

    }
    public function Delete() {
        return $this->RunDML("DELETE FROM ads WHERE ad_id = ?",[$this->ad_id],"Ad Deleted");

    }
    public function Search() {
        
        
        
    }
    
    public function GetAds() {
        
    }


    public function setAdID($ad_id) {
        return $this->ad_id=$ad_id;
    }

    public function getAdID() {
        return $this->ad_id;
    }
    public function setName($name) {
        return $this->name=$name;
    }

    public function getName() {
        return $this->name;
    }
    public function setStartDate($start_date) {
        return $this->start_date=$start_date;
    }

    public function getStartDate() {
        return $this->start_date;
    }
    public function setEndDate($end_date) {
        return $this->end_date=$end_date;
    }

    public function getEndDate() {
        return $this->end_date;
    }
    public function setURL($url) {
        return $this->url=$url;
    }

    public function getURL() {
        return $this->url;
    }

}

?>