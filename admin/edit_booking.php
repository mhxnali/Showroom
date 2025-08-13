<?php include 'dashboard.php'; ?>
<?php
$id = $_GET['id'];
$row = $conn->query("SELECT * FROM booking WHERE id=$id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name= $_POST['name'];
    $contact= $_POST['contact'];
    $booking_type= $_POST['booking_type'];
    $pref_time= $_POST['pref_time'];
    $adv_pay= $_POST['adv_pay'];
    $pay_mode= $_POST['pay_mode'];
    $conn->query("UPDATE booking SET name='$name', contact='$contact', booking_type='$booking_type', pref_time='$pref_time', adv_pay='$adv_pay', pay_mode='$pay_mode' WHERE id=$id");
    header("Location: booking.php");
}
?>
<div class="main-content">
    <h2>Edit Bookings</h2>
    <form method="POST">
        <div class="mb-3"><input type="text" name="name" value="<?= $row['name'] ?>" class="form-control" required></div>    
        <div class="mb-3"><input type="text" name="contact" value="<?= $row['contact'] ?>" class="form-control" required></div>       
        <div class="mb-3"><input type="text" name="booking_type" value="<?= $row['booking_type'] ?>" class="form-control" required></div>             
        <div class="mb-3"><input type="text" name="pref_time" value="<?= $row['pref_time'] ?>" class="form-control" required></div>
        <div class="mb-3"><input type="text" name="adv_pay" value="<?= $row['adv_pay'] ?>" class="form-control" required></div>
        <div class="mb-3"><input type="text" name="pay_mode" value="<?= $row['pay_mode'] ?>" class="form-control" required></div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="booking.php" class="btn btn-secondary">Back</a>
    </form>
</div>
