<?php include 'dashboard.php'; ?>
<div class="main-content">
    <h2>Cars</h2>
    <a href="add_car.php" class="btn btn-primary mb-3">Add cars</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Name</th><th>Model</th><th>Engine</th><th>Image</th><th>price</th><th>Actions</th></tr></thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM cars");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['model']}</td>
                        <td>{$row['engine_cc']}</td>
                <td><img src='uploads/{$row['image']}' width='100'></td>
                        <td>{$row['price']}</td>
                        <td>
                            <a href='edit_car.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_car.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Delete this user?')\">Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
