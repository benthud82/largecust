<?php

class Quarters {

    // database connection and table name
    protected $conn;
    protected $table_name = "dates_quarters";
    public $qtr_name;

    public function __construct($db) {
        $this->conn = $db;
    }

//used for checkbox list of reports to include
    function select_qtr() {
        //select all data
        $query = "SELECT
                    qtr_name
                FROM
                    " . $this->table_name . "
                        WHERE     qtr_startdate >= DATE_ADD(LAST_DAY(DATE_SUB(NOW(), INTERVAL 7 MONTH)), INTERVAL 1 DAY)
                                            AND qtr_startdate <= DATE_ADD(NOW(), INTERVAL 7 MONTH)
                ORDER BY
                    qtr_startdate asc";

        $stmt_qtr = $this->conn->prepare($query);
        $stmt_qtr ->execute();

        return $stmt_qtr ;
    }

}
