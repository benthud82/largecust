<?php
class Report{
 
    // database connection and table name
    private $conn;
    private $table_name = "qtr_reports";
 
    // object properties
    public $report_id;
    public $report_title;
    public $report_desc;
 
    public function __construct($db){
        $this->conn = $db;
    }
 
    // used by select drop-down list
    function read(){
        //select all data
        $query = "SELECT
                    report_id, report_title, report_desc
                FROM
                    " . $this->table_name . "
                ORDER BY
                    report_id";  
 
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
 
        return $stmt;
    }
 
}
?>