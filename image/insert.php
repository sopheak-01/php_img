<?php
include 'connection.php';


if (isset($_POST['submit'])) {

    if (!is_dir('image')) {
        mkdir('image', 0777, true);
    }

    $pro_name = $_POST['proname'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $total = $qty * $price;

    $file = $_FILES['file']['name'];
    $tmp_name = $_FILES['file']['tmp_name'];
    $path = "image/" . $file;

    
    move_uploaded_file($tmp_name, $path);
    

    $insert = "INSERT INTO tbl_product
    (product_name, qty, price, total, image)
    VALUES ('$pro_name', '$qty', '$price', '$total', '$file')";

    if (mysqli_query($conn, $insert)) {
        header("Location: table.php");
        exit;
    } else {
        echo mysqli_error($conn);
    }
}
?>
