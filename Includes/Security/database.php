<?php

require_once('/var/www/configuration/db-mysql-sandbox.php'); //contains mysql database connection info
require_once('/var/www/configuration/db-mysql-silicore.php'); //contains mysql database connection info
require_once('/var/www/configuration/db-mssql-vistasql1.php'); //contains mssql database connection info
require_once('/var/www/configuration/db-mssql-tlsql1.php'); //contains mssql database connection info
require_once('/var/www/configuration/db-mssql-themine.php'); //contains mysql database connection info
require_once('/var/www/configuration/db-mssql-datafortransfer.php'); //contains mssql database connection info
require_once('/var/www/configuration/db-mysql-backoffice.php'); //contains mysql database connection info
require_once('/var/www/configuration/email-system.php'); //contains mysql database connection info


class Database
{
    // specify your own database credentials
    private $silicore_dbname = SILICORE_DB_DBNAME;
    private $silicore_username = SILICORE_DB_USER;
    private $silicore_pwd = SILICORE_DB_PWD;
    private $silicore_hostname = SILICORE_DB_HOST;
    public $conn;

    public function get($sproc)
    {

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->silicore_hostname . ";dbname=" . $this->silicore_dbname, $this->silicore_username, $this->silicore_pwd);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
            $this->conn->exec("set names utf8");

        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        $data = array();

        $query = "CALL " . $sproc;

        $stmt = $this->conn->prepare($query);

        $success = $stmt->execute();


        if ($success === true) {

            $results = $stmt->rowCount();

            if ($results > 0) {

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    $data[] = $row;

                }

                return json_encode($data);

            } else {

                return 0;

            }

        } else {
            return $sproc . ' failed.';
        }
    }
    public function insert($sproc)
    {

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->silicore_hostname . ";dbname=" . $this->silicore_dbname, $this->silicore_username, $this->silicore_pwd);

            $this->conn->exec("set names utf8");

        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        $query = "CALL " . $sproc;

        $stmt = $this->conn->prepare($query);

 $stmt->execute();

        $results = $stmt->rowCount();


        if ($results > 0) {

            return 1;

            }
            else {

            return $stmt->errorInfo();
        }
    }

}
