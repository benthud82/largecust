<?php

class Summary_blob {

    // database connection and table name
    protected $conn;
    protected $table_name = "summary_blob";
    // object properties
    public $idsummary_blob;
    public $blob_date;
    public $blob_blob;
    public $blob_qtr;

    public function __construct($db) {
        $this->conn = $db;
    }

    // read old summary blobs
    function read_blobs() {
        //select all data
        $query = "SELECT
                    idsummary_blob, blob_date, blob_blob, blob_qtr
                FROM
                    " . $this->table_name . "
                ORDER BY
                    blob_date desc";

        $stmt_summblob = $this->conn->prepare($query);
        $stmt_summblob->execute();

        return $stmt_summblob;
    }

}
