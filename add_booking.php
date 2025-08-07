<?php include 'dashboard.php'; ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $name= $_POST['name'];
    $contact= $_POST['contact'];
    $booking_type= $_POST['booking_type'];
    $pref_time= $_POST['pref_time'];
    $adv_pay= $_POST['adv_pay'];
    $pay_mode= $_POST['pay_mode'];
    
    $conn->query("INSERT INTO booking (name, contact, booking_type, pref_time, adv_pay, pay_mode) VALUES ('$name', '$contact', '$booking_type', '$pref_time', '$adv_pay', '$pay_mode')");
    header("Location: booking.php");
}
?>
<div class="main-content">
    <h2>Add Booking</h2>
    <form method="POST">
        <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="name"required></div>
        <div class="mb-3"><input type="text" name="contact" class="form-control" placeholder="contact"required></div>
        <div class="mb-3"><input type="text" name="booking_type" class="form-control" placeholder="booking_type"required></div>
        <div class="mb-3"><input type="text" name="pref_time" class="form-control" placeholder="pref_time"required></div>
        <div class="mb-3"><input type="text" name="adv_pay" class="form-control" placeholder="adv_pay"required></div>
        <div class="mb-3"><input type="text" name="pay_mode" class="form-control" placeholder="pay_mode"required></div>
        <button type="submit" class="btn btn-success">Add</button>
        <a href="booking.php" class="btn btn-secondary">Back</a>
    </form>
</div>
