<?php
include 'db.php';
if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $q = mysqli_query($conn, "SELECT image FROM services WHERE id=$id");
    if($r = mysqli_fetch_assoc($q)){
        if(!empty($r['image']) && file_exists('../uploads/services/'.$r['image'])) {
            @unlink('../uploads/services/'.$r['image']);
        }
    }
    mysqli_query($conn, "DELETE FROM services WHERE id=$id");
}
header("Location: services.php");
exit;
