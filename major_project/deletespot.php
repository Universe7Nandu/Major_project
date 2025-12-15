<?php
include("config.php");

if (isset($_GET['id'])) {
    $spot_id = mysqli_real_escape_string($DBcon, $_GET['id']);

    // Delete query
    $deleteQry = $DBcon->query("DELETE FROM spots WHERE s_id='$spot_id'");

    if ($deleteQry) {
        echo "<script>alert('Spot deleted successfully!'); window.location.href='viewspot.php';</script>";
    } else {
        echo "<script>alert('Error deleting spot. Please try again.'); window.location.href='viewspot.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='viewspot.php';</script>";
}
?>
