<?php include 'dashboard.php'; ?>
<div class="main-content">
    <h2>Spare Parts</h2>
    <a href="add_sparepart.php" class="btn btn-primary mb-3">Add Spare Parts</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Name</th><th>Category</th><th>stock</th><th>image</th><th>price</th><th>Actions</th></tr></thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM spare_parts");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['category']}</td>
                        <td>{$row['stock']}</td>
                <td><img src='uploads/{$row['image']}' width='100'></td>
                        <td>{$row['price']}</td>
                        <td>
                            <a href='edit_part.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_sparepart.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Delete this user?')\">Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
