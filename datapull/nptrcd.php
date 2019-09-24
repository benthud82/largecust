<?php

include_once '../../connections/conn_slotting.php';
include_once '../../globalincludes/usa_asys.php';


$sqldelete = "TRUNCATE largecust.nptrcd";
$querydelete = $conn1->prepare($sqldelete);
$querydelete->execute();

$whsearray = array(2, 3, 6, 7, 9);
$columns = 'WAREHOUSE,SUPPLIER,ITEM_NUMBER,AVG_REC_QTY,SMA_REC_QTY,SD_REC_QTY,DAYS_LST_REC,AVGD_BTW_REC,SMAD_BTW_REC,SDD_BTW_REC,AVG_LEAD_TIM,SD_LEAD_TIM,SM_MEAN,AVG_FST_FILL,AVG_PER_FILL,AVG_POURF_DAY,AVG_URFRC_DAY,AVG_RCPUT_DAY,SD_POURF_DAY,SD_URFRC_DAY,SD_RCPUT_DAY,SMA_POURF_DAY,SMA_URFRC_DAY,SMA_RCPUT_DAY,HIST_RECEIPT,FILRAT_RECPT,AGVLED_TIME';

foreach ($whsearray as $whse) {

//Items currently on BO
    $sqlbo = $aseriesconn->prepare("SELECT NPTRCD.WAREHOUSE, CASE WHEN SUPPLIER = ' ' then 'NA' else SUPPLIER end as SUPPLIER, NPTRCD.ITEM_NUMBER, NPTRCD.AVG_REC_QTY, NPTRCD.SMA_REC_QTY, NPTRCD.SD_REC_QTY, NPTRCD.DAYS_LST_REC, NPTRCD.AVGD_BTW_REC, NPTRCD.SMAD_BTW_REC, NPTRCD.SDD_BTW_REC, NPTRCD.AVG_LEAD_TIM, NPTRCD.SD_LEAD_TIM, NPTRCD.SM_MEAN, NPTRCD.AVG_FST_FILL, NPTRCD.AVG_PER_FILL, NPTRCD.AVG_POURF_DAY, NPTRCD.AVG_URFRC_DAY, NPTRCD.AVG_RCPUT_DAY, NPTRCD.SD_POURF_DAY, NPTRCD.SD_URFRC_DAY, NPTRCD.SD_RCPUT_DAY, NPTRCD.SMA_POURF_DAY, NPTRCD.SMA_URFRC_DAY, NPTRCD.SMA_RCPUT_DAY, NPTRCD.HIST_RECEIPT, NPTRCD.FILRAT_RECPT, NPTRCD.AGVLED_TIME
FROM A.HSIPCORDTA.NPTRCD NPTRCD WHERE WAREHOUSE = $whse and LENGTH(RTRIM(TRANSLATE(ITEM_NUMBER, '*', ' 0123456789'))) = 0");
    $sqlbo->execute();




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
                $WAREHOUSE = $row['WAREHOUSE'];
                $SUPPLIER = $row['SUPPLIER'];
                $ITEM_NUMBER = $row['ITEM_NUMBER'];
                $AVG_REC_QTY = $row['AVG_REC_QTY'];
                $SMA_REC_QTY = $row['SMA_REC_QTY'];
                $SD_REC_QTY = $row['SD_REC_QTY'];
                $DAYS_LST_REC = $row['DAYS_LST_REC'];
                $AVGD_BTW_REC = $row['AVGD_BTW_REC'];
                $SMAD_BTW_REC = $row['SMAD_BTW_REC'];
                $SDD_BTW_REC = $row['SDD_BTW_REC'];
                $AVG_LEAD_TIM = $row['AVG_LEAD_TIM'];
                $SD_LEAD_TIM = $row['SD_LEAD_TIM'];
                $SM_MEAN = $row['SM_MEAN'];
                $AVG_FST_FILL = $row['AVG_FST_FILL'];
                $AVG_PER_FILL = $row['AVG_PER_FILL'];
                $AVG_POURF_DAY = $row['AVG_POURF_DAY'];
                $AVG_URFRC_DAY = $row['AVG_URFRC_DAY'];
                $AVG_RCPUT_DAY = $row['AVG_RCPUT_DAY'];
                $SD_POURF_DAY = $row['SD_POURF_DAY'];
                $SD_URFRC_DAY = $row['SD_URFRC_DAY'];
                $SD_RCPUT_DAY = $row['SD_RCPUT_DAY'];
                $SMA_POURF_DAY = $row['SMA_POURF_DAY'];
                $SMA_URFRC_DAY = $row['SMA_URFRC_DAY'];
                $SMA_RCPUT_DAY = $row['SMA_RCPUT_DAY'];
                $HIST_RECEIPT = $row['HIST_RECEIPT'];
                $FILRAT_RECPT = $row['FILRAT_RECPT'];
                $AGVLED_TIME = $row['AGVLED_TIME'];

                $data[] = "($WAREHOUSE,'$SUPPLIER',$ITEM_NUMBER,'$AVG_REC_QTY','$SMA_REC_QTY','$SD_REC_QTY',$DAYS_LST_REC,'$AVGD_BTW_REC','$SMAD_BTW_REC','$SDD_BTW_REC','$AVG_LEAD_TIM','$SD_LEAD_TIM','$SM_MEAN','$AVG_FST_FILL','$AVG_PER_FILL','$AVG_POURF_DAY','$AVG_URFRC_DAY','$AVG_RCPUT_DAY','$SD_POURF_DAY','$SD_URFRC_DAY','$SD_RCPUT_DAY','$SMA_POURF_DAY','$SMA_URFRC_DAY','$SMA_RCPUT_DAY',$HIST_RECEIPT,$FILRAT_RECPT,$AGVLED_TIME)";
                $counter += 1;
            }
        }

        $values = implode(',', $data);

        if (empty($values)) {
            break;
        }
        $sql = "INSERT IGNORE INTO largecust.nptrcd ($columns) VALUES $values";
        $query = $conn1->prepare($sql);
        $query->execute();
        $maxrange += 4000;
    } while ($counter <= $rowcount);
}