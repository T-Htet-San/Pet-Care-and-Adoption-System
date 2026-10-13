<?php
// 1. INITIALIZE SESSION (Must run first to read user login state cookies)
session_start();

// 2. DATABASE CONFIGURATION
$host     = 'localhost';
$dbName   = 'pet_database'; // Your database name in phpMyAdmin
$username = 'root';         // Your database username
$password = '';             // Your database password

try {
    // 3. Establish connection using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    // 4. Fetch data from the vets table
    $stmt = $pdo->query("SELECT * FROM vets");
    $vetsList = $stmt->fetchAll();

} catch (PDOException $e) {
    // If something goes wrong, stop execution and show the error message
    die("Database connection failed: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vet Services - PetHaven</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">

    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand fw-bold" href="index.php">PetHaven</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="adoption.php">Adoption</a></li>
                <li class="nav-item"><a class="nav-link active" href="vets.php">Vet</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
            </ul>
            
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                    <div class="user-profile-badge" style="color: #003459; font-weight: bold; display: flex; align-items: center; gap: 10px;">
                        <span class="user-greeting">
                            <i class="fa-solid fa-circle-user fa-lg"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </span>
                        
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <a href="admin_dashboard.php" class="btn btn-sm btn-outline-secondary" style="margin-left: 5px;">Admin</a>
                        <?php endif; ?>
                        
                        <a href="logout.php" style="color: #e53e3e; text-decoration: none; margin-left: 5px;" title="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </a>
                    </div>
                <?php else: ?>
                    <a href="login.php">
                        <button class="btn">Login/Register</button>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </nav>

    <div class="mt-5 text-center">
        <h3>Find Trusted Veterinary Services</h3>
    </div>

    <div id="vetList" class="mt-4">
        <?php if (!empty($vetsList)): ?>
            <?php foreach($vetsList as $vet): ?>
                <div class="pet-card mb-4">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <img src="<?php echo htmlspecialchars($vet['img']); ?>" class="vetimg img-fluid" alt="Vet Image">
                        </div>
                        <div class="col-md-8">
                            <h4><?php echo htmlspecialchars($vet['name']); ?></h4>
                            <p class="txtdata"><strong><?php echo htmlspecialchars($vet['email']); ?></strong></p>
                            <p class="txtdata"><strong><?php echo htmlspecialchars($vet['qualification']); ?></strong></p>
                            <p class="txtdata"><strong><?php echo htmlspecialchars($vet['experience']); ?></strong></p>
                            <p class="txtdata"><?php echo htmlspecialchars($vet['detail']); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted my-5">No veterinary services are listed at this time.</p>
        <?php endif; ?>
    </div>

    <hr>

    <div class="footer">
        <h5>PetHaven</h5>
        <div class="row">
            <div class="col-md-4">
                <p>Helping pets find loving homes and families.</p>
                <p>Connecting pets with caring families, one adoption at a time.</p>
            </div>
            <div class="col">
                <li><a class="nav-link" href="index.php">Home</a></li>
                <li><a class="nav-link" href="adoption.php">Adoption</a></li>
                <li><a class="nav-link" href="vets.php">Vet Services</a></li>
                <li><a class="nav-link" href="contact.php">Contact</a></li>
                <li><a class="nav-link" href="about.php">About Us</a></li>
            </div>
            <div class="col">
                <li><p>Email: support@pethaven.com</p></li>
                <li><p>Social Media Option: 
                    <i class="fa-brands fa-facebook fa-lg"></i> 
                    <i class="fa-brands fa-instagram fa-lg"></i> 
                    <i class="fa-brands fa-tiktok fa-lg"></i>
                </p></li>
            </div>
        </div>
        <div class="row2">
            <p>Privacy Policy | Terms of Service</p>
        </div>
    </div>

</div>

</body>
</html>