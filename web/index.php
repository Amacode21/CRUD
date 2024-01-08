<?php
include_once "./connection/connect.php";
include_once "./connection/crud.php";


// Prevent the form to reset if error occur;
$prev_car_name = '';
$prev_car_type = '';
$prev_car_brand = '';
$prev_car_price = '';
$prev_car_color = '';

if (isset($_POST['submit'])) {

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
            echo '
    <script>
        document.addEventListener("DOMContentLoaded",function(){
            const html = `
            <div class="alert alert-danger fixed-top start-50 end-0 m-2 alert-dismissible fade show" role="alert" id="alert">
                <strong>Image Already Existed!</strong>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            `;
            document.body.appendChild(document.createRange().createContextualFragment(html));
        });
    </script>
    ';
            $prev_car_name = $car_name;
            $prev_car_type = $car_type;
            $prev_car_brand = $car_brand;
            $prev_car_price = $car_price;
            $prev_car_color = $car_color;
        }
    }
}
// $conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Page</title>
    <link rel="icon" href="./img/ico.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/index_styles.css">
</head>

<body class="d-flex justify-content-center align-items-center position-relative">
    <div class="form-container border border-2 p-3 gap-2 rounded-3 d-flex align-items-center flex-column flex-lg-row position-relative w-75">
        <a href="main.php" class="btn btn-dark position-absolute top-0 end-0 m-3 fw-semibold" style="font-size:13px;"> Cancel </a>
        <div class="d-flex flex-column">
            <div class="d-flex justify-content-center align-items-center gap-4 w-100 mb-2">
                <img src="./img/logo.jpeg" height="60" width="60" alt="logo.jpeg" class="rounded-5">
                <h5 class="">Insert new car</h5>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="mb-2 d-flex justify-content-between align-items-center gap-2">
                    <label for="car_name">Name </label>
                    <input type="text" name="car_name" class="form-control" value="<?php echo $prev_car_name != '' ? $prev_car_name : ''; ?>" id="car_name" required>
                </div>
                <div class="mb-2 d-flex justify-content-between align-items-center gap-2">
                    <label for="car_type">Transmission</label>
                    <select name="car_type" id="car_type" class="form-select">
                        <option value="Manual" <?php echo $prev_car_type == 'Manual' ? 'selected' : ''; ?>>Manual</option>
                        <option value="Automatic" <?php echo $prev_car_type == 'Automatic' ? 'selected' : ''; ?>>Automatic</option>
                        <option value="ADV" <?php echo $prev_car_type == 'ADV' ? 'selected' : ''; ?>>ADV</option>
                    </select>

                </div>
                <div class="mb-2 d-flex justify-content-between align-items-center gap-2">
                    <label for="car_brand">Brand</label>
                    <select name="car_brand" id="car_brand" class="form-select">
                        <option value="Toyota" <?php echo $prev_car_brand == 'Toyota' ? 'selected' : ''; ?>>Toyota</option>
                        <option value="Hyundai" <?php echo $prev_car_brand == 'Hyundai' ? 'selected' : ''; ?>>Hyundai</option>
                        <option value="BMW" <?php echo $prev_car_brand == 'BMW' ? 'selected' : ''; ?>>BMW</option>
                        <option value="Ford" <?php echo $prev_car_brand == 'Ford' ? 'selected' : ''; ?>>Ford</option>
                        <option value="Mercedes-Benz" <?php echo $prev_car_brand == 'Mercedes-Benz' ? 'selected' : ''; ?>>Mercedes-Benz</option>
                        <option value="Lamborghini" <?php echo $prev_car_brand == 'Lamborghini' ? 'selected' : ''; ?>>Lamborghini</option>
                        <option value="Tesla" <?php echo $prev_car_brand == 'Tesla' ? 'selected' : ''; ?>>Tesla</option>
                    </select>
                </div>
                <div class="mb-2 d-flex justify-content-between align-items-center gap-2 position-relative">
                    <label for="car_price">Price </label>
                    <input type="number" name="car_price" placeholder="$" value="<?php echo $prev_car_price != '' ? $prev_car_price : '90000'; ?>" id="car_price" class="form-control" required>
                    <div id="reminder_edit" class="position-absolute" style="right: 10px;visibility:hidden; font-size:14px">
                        <small>You can't edit this field</small>
                    </div>
                </div>
                <div class="mb-4 d-flex justify-content-between align-items-center gap-2">
                    <label for="car_color">Color </label>
                    <input type="text" name="car_color" value="<?php echo $prev_car_color != '' ? $prev_car_color : ''; ?>" class="form-control" id="car_color" required>
                </div>
                <div class="mb-2">
                    <small><label for="file_path">Put car image here </label></small>
                    <input class="form-control bg-primary-subtle" type="file" name="file_path" id="file_path" accept=".jpg, .jpeg, .svg, .png" required>
                </div>
                <input type="submit" name="submit" value="Submit" class="btn p-3 w-100 mt-3 fw-semibold" style="background-color:#00ADB5; color:#EEEEEE">
            </form>
        </div>
        <div class="shadow border d-flex justify-content-center align-items-center p-2 position-relative w-75" style="height: 23rem;">
            <h3 class="pre">Preview</h3>
            <img alt="" id="preview" class="border-0" style="max-height:100%; min-height:auto; min-width:auto; max-width:100%">
        </div>
        <div class="position-absolute bottom-0 end-0 m-3">
            <button class="clr_img btn btn-danger">Clear Image</button>
            <button class="clr_form btn btn-success">Clear Form</button>
        </div>
    </div>
    <script src="./javascript/index_script.js"></script>
</body>

</html>