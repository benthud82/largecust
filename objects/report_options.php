<?php

class Report_list {

    // database connection and table name
    protected $conn;
    protected $table_name = "qtr_reports";
    // object properties
    public $report_id;
    public $report_title;
    public $report_desc;

    public function __construct($db) {
        $this->conn = $db;
    }

    // used by select drop-down list
    function read_list() {
        //select all data
        $query = "SELECT
                    report_id, report_title, report_desc
                FROM
                    " . $this->table_name . "
                ORDER BY
                    report_id";

        $stmt_list = $this->conn->prepare($query);
        $stmt_list->execute();

        return $stmt_list;
    }

}

class Report_display extends Report_list {

    public $report_imgpath;
    public $report_modal;
    public $modal_id;
    public $modal_name;
    public $modal_buttontext;
    protected $table_name_join = "reports_modal";

    // used by select drop-down list
    function read_display() {
        //select all data
        $query = "SELECT
                    report_id, report_title, report_desc, report_imgpath, report_modal, modal_id, modal_name, modal_buttontext
                FROM
                    " . $this->table_name . "
                        JOIN   " . $this->table_name_join . "
                ORDER BY
                    report_id";

        $stmt_display = $this->conn->prepare($query);
        $stmt_display->execute();

        return $stmt_display;
    }

}

?>