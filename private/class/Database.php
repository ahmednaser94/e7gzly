<?php


class Database extends PDO
{
    // make connection 
    var $pdo;
    var $db='nq';
    var $host='localhost';
    var $username='root';
    var $pass='';
    
    // make connection with DB
    function __construct()
    {
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->db;
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br>";
            die();
        }
    }

    public function RUNDML($sql, $bind=NULL,$msg=NULL) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bind);
        if(!$stmt) {
            print_r($stmt->errorInfo());
        }
        $stmt->closeCursor();
        return $msg;
    }

    public function RUNSearch($sql, $bind=NULL) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($bind);
        if(!$stmt) {
            print_r($stmt->errorInfo());
        }

        return $stmt;
    }

    
    function __destruct() {
        $this->pdo = null;
    }
}
