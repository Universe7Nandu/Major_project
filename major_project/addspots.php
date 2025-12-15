<html>
<head>
<title>File Handling with QR Code</title>
</head>

<body>
<center>
<form action="" method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Enter name Spot" required />
    <input type="textarea" name="discription" placeholder="Enter Description about Spot" required />
    <input type="file" name="upimg[]" id="upimg" value="" multiple="multiple"></br></br>
    <input type="text" name="link" placeholder="Paste links" required />
    <input type="submit" name="sub" id="sub" value="upload"></br> 
</form>
</center>

</body>

</html>

<?php
include("config.php");
include('phpqrcode/qrlib.php'); // Include the PHP QR Code library

$path = "upload/";
$valid_formats = array("jpg", "png", "gif", "bmp", "JPG", "jpeg");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Escape user input
    $name = mysqli_real_escape_string($DBcon, $_POST['name']);
    $description = mysqli_real_escape_string($DBcon, $_POST['discription']);
    $link = mysqli_real_escape_string($DBcon, $_POST['link']);
    $time = time();
    
    // Generate a unique page URL for this submission
    $uniqueID = $time . rand(1000, 9999); // Unique ID for each submission
    $pageURL = "http://yourdomain.com/viewspot.php?id=" . $uniqueID; // Change 'yourdomain.com' to your actual domain

    // Save submitted data only once
    echo "<h3>Submitted Data:</h3>";
    echo "<strong>Name:</strong> " . $name . "</br></br>";
    echo "<strong>Description:</strong> " . $description . "</br></br>";
    echo "<strong>Link:</strong> <a href='$link' target='_blank'>$link</a></br></br>";

    foreach ($_FILES['upimg']['tmp_name'] as $key => $value) {
        $actual_img_name = $_FILES['upimg']['name'][$key];
        $reimg = $time . $actual_img_name;
        $size = $_FILES['upimg']['size'][$key];
        $tmp = $_FILES['upimg']['tmp_name'][$key];
        $ext = explode(".", $actual_img_name);
        print_r($ext);

        if (in_array($ext[1], $valid_formats)) {
            if (move_uploaded_file($tmp, $path . $reimg)) {
                // Insert into database and handle potential errors
                $qry = $DBcon->query("INSERT INTO spot(s_name, s_discription, s_img, s_link, unique_id) VALUES('$name', '$description', '$reimg', '$link', '$uniqueID')");

                if ($qry) {
                    echo "<strong>Uploaded Image:</strong> <img style='width:50%;' src='$path/$reimg' ></br></br>";
                } else {
                    echo "Error: " . $DBcon->error;
                }
            } else {
                echo "File upload failed";
            }
        } else {
            echo "Invalid format";
        }
    }

    // Generate the QR Code for the URL
    $qrCodePath = 'qr_codes/';
    $qrFileName = $qrCodePath . 'qr_' . $uniqueID . '.png';
    QRcode::png($pageURL, $qrFileName, QR_ECLEVEL_L, 10); // Create the QR code

    // Display the generated QR code
    echo "<h3>Scan this QR Code to view the submission page:</h3>";
    echo "<img src='$qrFileName' />";
    echo "</br></br>";
    echo "Or visit the page directly: <a href='$pageURL'>$pageURL</a>";
    
} else {
    echo "REQUEST METHOD IS NOT POST ";
}
?>
