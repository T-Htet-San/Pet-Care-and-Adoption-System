<?php
// 1. INITIALIZE SESSION
session_start();

// 2. DATABASE CONNECTION CONFIGURATION
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

// 3. PROCESSING THE SIGNUP FORM SUBMISSION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname        = trim($_POST['firstname'] ?? '');
    $lastname         = trim($_POST['lastname'] ?? '');
    $username         = trim($_POST['username'] ?? '');
    $password         = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    
    if (!empty($firstname) && !empty($lastname) && !empty($username) && !empty($password) && !empty($confirm_password)) {
        
        if ($password !== $confirm_password) {
            $error_message = "Passwords do not match!";
        } else {
            try {
                // Check if username already exists in your phpMyAdmin 'users' table
                $stmt = $pdo->prepare('SELECT user_id FROM users WHERE username = :username');
                $stmt->execute(['username' => $username]);
                
                if ($stmt->fetch()) {
                    $error_message = "Username is already taken!";
                } else {
                    
                    // UPDATED: Saving raw password exactly as typed without any encryption
                    $stmt = $pdo->prepare('INSERT INTO users (firstname, lastname, username, password, role) VALUES (:firstname, :lastname, :username, :password, :role)');
                    
                    $success = $stmt->execute([
                        'firstname' => $firstname,
                        'lastname'  => $lastname,
                        'username'  => $username,
                        'password'  => $password, // Normal, readable text format
                        'role'      => 'user'     
                    ]);

                    if ($success) {
                        // Redirect directly to your login page upon success
                        header("Location: login.php?registration=success");
                        exit;
                    } else {
                        $error_message = "Something went wrong. Please try again.";
                    }
                }
            } catch (\PDOException $e) {
                $error_message = "Database error: " . $e->getMessage();
            }
        }
    } else {
        $error_message = "Please fill in all fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="loginstyles.css">
</head>
<body>

    <div class="container login-wrapper">
        <div class="login-card">
            
            <div class="login-image-side">
                <img src="login.jpg" alt="Sign Up Visual">
            </div>

            <div class="login-form-side">
                
                <div class="login-card-header">
                    <div class="user-avatar"></div>
                    <h2>Sign Up</h2>
                </div>

                <form id="signupForm" action="signup.php" method="POST" class="login-card-body">
                    
                    <?php if (isset($error_message)): ?>
                        <div style="color: #e53e3e; font-family: sans-serif; margin-bottom: 15px; font-size: 14px; text-align: center; font-weight: bold;">
                            <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="input-group">
                        <input type="text" id="firstname" name="firstname" class="form-control-custom" placeholder="First name" value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : ''; ?>" required>
                    </div>

                    <div class="input-group">
                        <input type="text" id="lastname" name="lastname" class="form-control-custom" placeholder="Last name" value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>" required>
                    </div>

                    <div class="input-group">
                        <input type="text" id="username" name="username" class="form-control-custom" placeholder="Username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                    </div>

                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control-custom" placeholder="Password" required>
                    </div>

                    <div class="input-group" style="margin-bottom: 25px;">
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control-custom" placeholder="Confirm Password" required>
                    </div>

                    <button type="submit" class="btn-main-login">Sign Up</button>

                    <div class="login-card-footer">
                        <a href="login.php" class="create-link" id="loginLink">Already have an account</a>
                        <button type="button" class="btn2" id="btnBack">Back</button>
                    </div>

                </form>

            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnBack = document.getElementById('btnBack');
            const form = document.getElementById('signupForm');

            btnBack.addEventListener('click', () => {
                window.history.back();
            });

            form.addEventListener('submit', (e) => {
                const pass = document.getElementById('password').value;
                const confirmPass = document.getElementById('confirm_password').value;

                if (pass !== confirmPass) {
                    e.preventDefault();
                    alert("Passwords do not match!");
                }
            });
        });
    </script>
</body>
</html>