<?php include 'dashboard.php'; ?>
<div class="main-content">
    <h2>Bookings</h2>
    <a href="add_booking.php" class="btn btn-primary mb-3">Add Bookings</a>
    <table class="table table-bordered">
        <thead><tr><th>ID</th><th>Name</th><th>Contact</th><th>booking_type</th><th>pref_time</th><th>adv_pay</th><th>pay_mode</th><th>Actions</th></tr></thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM booking");
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['contact']}</td>
                        <td>{$row['booking_type']}</td>
                        <td>{$row['pref_time']}</td>
                        <td>{$row['adv_pay']}</td>
                        <td>{$row['pay_mode']}</td>
                        



                        <td>
                            <a href='edit_booking.php?id={$row['id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_booking.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Delete this user?')\">Delete</a>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
