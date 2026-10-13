<?php
// 1. Database Configuration
$host     = 'localhost';
$dbName   = 'pet_database'; 
$username = 'root';               
$password = '';                   

try {
    // 2. Establish connection using PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    // 3. Fetch data from the adoptableanimals table
    $stmt = $pdo->query("SELECT * FROM adoptableanimals");
    $petsList = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Start the session to track logged-in status for the navbar greeting
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PetHaven</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="container">

    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand fw-bold" href="index.php">PetHaven</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="adoption.php">Adoption</a></li>
                <li class="nav-item"><a class="nav-link" href="vets.php">Vet</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
            </ul>
            
            <div class="d-flex align-items-center">
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
                    <div class="user-profile-badge" style="display: flex; align-items: center; gap: 12px;">
                        <span class="user-greeting" style="color: #003459; font-weight: bold;">
                            <i class="fa-solid fa-circle-user fa-lg"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </span>
                        <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                            <a href="admin_dashboard.php" class="btn btn-sm btn-warning">Admin Panel</a>
                        <?php endif; ?>
                        <a href="logout.php" class="text-danger" title="Logout">
                            <i class="fa-solid fa-right-from-bracket fa-lg"></i>
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

    <?php if (isset($_GET['appointment']) && $_GET['appointment'] === 'success'): ?>
        <div class="alert alert-success mt-3 text-center fw-bold" role="alert" style="border-radius: 12px;">
            <i class="fa-solid fa-circle-check"></i> Appointment booked successfully! We look forward to seeing you.
        </div>
    <?php endif; ?>

    <div class="hero-grid text-center">
        <div class="hero-text">
            <h3>Helping pets find the homes they deserve</h3>
            <p>PetHaven is a platform that helps connect people with animals that need homes. 
                Users can explore pets available for adoption, contact shelters about stray animals, 
                and access information about nearby veterinary services.</p>
        </div>
        <div class="hero-box"><img src="pic1.jpg" alt="image"></div>
        <div class="hero-box1"><img src="pic2.jpg" alt="image"></div>
        <div class="hero-box"><img src="pic3.jpg" alt="image"></div>
        <div class="hero-box1"><img src="pic4.jpg" alt="image"></div>
    </div>

    <hr>

    <div id="petList">
        <?php foreach($petsList as $pet): ?>
            <div class="pet-card">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <img src="<?php echo htmlspecialchars($pet['img']); ?>" alt="Pet Image" class="img-fluid rounded">
                    </div>
                    <div class="col-md-3 text-center">
                        <h5><?php echo htmlspecialchars($pet['name']); ?></h5>
                    </div>
                    <div class="col-md-5">
                        <p><?php echo htmlspecialchars($pet['desc']); ?></p>
                    </div>
                    
                    <div class="col-md-2 text-end">
                        <a href="appointment.php?animal_id=<?php echo $pet['animal_id']; ?>" class="btn2 text-decoration-none d-inline-block text-center">
                            Book Visit
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <button class="btn2 load-btn" onclick="loadMore()">
        Click here for more
    </button>

    <hr>

    <div class="footer">
        <h5>PetHaven</h5>
        <div class="row">
            <div class="col">
                <p>Helping pets find loving homes and families.</p>
                <p>Connecting pets with caring families, one adoption at a time.</p>
            </div>
            <div class="col">
                <li><a class="nav-link" href="contact.php">Home</a></li>
                <li><a class="nav-link" href="contact.php">Adoption</a></li>
                <li><a class="nav-link" href="contact.php">Vet Services</a></li>
                <li><a class="nav-link" href="contact.php">Contact</a></li>
                <li><a class="nav-link" href="about.php">About Us</a></li>
            </div>
            <div class="col-md-4">
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

<script src="script.js"></script>
</body>
</html>