<?php
include("config.php");

if (isset($_GET['id'])) {
    $spot_id = mysqli_real_escape_string($DBcon, $_GET['id']);

    $qry = $DBcon->query("SELECT * FROM spots WHERE s_id='$spot_id'");

    if ($qry->num_rows > 0) {
        $row = $qry->fetch_assoc();
        $spot_name = $row['s_name'];
        $description = $row['s_discription'];
        $link = $row['s_link'];
        $image = "upload/" . $row['s_img'];
        $qr_code = $row['s_qrcode'];
        $contact = $row['s_contact'];
        $other_link = $row['s_other_link'];
        $video = "videos/" . $row['s_video'];
    } else {
        $error_message = "No data found for this ID.";
    }
} else {
    $error_message = "ID not provided.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($spot_name) ? $spot_name : 'Spot Details'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .spot-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin: 2rem auto;
            max-width: 1000px;
            animation: fadeIn 0.5s ease;
        }
        .spot-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .spot-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .spot-description {
            font-size: 1.1rem;
            color: var(--text-color);
            line-height: 1.8;
            margin-bottom: 2rem;
        }
        .media-section {
            margin-bottom: 2rem;
        }
        .spot-image {
            width: 100%;
            max-height: 500px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        .spot-video {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
        }
        .info-section {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .info-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
            padding: 0.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .info-item:hover {
            background: #f8f9fa;
        }
        .info-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--primary-color);
            color: white;
            border-radius: 10px;
            font-size: 1.2rem;
        }
        .qr-section {
            text-align: center;
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .qr-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 1rem;
        }
        .qr-code {
            width: 200px;
            height: 200px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .qr-code:hover {
            transform: scale(1.05);
        }
        .error-message {
            text-align: center;
            padding: 2rem;
            color: var(--danger-color);
            font-size: 1.2rem;
            font-weight: 500;
        }
        .error-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--danger-color);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <?php if (isset($error_message)) { ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle error-icon"></i>
                <p><?php echo $error_message; ?></p>
            </div>
        <?php } else { ?>
            <div class="spot-container">
                <div class="spot-header">
                    <h1 class="spot-title"><?php echo $spot_name; ?></h1>
                    <p class="spot-description"><?php echo $description; ?></p>
                </div>

                <div class="media-section">
                    <img src="<?php echo $image; ?>" alt="Spot Image" class="spot-image">
                    <video class="spot-video" controls>
                        <source src="<?php echo $video; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <div class="info-section">
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div>
                            <h5>Contact Information</h5>
                            <p class="mb-0"><?php echo $contact; ?></p>
                        </div>
                    </div>
                    <?php if (!empty($other_link)) { ?>
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fas fa-link"></i>
                            </div>
                            <div>
                                <h5>Additional Link</h5>
                                <a href="<?php echo $other_link; ?>" target="_blank" class="text-decoration-none">
                                    <?php echo $other_link; ?>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <div class="qr-section">
                    <h3 class="qr-title">Scan QR Code</h3>
                    <img src="<?php echo $qr_code; ?>" alt="QR Code" class="qr-code">
                    <p class="mt-3">Scan this QR code to access this spot on your mobile device</p>
                </div>
            </div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
