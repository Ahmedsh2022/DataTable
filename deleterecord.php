<?php
include 'Database.php';
$db = new Database();
$id = $_GET['id'];
$arr = array();
$sql = "DELETE FROM `product_db` WHERE id = $id";
$result = $db->dbQuery($sql);
$arr[] = "حذف العنصر";
echo json_encode($arr);
