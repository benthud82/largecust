<?php

include_once '../../connections/conn_slotting.php';
include_once '../../globalincludes/usa_asys.php';


$sqldelete = "TRUNCATE largecust.status_inv";
$querydelete = $conn1->prepare($sqldelete);
$querydelete->execute();

$whsearray = array(2, 3, 6, 7, 9);

foreach ($whsearray as $whse) {

//Items currently on BO
    $sqlbo = $aseriesconn->prepare("SELECT WRSWHS,WRSITM,WRSONR,WRSONH,WRSBOQ FROM HSIPCORDTA.NPFWRS WHERE WRSWHS = $whse and WRSONR + WRSONH + WRSBOQ > 0 and WRSAVL = ' '");
    $sqlbo->execute();
//    $arraybo = $sqlbo->fetchAll(PDO::FETCH_ASSOC);

    $columns = 'inv_whse, inv_item, inv_onorder, inv_onhand, inv_boq';


    $values = array();

    $maxrange = 3999;
    $counter = 0;
//    $rowcount = count($arraybo);
    $rowcount = 999999999999;

    do {
        if ($maxrange > $rowcount) {  //prevent undefined offset
            $maxrange = $rowcount - 1;
        }

        $data = array();
        $values = array();
    while ($counter <= $maxrange) { //split into 5,000 lines segments to insert into merge table
        while ($row = $sqlbo->fetch(PDO::FETCH_ASSOC)) {
            $inv_whse = intval($row['WRSWHS']);
            $inv_item = intval($row['WRSITM']);
            $inv_onorder = intval($row['WRSONR']);
            $inv_onhand = intval($row['WRSONH']);
            $inv_boq = intval($row['WRSBOQ']);

            $data[] = "($inv_whse, $inv_item, $inv_onorder, $inv_onhand, $inv_boq)";
            $counter += 1;
        }
    }

        $values = implode(',', $data);

        if (empty($values)) {
            break;
        }
        $sql = "INSERT IGNORE INTO largecust.status_inv ($columns) VALUES $values";
        $query = $conn1->prepare($sql);
        $query->execute();
        $maxrange += 4000;
    } while ($counter <= $rowcount);
}