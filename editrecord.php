<?php
include "Database.php";
$db = new Database();
$id = $_GET['id'];

if (isset($_FILES['uimage_edit']['name'])) {
    $image = $_FILES['uimage_edit']['name'];
}
$phone_name = $_POST['uphone_name_edit'];
$category = $_POST['ucategory_edit'];
$price = $_POST['uprice_edit'];



if (empty($image)) {
    $sql = "UPDATE  `product_db` SET
                phone_name = '$phone_name', 
                category = '$category', 
                price = '$price'
                WHERE id = '$id'";

    $result = $db->dbQuery($sql);
    if ($result) {
        echo json_encode(array('status' => true, 'msg' => 'تمت عملية التعديل بنجاح', 'image' => $image));
    } else {
        echo json_encode(array('status' => false, 'msg' => 'حدث خطأ في عملية التعديل '));
    }
} else {
    //update Image and other data
    $file_name = rand(10000, 100000) . $image;
    move_uploaded_file($_FILES['uimage_edit']['tmp_name'], "image/" . $file_name);
    $sql = "UPDATE  `product_db` SET
                phone_name = '$phone_name', 
                category = '$category', 
                price = '$price',
                image = '$file_name' 
                WHERE id = '$id'";

    $rs = $db->dbQuery($sql);
    if ($rs) {
        echo json_encode(array('status' => true, 'msg' => 'تمت عملية التعديل بنجاح', 'image' => $image));
    } else {
        echo json_encode(array('status' => false, 'msg' => 'حدث خطأ في عملية التعديل '));
    }
}
