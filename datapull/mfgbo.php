<?php
include_once '../../connections/conn_slotting.php';

$sqldelete = "TRUNCATE largecust.mfgbo";
$querydelete = $conn1->prepare($sqldelete);
$querydelete->execute();


$sqlinsert = "INSERT INTO largecust.mfgbo (SELECT 
    A.inv_item,
    SUM(A.inv_onorder),
    SUM(A.inv_onhand),
    SUM(A.inv_boq),
    AVG(DC_A.dcstats_beffr),
    SUM(DC_A.dcstats_totalfr),
    (SELECT 
            COUNT(*)
        FROM
            custaudit.openpo
        WHERE
            inv_item = OPENITEM
        GROUP BY OPENITEM) AS CNT_OPENPO
FROM
    largecust.status_inv A
        JOIN
    largecust.dcstats DC_A ON A.inv_whse = DC_A.dcstats_whse
        AND DC_A.dcstats_item = A.inv_item
GROUP BY A.inv_item
HAVING AVG(DC_A.dcstats_beffr) <= 80
    AND SUM(A.inv_boq) > 50
    AND SUM(DC_A.dcstats_totalfr) > 50)";
$queryinsert = $conn1->prepare($sqlinsert);
$queryinsert->execute();