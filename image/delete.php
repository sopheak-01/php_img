<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Get the image filename first
    $select = "SELECT image FROM tbl_product WHERE id = '$id'";
    $result = mysqli_query($conn, $select);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image_path = "image/" . $row['image'];
        
        // Delete the image file if it exists
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        // Delete the record from database
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
