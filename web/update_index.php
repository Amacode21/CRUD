<?php
session_start();
include_once "./connection/connect.php";
include_once "./connection/crud.php";

$car_id = $_GET['id'];
$sql_display_all = "SELECT * FROM `car_table` WHERE `car_id` = '$car_id'";

$cars = select($conn, $sql_display_all);

if (!isset($_SESSION['keep_change_data'])) {
    $_SESSION['keep_change_data'] = array(); // Initalize an array;
}

// This function will check if there is a data that keep in `Keep Changes`;
function isExist($arr, $target)
{
    try {
        if ($arr == Null) {
            return false;
        }
        for ($i = 0; $i < count($arr); $i++) {
            if ($arr[$i]["car_id"] == $target) {
                return $arr[$i];
            };
        }
        return false;
    } catch (Exception $e) {
        return false;
    }
}

function selectedIndex($opt_1, $opt_2, $val)
{
    if ($opt_1) {
        if ($opt_1 == $val) {
            return "selected";
        }
    } else {
        if ($opt_2 == $val) {
            return "selected";
        }
    }
    return "";
}
if (isset($_POST['submit'])) {
    $new_car_name = trim($_POST['car_name']);
    $new_car_brand = trim($_POST['car_brand']);
    $new_car_type = trim($_POST['car_type']);
    $new_car_color = trim($_POST['car_color']);
    $new_car_price = trim($_POST['car_price']);

    if ($sql_update = $conn->prepare("UPDATE `car_table` SET `car_name` = ? , `car_brand` = ? , `car_type` = ? , `car_color`= ?, `car_price` = ? WHERE `car_id` = ?")) {
        $sql_update->bind_param("sssssi", $new_car_name, $new_car_brand, $new_car_type, $new_car_color, $new_car_price, $car_id);
        if ($sql_update->execute()) {
            header('location: main.php?update=1');
            exit();
        } else {
            header('location: main.php?update=0');
            exit();
        }
        $sql_update->close();
    }
}

if (isset($_POST['keep_change'])) {
    $keep_car_name = trim($_POST['car_name']);
    $keep_car_brand = trim($_POST['car_brand']);
    $keep_car_type = trim($_POST['car_type']);
    $keep_car_color = trim($_POST['car_color']);
    $keep_car_price = trim($_POST['car_price']);

    $get_keep_data = isExist($_SESSION['keep_change_data'], $car_id);

    if ($get_keep_data) {
        for ($i = 0; $i < count($_SESSION['keep_change_data']); $i++) {
            if ($_SESSION['keep_change_data'][$i]["car_id"] == $car_id) {
                $_SESSION['keep_change_data'][$i]["car_name"] = $keep_car_name;
                $_SESSION['keep_change_data'][$i]["car_brand"] = $keep_car_brand;
                $_SESSION['keep_change_data'][$i]["car_type"] =  $keep_car_type;
                $_SESSION['keep_change_data'][$i]["car_color"] = $keep_car_color;
                $_SESSION['keep_change_data'][$i]["car_price"] = $keep_car_price;
            }
        }
    } else {
        $_SESSION['keep_change_data'][] = [
            "car_id" => $car_id,
            "car_name" => $keep_car_name,
            "car_brand" => $keep_car_brand,
            "car_type" => $keep_car_type,
            "car_color" => $keep_car_color,
            "car_price" => $keep_car_price
        ];
    }
    echo "<script>alert('Changes has been saved locally!')</script>";
}

