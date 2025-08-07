<?php include 'dashboard.php'; ?>
<div class="main-content">
    <h2>Product</h2>
    <a href="add_user.php" class="btn btn-primary mb-3">Add product</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Actions</th></tr></thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM users");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>
                            <a href='edit_user.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_user.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Delete this user?')\">Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
