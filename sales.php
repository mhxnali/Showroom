<?php include 'dashboard.php'; ?>
<div class="main-content">
    <h2>Sales</h2>
    <a href="add_sales.php" class="btn btn-primary mb-3">Add Sales</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Date</th><th>Name</th><th>Types</th><th>product</th><th>price</th><th>pay_type</th><th>Actions</th></tr></thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM sales");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['date']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['types']}</td>
                        <td>{$row['product']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['pay_type']}</td>
                        <td>
                            <a href='edit_sale.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_sale.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Delete this user?')\">Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
