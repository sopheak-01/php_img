<?php
include 'connection.php';

$id = isset($_GET['id']) ? $_GET['id'] : null;

if ($id) {
    // Fetch the product data
    $select = "SELECT * FROM tbl_product WHERE id = '$id'";
    $result = mysqli_query($conn, $select);
    $product = mysqli_fetch_assoc($result);
    
    if (!$product) {
        echo "Product not found!";
        exit;
    }
} else {
    header("Location: table.php");
    exit;
}

if (isset($_POST['update'])) {
    $pro_name = $_POST['proname'];
    $qty = $_POST['qty'];
    $price = $_POST['price'];
    $total = $qty * $price;
    
    // Handle file upload if a new image is provided
    if (!empty($_FILES['file']['name'])) {
        // Delete old image
        $old_image_path = "image/" . $product['image'];
        if (file_exists($old_image_path)) {
            unlink($old_image_path);
        }
        
        // Upload new image
        if (!is_dir('image')) {
            mkdir('image', 0777, true);
        }
        
        $file = $_FILES['file']['name'];
        $tmp_name = $_FILES['file']['tmp_name'];
        $path = "image/" . $file;
        move_uploaded_file($tmp_name, $path);
        
        $update = "UPDATE tbl_product SET product_name = '$pro_name', qty = '$qty', price = '$price', total = '$total', image = '$file' WHERE id = '$id'";
    } else {
        // Update without changing image
        $update = "UPDATE tbl_product SET product_name = '$pro_name', qty = '$qty', price = '$price', total = '$total' WHERE id = '$id'";
    }
    
    if (mysqli_query($conn, $update)) {
        header("Location: table.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="container mt-4 p-5 shadow rounded-3" style="max-width: 500px;">
        <h2 class="mb-4">Edit Product</h2>

        <form action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="proname" class="form-control" value="<?php echo $product['product_name']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">QTY</label>
                <input type="number" name="qty" class="form-control" value="<?php echo $product['qty']; ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" class="form-control" value="<?php echo $product['price']; ?>" step="0.01" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image</label>
                <div class="mb-2">
                    <img src="image/<?php echo $product['image']; ?>" width="80" class="rounded">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Change Image (Optional)</label>
                <input type="file" name="file" class="form-control">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" name="update" class="btn btn-outline-success">Update</button>
                <a href="table.php" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>
