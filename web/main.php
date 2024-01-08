<?php
include_once "./connection/connect.php";
include_once "./connection/crud.php";


$sql_display_all = "SELECT * FROM car_table ORDER BY car_id DESC";
$cars = select($conn, $sql_display_all);

// Initialize this to used it in ternary operators after;
$car_type_value = '';
$car_brand_val = '';
$car_name_val = '';

// DOM -- will show an alert if there is no data query;
function noRecordFound()
{
    echo '
    <script>
        document.addEventListener("DOMContentLoaded",function(){
            const html = `
            <div class="alert alert-danger fixed-top start-50 end-0 m-2 alert-dismissible fade show" role="alert" id="alert">
                <strong>No record Found!</strong> This car does not exist!.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `;
            document.body.appendChild(document.createRange().createContextualFragment(html));
        });
    </script>
    ';
}

function is_inserted($successful)
{
    if ($successful == 0) {
        echo '
    <script>
        document.addEventListener("DOMContentLoaded",function(){
            const html = `
            <div class="alert alert-danger fixed-top start-50 end-0 m-2 alert-dismissible fade show" role="alert" id="alert">
                <strong>Error Inserting Car!</strong> Try to change car name or the image.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `;
            document.body.appendChild(document.createRange().createContextualFragment(html));
        });
    </script>
    ';
    } else {
        echo '
    <script>
        document.addEventListener("DOMContentLoaded",function(){
            const html = `
            <div class="alert alert-success fixed-bottom bottom-0 alert-dismissible fade show" role="alert" id="alert">
                <strong>Successfully Inserting Car!</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `;
            document.body.appendChild(document.createRange().createContextualFragment(html));
        });
    </script>
    ';
    }
}

if (isset($_GET['insert'])) {
    $isInserted = $_GET['insert'];
    is_inserted($isInserted);
}

function search_by_transmission_and_brand($car_type = null, $car_brand = null, $conn)
{
    if ($car_type == '*' and $car_brand == "*") {
        $res = select($conn, "SELECT * FROM `car_table` ORDER BY `car_id` DESC");
        return $res;
    } else if ($car_type != '*' and $car_brand == '*') {
        $query_car_type = $conn->prepare("SELECT * FROM `car_table` WHERE `car_type` = ?");
        $query_car_type->bind_param("s", $car_type);
        $query_car_type->execute();
        $res = $query_car_type->get_result();
        if ($res->num_rows > 0) {
            return $res;
        } else {
            noRecordFound();
            $default = select($conn, "SELECT * FROM `car_table` ORDER BY `car_id` DESC");
            return $default;
        }
        $query_car_type->close();
    } else if ($car_type == '*' and $car_brand != '*') {
        $query_car_brand = $conn->prepare("SELECT * FROM `car_table` WHERE `car_brand` = ?");
        $query_car_brand->bind_param("s", $car_brand);
        $query_car_brand->execute();
        $res = $query_car_brand->get_result();
        if ($res->num_rows > 0) {
            return $res;
        } else {
            noRecordFound();
            $default = select($conn, "SELECT * FROM `car_table` ORDER BY `car_id` DESC");
            return $default;
        }
        $query_car_brand->close();
    } else {
        if ($query = $conn->prepare("SELECT * FROM `car_table` WHERE `car_type` = ? AND `car_brand` = ?")) {
            $query->bind_param('ss', $car_type, $car_brand);
            if ($query->execute()) {
                $res = $query->get_result();
                if ($res->num_rows > 0) {
                    return $res;
                } else {
                    noRecordFound();
                    $default = select($conn, "SELECT * FROM `car_table` ORDER BY `car_id` DESC");
                    return $default;
                }
            }
            $query->close();
        }
    }
}


// Search Query for Brand and Transmission
if (isset($_POST["view"])) {
    $car_type = $_POST["car_type"];
    $car_brand = $_POST['car_brand'];

    $cars = search_by_transmission_and_brand($car_type, $car_brand, $conn);

    $car_type_value = $car_type;
    $car_brand_val = $car_brand;
}

