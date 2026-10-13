<?php
// login.php
session_start();

// FIX 1: Corrected redirection check to 'index.php' instead of 'index1.php'
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
    if ($_SESSION['user_role'] === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: index.php"); // Fixed to match your standard homepage
    }
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

// 2. PROCESSING THE LOGIN FORM SUBMISSION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if (!empty($username) && !empty($password)) {
        // Query to find the user by their username
        $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        // PLAIN-TEXT CHECK: Directly comparing passwords with ===
        if ($user && $password === $user['password']) {
            
            session_regenerate_id(true);

            // Set session variables upon successful login
            $_SESSION['user_logged_in'] = true;
            $_SESSION['username']       = $user['username'];
            $_SESSION['user_role']      = $user['role']; 
            
            // THE CRITICAL FIX: Storing the unique user id into the session
            $_SESSION['user_id']        = $user['user_id']; 

            // Force PHP to completely save and write the data 
            // to the browser memory BEFORE launching the page redirection.
            session_write_close();

            // Redirect based on role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            $error_message = "Invalid Username or Password!";
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
    <title>Login</title>
    <link rel="stylesheet" href="loginstyles.css">
</head>
<body>

    <div class="container login-wrapper">
        <div class="login-card">
            
            <div class="login-image-side">
                <img src="login.jpg" alt="Login Visual" class="imglogin">
            </div>

            <div class="login-form-side">
                
                <div class="login-card-header">
                    <div class="user-avatar"></div>
                    <h2>Login</h2>
                </div>

                <form id="loginForm" action="login.php" method="POST" class="login-card-body">
                    
                    <?php if (isset($_GET['registration']) && $_GET['registration'] === 'success'): ?>
                        <div style="color: green; font-family: sans-serif; margin-bottom: 15px; font-size: 14px; font-weight: bold; text-align: center;">
                            Registration successful! Please log in.
                        </div>
                    <?php endif; ?>

                    <?php if (isset($error_message)): ?>
                        <div style="color: red; font-family: sans-serif; margin-bottom: 15px; font-size: 14px; font-weight: bold; text-align: center;">
                            <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="input-group">
                        <input type="text" id="username" name="username" class="form-control-custom" placeholder="Username" required>
                    </div>

                    <div class="input-group">
                        <input type="password" id="password" name="password" class="form-control-custom" placeholder="Password" required>
                    </div>

                    <a href="#" class="forgot-link" id="forgotPassLink">Forgot Password?</a>

                    <button type="submit" class="btn-main-login">Login</button>

                    <div class="login-card-footer">
                        <a href="signup.php" class="create-link" id="createAccountLink">Create Account</a>
                        <button type="button" class="btn2" id="btnBack">Back</button>
                    </div>

                </form>
                
            </div> </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btnBack = document.getElementById('btnBack');
            const forgotPassLink = document.getElementById('forgotPassLink');

            btnBack.addEventListener('click', () => {
                window.history.back();
            });

            forgotPassLink.addEventListener('click', (e) => {
                e.preventDefault();
                alert('Forgot Password feature coming soon!');
            });
        });
    </script>
</body>
</html>