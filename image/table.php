<?php
include 'connection.php';

$select = "SELECT * FROM tbl_product";
$result = mysqli_query($conn, $select);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- #region-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</head>

<body>

    <div class="container mt-4 p-5 shadow rounded-3">
        <button type="button" class="btn btn-outline-dark float-end mb-2" data-bs-toggle="modal"
            data-bs-target="#exampleModal">
            + Add Product
        </button>
        <table class="table table-hover text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>QTY</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td><?php echo $row['qty']; ?></td>
                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                    <td>$<?php echo number_format($row['total'], 2); ?></td>
                    <td>
                        <img src="image/<?php echo $row['image']; ?>" width="35" class="rounded-circle">
                    </td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                    </td>
                </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="insert.php" method="post" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="proname" class="form-control" placeholder="Product Name...">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">QTY</label>
                            <input type="number" name="qty" class="form-control" placeholder="QTY...">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Price</label>
                            <input type="number" name="price" class="form-control" placeholder="Price...">
                        </div>

                        <div class="mb-2">
                            <label class="form-label">Image</label><br>
                            <img id="image"
                                src="https://media-cldnry.s-nbcnews.com/image/upload/newscms/2019_33/2203981/171026-better-coffee-boost-se-329p.jpg"
                                width="110" height="110" class="rounded-circle mb-2">
                            <input id="file" name="file" type="file" class="form-control">
                        </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        $('#file').hide()
        $('#image').click(function() {
            $('#file').click()
        })
        $('#file').change(function() {
            let file = this.files[0]
            if (file) {
                let image = URL.createObjectURL(file)
                $('#image').attr('src', image)
            }
        })
    })
    </script>

</body>

</html>