if (isset($_POST['reset_form'])) {
    $get_keep_data = isExist($_SESSION['keep_change_data'], $car_id);
    if ($get_keep_data !== false) {
        for ($i = 0; $i < count($_SESSION['keep_change_data']); $i++) {
            if ($_SESSION['keep_change_data'][$i]["car_id"] == $car_id) {
                unset($_SESSION['keep_change_data'][$i]);
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Page</title>
    <link rel="icon" href="./img/ico.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/update_style.css">

</head>

<body class="d-flex justify-content-center align-items-center">
    <div class="d-flex gap-5 justify-content-center align-items-center flex-row-reverse w-75 border border-2 p-3 rounded-3 bg-light">
        <?php
        $get_keep = isExist($_SESSION['keep_change_data'], $car_id);
        while ($car = $cars->fetch_assoc()) { ?>

            <div class="w-50 border d-flex justify-content-center align-items-center">
                <img src="<?php echo $car['file_path'];  ?>" alt="car.jpg" height="400" width="500" class="rounded-3">
            </div>
            <div class="">
                <div class="d-flex justify-content-center align-items-center gap-4 w-100 mb-2">
                    <img src="./img/logo.jpeg" height="46" width="52" alt="logo.jpeg" class="rounded-5">
                    <h5 class="text-decoration-underline">Update Car</h5>
                </div>
                <form action="" method="post" enctype="multipart/form-data">

                    <div class="mb-2 d-flex justify-content-between align-items-center gap-2">
                        <label for="car_name">Name </label>
                        <input type="text" name="car_name" value="<?php echo $get_keep ? $get_keep['car_name'] : $car["car_name"]; ?>" class="form-control" required>
                    </div>
                    <div class="mb-2 d-flex justify-content-between align-items-center gap-2">
                        <label for="car_type">Transmission</label>
                        <select name="car_type" id="car_type" class="form-select" required>
                            <option value="Manual" <?php echo $get_keep ? selectedIndex($get_keep['car_type'], $car['car_type'], "Manual") : ($car['car_type'] == "Manual" ? "selected" : ""); ?>>Manual</option>
                            <option value="Automatic" <?php echo $get_keep ? selectedIndex($get_keep['car_type'], $car['car_type'], "Automatic") : ($car['car_type'] == "Automatic" ? "selected" : ""); ?>>Automatic</option>
                            <option value="ADV" <?php echo $get_keep ? selectedIndex($get_keep['car_type'], $car['car_type'], "ADV") : ($car['car_type'] == "ADV" ? "selected" : ""); ?>>ADV</option>
                        </select>
                    </div>
                    <div class="mb-2 d-flex justify-content-between align-items-center gap-2">
                        <label for="car_brand">Brand</label>
                        <select name="car_brand" id="car_brand" class="form-select" required>
                            <option value="Toyota" <?php echo $get_keep ? selectedIndex($get_keep['car_brand'], $car['car_brand'], "Toyota") : ($car['car_brand'] == "Toyota" ? "selected" : "") ?>>Toyota</option>
                            <option value="Hyundai" <?php echo $get_keep ? selectedIndex($get_keep['car_brand'], $car['car_brand'], "Hyundai") : ($car['car_brand'] == "Hyundai" ? "selected" : "") ?>>Hyundai</option>
                            <option value="BMW" <?php echo $get_keep ? selectedIndex($get_keep['car_brand'], $car['car_brand'], "BMW") : ($car['car_brand'] == "BMW" ? "selected" : "") ?>>BMW</option>
                            <option value="Ford" <?php echo $get_keep ? selectedIndex($get_keep['car_brand'], $car['car_brand'], "Ford") : ($car['car_brand'] == "Ford" ? "selected" : "") ?>>Ford</option>
                            <option value="Mercedes-Benz" <?php echo $get_keep ? selectedIndex($get_keep['car_brand'], $car['car_brand'], "Mercedes-Benz") : ($car['car_brand'] == "Mercedes-Benz" ? "selected" : "") ?>>Mercedes-Benz</option>
                            <option value="Lamborghini" <?php echo $get_keep ? selectedIndex($get_keep['car_brand'], $car['car_brand'], "Lamborghini") : ($car['car_brand'] == "Lamborghini" ? "selected" : "") ?>>Lamborghini</option>
                            <option value="Tesla" <?php echo $get_keep ? selectedIndex($get_keep['car_brand'], $car['car_brand'], "Tesla") : ($car['car_brand'] == "Tesla" ? "selected" : "") ?>>Tesla</option>
                        </select>
                    </div>
                    <div class="mb-2 d-flex justify-content-between align-items-center gap-2 position-relative">
                        <label for="car_price">Price </label>
                        <input type="text" name="car_price" placeholder="$" value="<?php echo $get_keep ? $get_keep['car_price'] : $car["car_price"]; ?>" id="car_price" class="form-control" required>
                        <div id="reminder_edit" class="position-absolute" style="right: 10px;visibility:hidden; font-size:14px">
                            <small>You can't edit this field</small>
                        </div>
                    </div>
                    <div class="mb-4 d-flex justify-content-between align-items-center gap-2">
                        <label for="car_color">Color </label>
                        <input type="text" name="car_color" value="<?php echo $get_keep ? $get_keep['car_color'] : $car["car_color"]; ?>" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <small><label for="file_path">Put car image here </label></small>
                        <input class="form-control bg-primary-subtle opacity-50" type="file" name="file_path" disabled>
                    </div>
                <?php } ?>
                <input type="submit" name="submit" value="Update" class="btn p-3 w-100 mt-3 fw-semibold" style="background-color:#222831; color:#EEEEEE">
                <div class="w-100 mt-2 d-flex justify-content-between align-items-center gap-2">
                    <a href="main.php" class="btn btn-danger flex-fill">Discard</a>
                    <input class="btn btn-success flex-fill" type="submit" value="Keep Changes" name="keep_change" id="keep_change">
                    <input class="btn btn-dark flex-fill" type="submit" name="reset_form" value="Reset Form" id="reset_form">
                </div>
                </form>
            </div>
    </div>
    <script src="javascript/update_script.js"></script>
</body>

</html>