<?php
include("config.php");

if (isset($_GET['id'])) {
    $spot_id = mysqli_real_escape_string($DBcon, $_GET['id']);

    // Fetch existing data
    $qry = $DBcon->query("SELECT * FROM spots WHERE s_id='$spot_id'");
    $row = $qry->fetch_assoc();

    if (isset($_POST['submit'])) {
        $name = mysqli_real_escape_string($DBcon, $_POST['name']);
        $description = mysqli_real_escape_string($DBcon, $_POST['description']);
        $contact = mysqli_real_escape_string($DBcon, $_POST['contact']);
        $other_link = mysqli_real_escape_string($DBcon, $_POST['other_link']);

        // Handle Image Upload
        if (!empty($_FILES['image']['name'])) {
            $target_dir = "upload/";
            $image_name = time() . "_" . basename($_FILES["image"]["name"]);
            $target_file = $target_dir . $image_name;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Validate image file
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check === false || !in_array($imageFileType, ["jpg", "jpeg", "png"])) {
                echo "<script>alert('Invalid image file! Only JPG, JPEG, PNG allowed.'); window.location.href='editspot.php?id=$spot_id';</script>";
                exit;
            }

            move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        } else {
            $image_name = $row['s_img']; // Keep old image if not updated
        }

        // Handle Video Upload
        if (!empty($_FILES['video']['name'])) {
            $video_dir = "videos/";
            $video_name = time() . "_" . basename($_FILES["video"]["name"]);
            $video_file = $video_dir . $video_name;
            $videoFileType = strtolower(pathinfo($video_file, PATHINFO_EXTENSION));

            if (!in_array($videoFileType, ["mp4", "avi", "mov", "mkv"])) {
                echo "<script>alert('Invalid video file! Only MP4, AVI, MOV, MKV allowed.'); window.location.href='editspot.php?id=$spot_id';</script>";
                exit;
            }

            move_uploaded_file($_FILES["video"]["tmp_name"], $video_file);
        } else {
            $video_name = $row['s_video']; // Keep old video if not updated
        }

        // Update Query
        $updateQry = $DBcon->query("UPDATE spots SET 
            s_name='$name', 
            s_discription='$description', 
            s_img='$image_name', 
            s_video='$video_name',
            s_contact='$contact',
            s_other_link='$other_link' 
            WHERE s_id='$spot_id'");

        if ($updateQry) {
            echo "<script>alert('Spot updated successfully!'); window.location.href='viewspot.php';</script>";
        } else {
            echo "<script>alert('Update failed. Please try again.');</script>";
        }
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='viewspot.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Spot</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .edit-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin: 2rem auto;
            max-width: 800px;
            animation: fadeIn 0.5s ease;
        }
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 2rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
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
        .media-preview {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .preview-img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .preview-video {
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            margin-bottom: 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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
        .btn-cancel {
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
        .btn-cancel:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="edit-container">
            <h2 class="page-title">
                <i class="fas fa-edit"></i>
                Edit Spot
            </h2>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-4">
                    <label class="form-label">Spot Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $row['s_name']; ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description" rows="4" required><?php echo $row['s_discription']; ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="form-label">Contact Info</label>
                    <input type="text" class="form-control" name="contact" value="<?php echo $row['s_contact']; ?>" required>
                </div>
                <div class="mb-4">
                    <label class="form-label">Other Link</label>
                    <input type="url" class="form-control" name="other_link" value="<?php echo $row['s_other_link']; ?>">
                </div>

                <div class="media-preview">
                    <h5 class="mb-3">Current Media</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">Current Image</label>
                            <img src="upload/<?php echo $row['s_img']; ?>" class="preview-img">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Current Video</label>
                            <video class="preview-video" controls>
                                <source src="videos/<?php echo $row['s_video']; ?>" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Upload New Image (Optional)</label>
                    <div class="file-upload">
                        <input type="file" name="image" accept="image/png, image/jpeg, image/jpg">
                        <i class="fas fa-cloud-upload-alt"></i> Choose New Image
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Upload New Video (Optional)</label>
                    <div class="file-upload">
                        <input type="file" name="video" accept="video/*">
                        <i class="fas fa-video"></i> Choose New Video
                    </div>
                </div>

                <button type="submit" name="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update Spot
                </button>
                <a href="viewspot.php" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
