<?php
include("config.php");

if (isset($_GET['edit'])) {
    $admin_id = mysqli_real_escape_string($DBcon, $_GET['edit']);
    
    $qry = $DBcon->query("SELECT * FROM admin WHERE a_id='$admin_id'");
    $row = $qry->fetch_assoc();

    if (isset($_POST['update'])) {
        $name = mysqli_real_escape_string($DBcon, $_POST['name']);
        $email = mysqli_real_escape_string($DBcon, $_POST['email']);
        $password = mysqli_real_escape_string($DBcon, $_POST['password']);
        
        // Handle profile image upload
        $profile_image = $row['a_img']; // Keep existing image by default
        
        if (!empty($_FILES['profile_image']['name'])) {
            $target_dir = "admin_images/";
            $file_extension = strtolower(pathinfo($_FILES["profile_image"]["name"], PATHINFO_EXTENSION));
            $new_filename = time() . "_" . uniqid() . "." . $file_extension;
            $target_file = $target_dir . $new_filename;
            
            // Validate file type
            $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
            if (in_array($file_extension, $allowed_types)) {
                if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                    // Delete old image if exists
                    if (!empty($row['a_img']) && file_exists("admin_images/" . $row['a_img'])) {
                        unlink("admin_images/" . $row['a_img']);
                    }
                    $profile_image = $new_filename;
                }
            }
        }

        // Update query
        $update_query = "UPDATE admin SET 
                        a_name='$name', 
                        a_email='$email', 
                        a_img='$profile_image'";
        
        // Only update password if provided
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_query .= ", a_password='$hashed_password'";
        }
        
        $update_query .= " WHERE a_id='$admin_id'";
        
        if ($DBcon->query($update_query)) {
            echo "<script>
                    alert('Profile updated successfully!');
                    window.location.href='adminhome.php';
                  </script>";
        } else {
            echo "<script>alert('Error updating profile: " . $DBcon->error . "');</script>";
        }
    }
} else {
    header("Location: adminhome.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .profile-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin: 2rem auto;
            max-width: 800px;
            animation: fadeIn 0.5s ease;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .profile-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        .profile-image-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        .profile-image-container:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        }
        .profile-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        .profile-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }
        .profile-image-container:hover .profile-image-overlay {
            opacity: 1;
        }
        .profile-image-upload {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
        .upload-icon {
            color: white;
            font-size: 2rem;
            transition: all 0.3s ease;
        }
        .profile-image-container:hover .upload-icon {
            transform: scale(1.1);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            font-weight: 500;
            color: var(--text-color);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .form-control {
            border: 2px solid #e1e1e1;
            border-radius: 12px;
            padding: 12px 20px;
            transition: all 0.3s ease;
            background: white;
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(52, 152, 219, 0.1);
            transform: translateY(-2px);
        }
        .btn-update {
            background: var(--gradient-primary);
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            border: none;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-update:hover {
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
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .btn-back:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            transition: all 0.3s ease;
        }
        .password-toggle:hover {
            color: var(--primary-color);
        }
        .form-floating {
            position: relative;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="profile-container">
            <div class="profile-header">
                <h2 class="profile-title">
                    <i class="fas fa-user-edit"></i>
                    Update Profile
                </h2>
                <div class="profile-image-container">
                    <img src="admin_images/<?php echo $row['a_img']; ?>" 
                         alt="Profile Image" 
                         class="profile-image">
                    <div class="profile-image-overlay">
                        <i class="fas fa-camera upload-icon"></i>
                    </div>
                    <input type="file" 
                           name="profile_image" 
                           class="profile-image-upload" 
                           accept="image/*">
                </div>
            </div>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-user"></i>
                        Full Name
                    </label>
                    <input type="text" 
                           class="form-control" 
                           name="name" 
                           value="<?php echo $row['a_name']; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i>
                        Email Address
                    </label>
                    <input type="email" 
                           class="form-control" 
                           name="email" 
                           value="<?php echo $row['a_email']; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i>
                        New Password (Leave blank to keep current)
                    </label>
                    <div class="form-floating">
                        <input type="password" 
                               class="form-control" 
                               name="password" 
                               id="password">
                        <i class="fas fa-eye password-toggle" 
                           onclick="togglePassword()"></i>
                    </div>
                </div>

                <button type="submit" name="update" class="btn-update">
                    <i class="fas fa-save"></i>
                    Update Profile
                </button>
                <a href="adminhome.php" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Back to Dashboard
                </a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Preview profile image before upload
        document.querySelector('.profile-image-upload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.profile-image').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
