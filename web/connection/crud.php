<?php

function select($con, $sql)
{
    if ($sql_select = $con->prepare($sql)) {
        $sql_select->execute();

        $data = $sql_select->get_result();
        if ($data->num_rows > 0) {
            return $data;
        } else {
            echo "Error fetching data";
        }
        $sql_select->close();
    } else {
        echo "Error sql query";
    }
}
//"INSERT INTO `car_table` (`car_id`, `car_name`, `car_type`, `car_brand`, `car_price`, `car_color`, `file_path`) VALUES (NULL, '$car_name', '$car_type ', '$car_brand', '$car_price', '$car_color','$image_path')";
function insert($con, $sql_insert)
{
    if ($queried_data = $con->prepare($sql_insert)) {
        if ($queried_data->execute()) {
            header("location: main.php?insert=1");
            exit();
        } else {
            header("location: main.php?insert=0");
            exit();
        }
        $queried_data->close();
    } else {
        header("location: main.php?insert=0");
        exit();
    }
}
