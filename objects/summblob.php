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

    //post blob to table
    function post_summblob() {

        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    idsummary_blob=:idsummary_blob, blob_date=:blob_date, blob_blob=:blob_blob, blob_qtr=:blob_qtr";

        $stmt_blobpost = $this->conn->prepare($query);

        // posted values
        $this->blob_blob = htmlspecialchars(strip_tags($this->blob_blob));
        $this->blob_qtr = htmlspecialchars(strip_tags($this->blob_qtr));

        // to get time-stamp for 'created' field
        $this->blob_date = date('Y-m-d H:i:s');

        //auto id
        $this->idsummary_blob = 0;

        // bind values 
        $stmt_blobpost->bindParam(":idsummary_blob", $this->idsummary_blob);
        $stmt_blobpost->bindParam(":blob_date", $this->blob_date);
        $stmt_blobpost->bindParam(":blob_blob", $this->blob_blob);
        $stmt_blobpost->bindParam(":blob_qtr", $this->blob_qtr);

        if ($stmt_blobpost->execute()) {
            return true;
        } else {
            return false;
        }
    }

}
