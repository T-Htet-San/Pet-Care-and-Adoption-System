<?php
// strayanimal.php
session_start();

// SECURITY CHECK: Protect the page from non-admin users
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// 1. DATABASE CONNECTION CONFIGURATION (PDO)
$host     = 'localhost';
$db_name  = 'pet_database'; 
$db_user  = 'root';     
$db_pass  = '';         
$charset  = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (\PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// 2. FETCH STRAY ANIMAL REPORTS
try {
    $stmt = $pdo->query('SELECT * FROM stray ORDER BY stray_id DESC');
    $stray_animals = $stmt->fetchAll();
} catch (\PDOException $e) {
    die("Query failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stray Animal Reports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="userstyles.css">
</head>
<body>

    <div class="dashboard-screen-wrapper">
        <div class="dashboard-box">
            
            <header class="dashboard-header">
                <a href="admin_dashboard.php" class="admin-profile-badge" title="Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?>">
                    <span>Admin</span>
                    <div class="admin-avatar-circle"></div>
                </a>
            </header>

            <main>
                <h1 class="dashboard-title">Stray Animal Reports</h1>

                <div class="table-card">
                    
                    <div class="table-card-header">
                        <div class="header-sidebar-spacer"></div>
                        <div class="col-name">ANIMAL TYPE</div>
                        <div class="col-email">ADDITIONAL INFO</div>
                        <div></div> </div>

                    <div class="table-card-body-wrapper">
                        
                        <div class="table-sidebar-accent"></div>

                        <div class="table-rows-container">
                            <?php if (!empty($stray_animals)): ?>
                                <?php foreach ($stray_animals as $stray): ?>
                                    
                                    <div class="table-data-row">
                                        <div class="cell-data col-name">
                                            <?php echo htmlspecialchars($stray['animal_type']); ?>
                                        </div>
                                        <div class="cell-data col-email">
                                            <?php echo htmlspecialchars($stray['additional_info'] ?? ''); ?>
                                        </div>
                                        <div class="cell-actions">
                                            <button class="action-btn view-btn" title="View Details"><i class="fa-solid fa-eye"></i></button>
                                            <button class="action-btn delete-btn" title="Delete Report"><i class="fa-solid fa-eraser"></i></button>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="no-data-msg">No stray animal reports found.</div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

                <div class="action-footer">
                    <a href="admin_dashboard.php" class="btn-back">Back to Dashboard</a>
                </div>
            </main>

        </div>
    </div>

</body>
</html>