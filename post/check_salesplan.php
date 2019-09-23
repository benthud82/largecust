<?php

include_once '../config/database.php';

if (isset($_POST['val_salesplan']) && !empty($_POST['val_salesplan'])) {
    $sptest = $_POST['val_salesplan'];
    $database2 = new Database();
    $db2 = $database2->getConnection();
    $st = $db2->prepare("SELECT DISTINCT
                                            (SALESPLAN)
                                        FROM
                                            custaudit.salesplan
                                        WHERE
                                            UPPER(SALESPLAN) = UPPER('$sptest')");
    $st->execute();
    $sparray = $st->fetchAll(pdo::FETCH_ASSOC);

    if (isset($sparray) && !empty($sparray)) {
        echo'success';
    } else {
        echo 'X';
    }
}
