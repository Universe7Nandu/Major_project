<?php 	
require_once("alock.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .dashboard-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: none;
            border-radius: 20px;
            padding: 2rem;
            margin: 1rem;
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .welcome-text {
            font-size: 2.5rem;
            font-weight: 700;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 2rem;
        }
        .btn-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 15px 25px;
            font-size: 1.1rem;
            margin: 10px 0;
        }
        .btn-icon i {
            font-size: 1.3rem;
        }
        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="dashboard-card animate-fade-in">
            <h2 class="welcome-text text-center">Welcome, <?php echo $row['a_name']; ?></h2>
            <div class="d-flex flex-column gap-3">
                <a href="" class="btn btn-primary btn-icon">
                    <i class="fas fa-home"></i> Home
                </a>
                <a href="update.php?edit=<?php echo $row['a_id'];?>" class="btn btn-secondary btn-icon">
                    <i class="fas fa-user-edit"></i> Profile
                </a>
                <a href="addspot.php" class="btn btn-success btn-icon">
                    <i class="fas fa-plus-circle"></i> Add Spot
                </a>
                <a href="viewspot.php" class="btn btn-info btn-icon">
                    <i class="fas fa-eye"></i> View Spot
                </a>
                <a href="alogout.php?alogout" class="btn btn-danger btn-icon">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>