<?php include 'dashboard.php'; ?>
<?php
include 'db.php';

// Fetch all invoices
$sql = "SELECT * FROM invoices ORDER BY id DESC";
$result = $conn->query($sql);
?>
<div class="main-content">
    <h2>Sales / Invoices</h2>
    <a href="add_sale.php" class="btn btn-success mb-3">+ Add Invoice</a>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Date</th>
                <th>Customer Name</th>
                <th>Type</th>
                <th>Payment Method</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['types']; ?></td>
                    <td><?php echo $row['pay_type']; ?></td>
                    <td>
                        <a href="invoice.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm" target="_blank">
                            View Invoice
                        </a>
                        <a href="delete_invoice.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this invoice?');">
                            Delete
                        </a>
                    </td>
                </tr>
        <?php } } else { ?>
            <tr><td colspan="6" class="text-center">No sales found.</td></tr>
        <?php } ?>
        </tbody>
    </table>
</div>
