<?php include 'dashboard.php'; ?>
<?php
$id = $_GET['id'];
$row = $conn->query("SELECT * FROM Customer WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email= $_POST['email'];
    $contact= $_POST['contact'];
    $address= $_POST['address'];
    $conn->query("UPDATE Customer SET name='$name', email='$email',contact='$contact', address='$address' WHERE id=$id");
    header("Location: Customer.php");
}
?>
<div class="main-content">
    <h2>Edit Customer</h2>
    <form method="POST">
        <div class="mb-3"><input type="text" name="name" value="<?= $row['name'] ?>" class="form-control" required></div>    
        <div class="mb-3"><input type="text" name="email" value="<?= $row['email'] ?>" class="form-control" required></div>       
        <div class="mb-3"><input type="text" name="contact" value="<?= $row['contact'] ?>" class="form-control" required></div>       
        <div class="mb-3"><input type="text" name="address" value="<?= $row['address'] ?>" class="form-control" required></div>       
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="Customer.php" class="btn btn-secondary">Back</a>
    </form>
</div>
