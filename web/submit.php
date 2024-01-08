<?php
include_once "./connection/connect.php";
include_once "./connection/crud.php";

$car_name = trim($_POST['car_name']);
$car_type = trim($_POST['car_type']);
$car_brand = trim($_POST['car_brand']);
$car_price = trim($_POST['car_price']);
$car_color = trim($_POST['car_color']);


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file_path"])) {
    $target_dir = "./uploads/";
    $target_file = $target_dir . basename($_FILES["file_path"]["name"]); // "./uploads/image.jpeg"
    if (!file_exists($target_file)) {
        if (move_uploaded_file($_FILES["file_path"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
            $sql_insert = "INSERT INTO `car_table` (`car_id`, `car_name`, `car_type`, `car_brand`, `car_price`, `car_color`, `file_path`) VALUES (NULL, '$car_name', '$car_type ', '$car_brand', '$car_price', '$car_color','$image_path')";
            insert($conn, $sql_insert);
        }
    } else {
        header("location: ./src/index.php?file_already_exist=1");
        exit();
    }
}
$conn->close();
// header('location: http://localhost/web/index.php');
