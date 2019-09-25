<?php

include_once '../../connections/conn_slotting.php';
include_once '../../globalincludes/usa_asys.php';
include_once '../../CustomerAudit/functions/customer_audit_functions.php';
set_time_limit(99999);
$var_rollmonthjdate = _rollmonth1yyddd();

$sqldelete = "TRUNCATE largecust.dcstats";
$querydelete = $conn1->prepare($sqldelete);
$querydelete->execute();

$whsearray = array(2, 3, 6, 7, 9);
$columns = 'dcstats_whse,
dcstats_item,
dcstats_nsi,
dcstats_bo,
dcstats_stkxs,
dcstats_nonstkxs,
dcstats_totalfr,
dcstats_totallines,
dcstats_beffr';

foreach ($whsearray as $whse) {

//Items currently on BO
    $sqlbo = $aseriesconn->prepare("SELECT DISTINCT ORD_PWHS,
                                    ITEM,
                                    sum(case when A.IP_FIL_TYP = 'XD' then 1 else 0 end) as XD ,
                                    sum(case when A.IP_FIL_TYP = 'BO' then 1 else 0 end) as BO ,
                                    sum(case when A.IP_FIL_TYP = 'XS' then 1 else 0 end) as XS ,
                                    sum(case when A.IP_FIL_TYP = 'XE' then 1 else 0 end) as XE,
                                    sum(case when A.IP_FIL_TYP = 'XD' then 1 else 0 end) +
                                    sum(case when A.IP_FIL_TYP = 'BO' then 1 else 0 end) +
                                    sum(case when A.IP_FIL_TYP = 'XS' then 1 else 0 end) +
                                    sum(case when A.IP_FIL_TYP = 'XE' then 1 else 0 end) as TOTAL_FR,
                                    sum(case when A.IP_FIL_TYP = 'XD' then 1 else 1 end) as TOTAL_LINES,
                                    DECIMAL(100-(((sum(case when A.IP_FIL_TYP = 'XD' then 1 else 0 end) +
                                    sum(case when A.IP_FIL_TYP = 'BO' then 1 else 0 end) +
                                    sum(case when A.IP_FIL_TYP = 'XS' then 1 else 0 end) +
                                    sum(case when A.IP_FIL_TYP = 'XE' then 1 else 0 end)) / DECIMAL(sum(case when A.IP_FIL_TYP = 'XD' then 1 else 1 end),10,4)) * 100),5,2) as BEFFR

                                    FROM HSIPCORDTA.IM0011 A

                                    WHERE A.OR_DATE >=  $var_rollmonthjdate and ORD_PWHS = $whse
                                    and LENGTH(RTRIM(TRANSLATE(ITEM, '*', ' 0123456789'))) = 0

                                    GROUP BY ORD_PWHS, ITEM");
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
                $dcstats_whse = $row['ORD_PWHS'];
                $dcstats_item = $row['ITEM'];
                $dcstats_nsi = $row['XD'];
                $dcstats_bo = $row['BO'];
                $dcstats_stkxs = $row['XS'];
                $dcstats_nonstkxs = $row['XE'];
                $dcstats_totalfr = $row['TOTAL_FR'];
                $dcstats_totallines = $row['TOTAL_LINES'];
                $dcstats_beffr = $row['BEFFR'];

                $data[] = "($dcstats_whse,$dcstats_item,$dcstats_nsi,$dcstats_bo,$dcstats_stkxs,$dcstats_nonstkxs,$dcstats_totalfr,$dcstats_totallines,'$dcstats_beffr')";
                $counter += 1;
            }
        }

        $values = implode(',', $data);

        if (empty($values)) {
            break;
        }
        $sql = "INSERT IGNORE INTO largecust.dcstats ($columns) VALUES $values";
        $query = $conn1->prepare($sql);
        $query->execute();
        $maxrange += 4000;
    } while ($counter <= $rowcount);
}