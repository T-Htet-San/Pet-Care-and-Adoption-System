<?php
// petinfo.php
session_start();

// SECURITY CHECK: Protect the page from non-admin users
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// 1. DATABASE CONNECTION CONFIGURATION
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

// 2. FETCH ANIMAL DATA DYNAMICALLY FROM THE DATABASE
try {
    // UPDATED: Pulling from adoptableanimals table. 
    // Note: If your table column is named 'desc' instead of 'species', change 'species' below to 'desc'
    $stmt = $pdo->query('SELECT animal_id, name, species FROM adoptableanimals ORDER BY animal_id DESC');
    $pets_list = $stmt->fetchAll();
} catch (\PDOException $e) {
    $pets_list = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animal List</title>
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
                <h1 class="dashboard-title">Animal List</h1>

                <div class="table-card">
                    
                    <div class="table-card-header">
                        <div class="header-sidebar-spacer"></div>
                        <div class="col-petname" style="width: 200px;">NAME</div>
                        <div class="col-petspecies">SPECIES</div>
                    </div>

                    <div class="table-card-body-wrapper">
                        
                        <div class="table-sidebar-accent"></div>

                        <div class="table-rows-container">
                            <?php if (!empty($pets_list)): ?>
                                <?php foreach ($pets_list as $pet): ?>
                                    
                                    <div class="table-data-row">
                                        <div class="cell-data col-petname" style="width: 200px;">
                                            <?php echo htmlspecialchars($pet['name']); ?>
                                        </div>
                                        <div class="cell-data col-petspecies" style="width: 200px;">
                                            <?php echo htmlspecialchars($pet['species']); ?>
                                        </div>
                                        
                                        <div class="cell-actions">
                                        <a href="editpet.php?id=<?php echo $pet['animal_id']; ?>" class="action-btn view-btn" title="Edit Pet" style="text-decoration: none;">
                                                <i class="fa-solid fa-eye"></i>
                                        </a>
                                            <button class="action-btn delete-btn" title="Delete Animal">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="no-data-msg" style="text-align: center; padding: 25px; color: #003459; font-style: italic;">
                                    No adoptable animals found in the database.
                                </div>
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