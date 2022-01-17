<?php
class Database{
 
    // specify your own database credentials
    private $host = "SANDBOX_DB_HOST";
    private $db_name = "SANDBOX_DB_DBNAME001"; //api
    private $username = "SANDBOX_DB_USER";
    private $password = "SANDBOX_DB_PWD";
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>