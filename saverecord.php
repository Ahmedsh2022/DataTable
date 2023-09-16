<?php
include "Database.php";
$db = new Database();
$phone_name = $_POST['uphone_name'];
$category = $_POST['ucategory'];
$price = $_POST['uprice'];
$image = $_FILES['uimage']['name'];

if ($image == '') {
    $file_name = 'no-image.png';
} else {
    $file_name = rand(10000, 100000) . $_FILES['uimage']['name'];
    move_uploaded_file($_FILES['uimage']['tmp_name'], 'image/' . $file_name);
}

$sql = "INSERT INTO `product_db`(phone_name,category,price,image)
       values('$phone_name','$category','$price','$file_name')";

$rs = $db->dbQuery($sql);
if ($rs) {
    echo json_encode(array('status' => true, 'msg' => 'تمت عملت الإضافة بنجاح', 'image' => $image));
} else {
    echo json_encode(array('status' => false, 'msg' => 'حدث خطأ في عملت الإضافة '));
}
