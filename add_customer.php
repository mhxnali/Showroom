<?php include 'dashboard.php'; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = $_POST['name'];
    $email= $_POST['email'];
    $contact= $_POST['contact'];
    $address= $_POST['address'];

    $conn->query("INSERT INTO customer (name, email, contact,address) VALUES ('$name', '$email', '$contact', '$address')");
    header("Location: customer.php");
}
?>
<div class="main-content">
    <h2>Add Customer</h2>
    <form method="POST">
        <div class="mb-3"><input type="text" name="name"class="form-control" placeholder="name"required></div>
        <div class="mb-3"><input type="text" name="email"class="form-control" placeholder="email"required></div>
        <div class="mb-3"><input type="text" name="contact"class="form-control" placeholder="contact"required></div>
        <div class="mb-3"><input type="text" name="address"class="form-control" placeholder="address"required></div>
        <button type="submit" class="btn btn-success">Add</button>
        <a href="Customer.php" class="btn btn-secondary">Back</a>
    </form>
</div>
