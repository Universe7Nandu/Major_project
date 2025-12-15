<?php
include("config.php");
include("phpqrcode/qrlib.php"); // Include QR Code library

$path = "upload/";
$qrPath = "qrcodes/"; // Directory for QR codes
$videoPath = "videos/"; // Directory for Videos

// Ensure directories exist
if (!file_exists($path)) {
    mkdir($path, 0777, true);
}
if (!file_exists($qrPath)) {
    mkdir($qrPath, 0777, true);
}
if (!file_exists($videoPath)) {
    mkdir($videoPath, 0777, true);
}

$valid_image_formats = array("jpg", "png", "gif", "bmp", "jpeg");
$valid_video_formats = array("mp4", "avi", "mov", "mkv");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = mysqli_real_escape_string($DBcon, $_POST['name']);
    $description = mysqli_real_escape_string($DBcon, $_POST['discription']);
    $other_link = mysqli_real_escape_string($DBcon, $_POST['other_link']);
    $contact = mysqli_real_escape_string($DBcon, $_POST['contact']);

    $time = time();
    $spot_id = bin2hex(random_bytes(10)); // Generates a unique ID

    $generated_link = "http://localhost/major/spot.php?id=" . $spot_id;

    // Generate QR Code
    $qrFilename = $qrPath . $spot_id . ".png";
    QRcode::png($generated_link, $qrFilename, QR_ECLEVEL_L, 10);

    // Upload Image (Mandatory)
    $uploadedImage = "";
    if (!empty($_FILES['upimg']['name'][0])) {
        foreach ($_FILES['upimg']['tmp_name'] as $key => $value) {
            $actual_img_name = $_FILES['upimg']['name'][$key];
            $reimg = $time . "_" . $actual_img_name;
            $tmp = $_FILES['upimg']['tmp_name'][$key];
            $ext = pathinfo($actual_img_name, PATHINFO_EXTENSION);

            if (in_array(strtolower($ext), $valid_image_formats)) {
                if (move_uploaded_file($tmp, $path . $reimg)) {
                    $uploadedImage = $reimg;
                } else {
                    echo "Image upload failed";
                    exit();
                }
            } else {
                echo "Invalid image format";
                exit();
            }
        }
    } else {
        echo "Image upload is mandatory!";
        exit();
    }

    // Upload Video (Mandatory)
    $uploadedVideo = "";
    if (!empty($_FILES['video']['name'])) {
        $actual_video_name = $_FILES['video']['name'];
        $revid = $time . "_" . $actual_video_name;
        $video_tmp = $_FILES['video']['tmp_name'];
        $video_ext = pathinfo($actual_video_name, PATHINFO_EXTENSION);

        if (in_array(strtolower($video_ext), $valid_video_formats)) {
            if (move_uploaded_file($video_tmp, $videoPath . $revid)) {
                $uploadedVideo = $revid;
            } else {
                echo "Video upload failed";
                exit();
            }
        } else {
            echo "Invalid video format";
            exit();
        }
    } else {
        echo "Video upload is mandatory!";
        exit();
    }

    // Insert Data into Database
    $qry = $DBcon->query("INSERT INTO spots (s_id, s_name, s_discription, s_img, s_link, s_qrcode, s_other_link, s_video, s_contact) 
                         VALUES ('$spot_id', '$name', '$description', '$uploadedImage', '$generated_link', '$qrFilename', '$other_link', '$uploadedVideo', '$contact')");

    if (!$qry) {
        echo "Database Insert Error: " . $DBcon->error;
        exit();
    }

    // Display Submitted Data
    echo "<div class='container'>
            <h3>Submitted Data:</h3>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Description:</strong> $description</p>
            <p><strong>Generated Link:</strong> <a href='$generated_link' target='_blank'>$generated_link</a></p>
            <p><strong>Other Link:</strong> <a href='$other_link' target='_blank'>$other_link</a></p>
            <p><strong>Contact Info:</strong> $contact</p>
            <p><strong>QR Code:</strong></p>
            <img src='$qrFilename' width='150px'/></br>";

    if ($uploadedImage) {
        echo "<p><strong>Uploaded Image:</strong></p>
              <img class='uploaded-img' src='$path$uploadedImage' width='200px' />";
    }

    if ($uploadedVideo) {
        echo "<p><strong>Uploaded Video:</strong></p>
              <video width='300' height='200' controls>
                  <source src='$videoPath$uploadedVideo' type='video/mp4'>
                  Your browser does not support the video tag.
              </video>";
    }

    echo "</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Spot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            max-width: 800px;
            margin: 2rem auto;
            animation: fadeIn 0.5s ease;
        }
        .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 2rem;
            text-align: center;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }
        .form-control {
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            padding: 12px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }
        .file-upload {
            position: relative;
            display: inline-block;
            width: 100%;
            padding: 12px;
            background: #f8f9fa;
            border: 2px dashed #e1e1e1;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .file-upload:hover {
            border-color: var(--primary-color);
            background: rgba(74, 144, 226, 0.05);
        }
        .file-upload input[type="file"] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }
        .btn-submit {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            border: none;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .btn-back {
            background: #f8f9fa;
            color: var(--text-color);
            padding: 12px 30px;
            border-radius: 25px;
            border: none;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }
        .preview-container {
            margin-top: 1rem;
            padding: 1rem;
            border-radius: 10px;
            background: #f8f9fa;
        }
        .preview-image {
            max-width: 200px;
            border-radius: 10px;
            margin: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="form-container">
            <h2 class="form-title">Add New Spot</h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">Spot Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter Spot Name" required />
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea name="discription" class="form-control" rows="4" placeholder="Enter Description about Spot" required></textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Contact Information</label>
                    <input type="text" name="contact" class="form-control" placeholder="Enter Contact Info" required />
                </div>
                <div class="form-group">
                    <label class="form-label">Other Link (Optional)</label>
                    <input type="url" name="other_link" class="form-control" placeholder="Enter Other Link" />
                </div>
                <div class="form-group">
                    <label class="form-label">Upload Image(s)</label>
                    <div class="file-upload">
                        <input type="file" name="upimg[]" id="upimg" multiple required>
                        <i class="fas fa-cloud-upload-alt"></i> Choose Image Files
                    </div>
                    <div id="image-preview" class="preview-container"></div>
                </div>
                <div class="form-group">
                    <label class="form-label">Upload Video</label>
                    <div class="file-upload">
                        <input type="file" name="video" id="video" accept="video/*" required>
                        <i class="fas fa-video"></i> Choose Video File
                    </div>
                </div>
                <button type="submit" name="sub" class="btn-submit">
                    <i class="fas fa-upload"></i> Upload Spot
                </button>
                <button type="button" onclick="history.back()" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Image preview functionality
        document.getElementById('upimg').addEventListener('change', function(e) {
            const preview = document.getElementById('image-preview');
            preview.innerHTML = '';
            
            for(let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'preview-image';
                    preview.appendChild(img);
                }
                
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
