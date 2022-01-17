<?php
class Product{
 
    // database connection and table name
    private $conn;
    private $table_name = "gb_qc_samples"; //products

	// object properties
	public $moisture_rate;
	public $plus_70;
	public $minus_40_plus_70;
	public $minus_70;
	public $minus_70_plus_140;
	public $plus_140;
	public $minus_140;
	public $location_id;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
	
	
	// read products
	function read(){
	 
		// select all query
		$query = "select 
					moisture_rate,
					plus_70,
					minus_40_plus_70,
					minus_70,
					minus_70_plus_140,
					plus_140,
					minus_140,
					location_id from gb_qc_samples";
	
	 
		// prepare query statement
		$stmt = $this->conn->prepare($query);
	 
		// execute query
		$stmt->execute();
	 
		return $stmt;
	}
}