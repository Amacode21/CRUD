<?php
include_once "./connection/connect.php";


if (isset($_POST["delete"])) {
    $car_id = $_POST["car_id"];

    if ($sql = $conn->prepare("SELECT `file_path` FROM `car_table` WHERE `car_id` = ?")) {
        $sql->bind_param("i", $car_id);
        if ($sql->execute()) {
            $file_path = $sql->get_result()->fetch_assoc();
            if (unlink($file_path['file_path'])) {
                if ($sql_del = $conn->prepare("DELETE FROM `car_table` WHERE car_id = ?")) {
                    $sql_del->bind_param("i", $car_id);
                    if ($sql_del->execute()) {
                        echo "Successfully Deleted photo from database";
                    } else {
                        exit("Error Deleting photo");
                    }
                    $sql_del->close();
                }
            }
        } else {
            exit("Error: " . $conn->error);
        }
    }
    $sql->close();
};
Header("location: main.php");
exit();
