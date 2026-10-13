<?php
// 1. INITIALIZE SESSION
session_start();

// 2. DATABASE CONFIGURATION & CONNECTION
$host     = 'localhost';
$dbName   = 'pet_database'; 
$username = 'root';               
$password = '';                   

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// 3. FORM PROCESSING LOGIC
$success_msg = "";
$error_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is actually logged in before letting them submit
    if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
        $error_msg = "You must be logged in to submit a stray animal report.";
    } else {
        // Capture inputs from the form safely
        $email           = trim($_POST['email'] ?? '');
        $contact_info    = trim($_POST['contact_info'] ?? '');
        $animal_type     = trim($_POST['animal_type'] ?? '');
        $additional_info = trim($_POST['additional_info'] ?? '');
 
        $user_id  = $_SESSION['user_id'] ?? null; 

        // Isolated Check 1: Ensure animal type text isn't empty
        if (empty($animal_type)) {
            $error_msg = "Please specify the Type of Animal before sending.";
        } 
        // Isolated Check 2: Ensure your active session has the user's ID key loaded
        elseif (empty($user_id)) {
            $error_msg = "System Session Error: Your user profile ID could not be identified. Please try logging out and logging back in.";
        } 
        // If both pass, write safely to the database table
        else {
            try {
                $sql = "INSERT INTO stray (user_id, email, contact_info, animal_type, additional_info) 
                        VALUES (:user_id, :email, :contact_info, :animal_type, :additional_info)";
                
                $stmt = $pdo->prepare($sql);
                
                // Execute with cleanly bound parameters
                $stmt->execute([
                    ':user_id'         => $user_id,
                    ':email'           => $email,
                    ':contact_info'    => $contact_info,
                    ':animal_type'     => $animal_type,
                    ':additional_info' => $additional_info
                ]);

                $success_msg = "Thank you! The stray animal report has been successfully recorded.";
            } catch (PDOException $e) {
                $error_msg = "Error saving report to database: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact - PetHaven</title>
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
                <li class="nav-item"><a class="nav-link" href="vets.php">Vet</a></li>
                <li class="nav-item"><a class="nav-link active" href="contact.php">Contact</a></li>
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

    <div class="contact-section">
        <h3>Contact Information of Stray Animals</h3>

        <?php if(!empty($success_msg)): ?>
            <div class="alert alert-success"><?php echo $success_msg; ?></div>
        <?php endif; ?>
        <?php if(!empty($error_msg)): ?>
            <div class="alert alert-danger"><?php echo $error_msg; ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true): ?>
            <form method="POST" action="contact.php">

                <div class="form-group-custom">
                    <label>Reporting As</label>
                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" disabled>
                </div>

                <div class="form-group-custom">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="form-group-custom">
                    <label>Contact Info</label>
                    <input type="text" name="contact_info" class="form-control">
                </div>

                <div class="form-group-custom">
                    <label>Type of Animal</label>
                    <input type="text" name="animal_type" class="form-control" required>
                </div>

                <div class="form-group-custom textarea-group">
                    <label>Additional Information</label>
                    <textarea name="additional_info" class="form-control" rows="6"></textarea>
                </div>

                <div class="send-btn-container">
                    <button type="submit" class="btn2">Send</button>
                </div>

            </form>
        <?php else: ?>
            <div class="alert alert-warning text-center my-4">
                <h5>Access Restricted</h5>
                <p>You must be signed into an account to report stray animals.</p>
                <a href="login.php" class="btn btn-primary mt-2">Go to Login / Registration</a>
            </div>
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
            <div class="col footer-links">
                <li><a class="nav-link" href="index.php">Home</a></li>
                <li><a class="nav-link" href="adoption.php">Adoption</a></li>
                <li><a class="nav-link" href="vets.php">Vet Services</a></li>
                <li><a class="nav-link" href="contact.php">Contact</a></li>
                <li><a class="nav-link" href="about.php">About Us</a></li>
            </div>
            <div class="col">
                <li><p>Email: support@pethaven.com</p></li>
                <li>
                    <p>
                        Social Media:
                        <i class="fa-brands fa-facebook fa-lg"></i>
                        <i class="fa-brands fa-instagram fa-lg"></i>
                        <i class="fa-brands fa-tiktok fa-lg"></i>
                    </p>
                </li>
            </div>
        </div>
        <div class="row2">
            <p>Privacy Policy | Terms of Service</p>
        </div>
    </div>

</div>

</body>
</html>