<?php
include("config.php");

// Search Query using prepared statement
$search = isset($_GET['search']) ? mysqli_real_escape_string($DBcon, $_GET['search']) : '';
$query = "SELECT * FROM spots";
if ($search) {
    $query .= " WHERE s_id LIKE '%$search%' 
                OR s_name LIKE '%$search%' 
                OR s_contact LIKE '%$search%' 
                OR s_link LIKE '%$search%'";
}
$qry = $DBcon->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoSpot Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .dashboard-container {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin: 2rem auto;
            max-width: 1200px;
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
        .search-container {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        .search-input {
            border: 2px solid #e1e1e1;
            border-radius: 10px;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }
        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
        }
        .spot-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        .spot-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .spot-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
        .spot-info {
            margin-bottom: 1rem;
        }
        .spot-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 0.5rem;
        }
        .spot-description {
            color: #666;
            margin-bottom: 1rem;
        }
        .spot-contact {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        .action-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        .btn-action {
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-action:hover {
            transform: translateY(-2px);
        }
        .btn-view {
            background: var(--primary-color);
            color: white;
        }
        .btn-edit {
            background: var(--secondary-color);
            color: white;
        }
        .btn-delete {
            background: var(--danger-color);
            color: white;
        }
        .no-results {
            text-align: center;
            padding: 3rem;
            color: #666;
        }
        .no-results i {
            font-size: 3rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="dashboard-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="adminhome.php" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
                <h2 class="page-title">
                    <i class="fas fa-map-marked-alt"></i>
                    Manage Spots
                </h2>
            </div>

            <div class="search-container">
                <form method="GET" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control search-input" 
                               placeholder="Search spots by name, ID, or contact..." 
                               value="<?= htmlspecialchars($search) ?>">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>

            <?php if ($qry->num_rows > 0): ?>
                <div class="row">
                    <?php while ($row = $qry->fetch_assoc()): ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="spot-card animate-fade-in">
                                <img src="upload/<?= $row['s_img'] ?>" 
                                     class="spot-image" 
                                     alt="<?= $row['s_name'] ?>">
                                <div class="spot-info">
                                    <h3 class="spot-title"><?= $row['s_name'] ?></h3>
                                    <p class="spot-description"><?= substr($row['s_discription'], 0, 100) ?>...</p>
                                    <div class="spot-contact">
                                        <i class="fas fa-phone"></i>
                                        <?= $row['s_contact'] ?>
                                    </div>
                                </div>
                                <div class="action-buttons">
                                    <a href="<?= $row['s_link'] ?>" 
                                       class="btn btn-action btn-view" 
                                       target="_blank">
                                        <i class="fas fa-eye"></i> View
                                    </a>
                                    <a href="editspot.php?id=<?= $row['s_id'] ?>" 
                                       class="btn btn-action btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button onclick="confirmDelete('<?= $row['s_id'] ?>')" 
                                            class="btn btn-action btn-delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h3>No spots found</h3>
                    <p>Try adjusting your search criteria or add a new spot.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function confirmDelete(id) {
            if (confirm("Are you sure you want to delete this spot?")) {
                window.location.href = "deletespot.php?id=" + id;
            }
        }
    </script>
</body>

</html>