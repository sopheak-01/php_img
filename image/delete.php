<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $select = "SELECT image FROM tbl_product WHERE id = '$id'";
    $result = mysqli_query($conn, $select);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image_path = "image/" . $row['image'];
        
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        $delete = "DELETE FROM tbl_product WHERE id = '$id'";
        
        if (mysqli_query($conn, $delete)) {
            header("Location: table.php");
            exit;
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        echo "Product not found!";
    }
} else {
    header("Location: table.php");
    exit;
}
?>