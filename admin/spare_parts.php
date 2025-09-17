<?php
include 'dashboard.php'; 
include 'db.php';
?>

<div class="main-content">

    <h2 class="mb-4">Spare Parts</h2>
    <a href="add_sparepart.php" class="btn btn-success mb-3">Add Sparepart</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM spare_parts ORDER BY id ASC");
            while ($row = mysqli_fetch_assoc($result)) {
                $imgPath = "uploads/" . htmlspecialchars($row['image']);
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['category']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['stock']}</td>
                        <td>
                            <img src='{$imgPath}' 
                                 style='width:80px;height:60px;object-fit:cover;
                                        border:1px solid #ddd;padding:2px;'>
                        </td>
                        <td>
                            <a href='edit_part.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_sparepart.php?id={$row['id']}' 
                               class='btn btn-danger btn-sm' 
                               onclick=\"return confirm('Delete this spare part?');\">Delete</a>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