if (isset($_POST['view_car_by_name'])) {
    $car_name = trim($_POST['car_name']);
    if ($query_car_name = $conn->prepare("SELECT * FROM `car_table` WHERE `car_name` = ?")) {
        $query_car_name->bind_param("s", $car_name);
        $query_car_name->execute();
        $result = $query_car_name->get_result();
        if ($result->num_rows > 0) {
            $cars = $result;
        } else {
            noRecordFound();
            $cars = select($conn, $sql_display_all);
        }
        $query_car_name->close();
    }
    $car_name_val = $car_name;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="css/main.css">
    <link href="./img/ico.ico" rel="icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css" integrity="sha512-d0olNN35C6VLiulAobxYHZiXJmq+vl+BGIgAxQtD5+kqudro/xNMvv2yIHAciGHpExsIbKX3iLg+0B6d0k4+ZA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="position-relative">
    <header>
        <nav class="navbar navbar-expand-lg position-fixed start-0 top-25 end-0 z-1" style="background-color:#222831">
            <div class="container-fluid">
                <a class="navbar-brand fs-6 fw-semibold" href="#" style="color:#EEEEEE;">
                    <img src="./img/logo.jpeg" alt="Logo" width="60" height="60" class="d-inline-block align-text-mid rounded-5 me-2">
                    MY CAR COLLECTION
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <div class="d-flex gap-4 ms-2 p-2 shadow rounded-2 text-light">
                        <a href="index.php" class="text-decoration-none">
                            <button class="btn fs-6 fw-semibold pt-3 pb-3 d-flex justify-content-between" style="background-color: #00ADB5; color:#EEEEEE; width:130px; letter-spacing:1.5px">Create <img src="./img/plus_button.svg" width="25"></button>
                        </a>
                        <form action="" method="post" class="p-2 d-flex">
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="car_type" class="ms-2 me-2 fw-semibold">Transmission</label>
                                <select name="car_type" class="form-select me-2">
                                    <option value="*" <?php echo $car_type_value == "*" ? "selected" : "" ?>>All</option>
                                    <option value="Manual" <?php echo $car_type_value == "Manual" ? "selected" : "" ?>>Manual</option>
                                    <option value="Automatic" <?php echo $car_type_value == "Automatic" ? "selected" : "" ?>>Automatic</option>
                                    <option value="CVT" <?php echo $car_type_value == "CVT" ? "selected" : "" ?>>CVT</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <label for="car_type" class="ms-2 me-2 fw-semibold">Brand</label>
                                <select name="car_brand" class="form-select me-2">
                                    <option value="*" <?php echo $car_brand_val == "*" ? "selected" : "" ?>>All</option>
                                    <option value="Toyota" <?php echo $car_brand_val == "Toyota" ? "selected" : "" ?>>Toyota</option>
                                    <option value="Hyundai" <?php echo $car_brand_val == "Hyundai" ? "selected" : "" ?>>Hyundai</option>
                                    <option value="BMW" <?php echo $car_brand_val == "BMW" ? "selected" : "" ?>>BMW</option>
                                    <option value="Ford" <?php echo $car_brand_val == "Ford" ? "selected" : "" ?>>Ford</option>
                                    <option value="Mercedes-Benz" <?php echo $car_brand_val == "Mercedes-Benz" ? "selected" : "" ?>>Mercedes-Benz</option>
                                    <option value="Lamborghini" <?php echo $car_brand_val == "Lamborghini" ? "selected" : "" ?>>Lamborghini</option>
                                    <option value="Tesla" <?php echo $car_brand_val == "Tesla" ? "selected" : "" ?>>Tesla</option>
                                </select>
                                <input type="submit" name="view" value="Go" class="btn btn-success">
                            </div>
                        </form>
                        <div class="me-3">
                            <form action="" method="post" class="p-2 d-flex position-relative">
                                <div class="d-flex">
                                    <input type="text" placeholder="Search car name" class="form-control me-2" value="<?php echo $car_name_val != '' ? $car_name_val : ''; ?>" name="car_name">
                                    <input type="submit" name="view_car_by_name" value="Search" class="btn btn-dark">

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>


    <div class="row" style="padding-top:120px; padding-left:20px; padding-right:20px;">
        <?php while ($car = $cars->fetch_assoc()) { ?>
            <div class="col-lg-3 col-md-6 col-sm-auto key" style="position: relative" id="<?php echo $car["car_id"]; ?>">
                <div class="card shadow cars cars_unclicked" id="<?php echo $car["car_id"]; ?>">
                    <img src="<?php echo $car['file_path']; ?>" class="card-img-top" alt="<?php echo $car['car_name']; ?>.jpg">
                    <div class="card-body">
                        <div class="row border-bottom">
                            <div class="col-3">
                                <small class="card-text">Name</small>
                            </div>
                            <div class="col-9 border-start">
                                <h4 class="card-title m-0"><?php echo $car['car_name']; ?></h4>
                            </div>
                        </div>
                        <div class="row border-bottom d-flex align-items-center">
                            <div class="col-3">
                                <small class="card-text">Brand</small>
                            </div>
                            <div class="col-9 d-flex align-items-center border-start">
                                <h6 class="card-text"><?php echo $car['car_brand']; ?></h6>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-3 ">
                                <small class="card-text ">Type</small>
                            </div>
                            <div class="col-9 d-flex align-items-center border-start">
                                <h6 class="card-text"><?php echo $car['car_type']; ?> </h6>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-3">
                                <small class="card-text">Color</small>
                            </div>
                            <div class="col-9 d-flex align-items-center border-start">
                                <h6 class="card-text"><?php echo $car['car_color']; ?> </h6>
                            </div>
                        </div>
                        <div class="row border-bottom">
                            <div class="col-3">
                                <small class="card-text">Price</small>
                            </div>
                            <div class="col-9 d-flex align-items-center border-start">
                                <h6 class="card-text">$ <span style="color:#00ADB5"><?php echo $car['car_price']; ?></span></h6>
                            </div>
                        </div>
                        <div class="d-flex w-100 justify-content-end mt-4 ">
                            <button class="btn me-2 fw-semibold" style="background-color:#00ADB5;">
                                <a href="update_index.php?id=<?php echo $car['car_id']; ?>" class="text-decoration-none" style="color:#222831">
                                    Update
                                </a>
                            </button>
                            <button class="btn me-2 fw-semibold button" style="background-color:#222831; color:#00ADB5;" id="<?php echo $car["car_id"] ?>">
                                Delete
                            </button>
                            <div class="hero" id="hero-<?php echo $car["car_id"]; ?>">
                                <h6 class="m-3">Are you sure you want to delete this car? </h6>
                                <div class="w-50 mt-3 d-flex justify-content-between gap-3">
                                    <button class="btn fw-semibold button_no ps-4 pe-4" style="background-color: #00ADB5; color: #222831" id="btn-<?php echo $car["car_id"] ?>">
                                        No
                                    </button>
                                    <form action="delete.php" method="post">
                                        <button class="btn fw-semibold ps-4 pe-4" name="delete" style="background-color:#222831; color:#00ADB5" type="submit">
                                            Yes
                                        </button>
                                        <input type="text" name="car_id" value="<?php echo $car["car_id"]; ?>" style="display:none">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
        $cars->close(); ?>
    </div>

    <!-- No record Found  -->
    <script src="./javascript/main_script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>