<?php
include "Database.php";
$db = new Database();
$result_array = [];
$sql = "SELECT * FROM `product_db`";
$result = $db->dbQuery($sql);
$rows = $db->dbFetchArray($result);
if ($db->dbNumRows() > 0) {
    foreach ($rows as $row) {
        array_push($result_array, $row);
    }
}
// header('Content-Type: application/json');
echo json_encode($result_array);
