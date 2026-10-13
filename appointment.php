<?php
// appointment.php
session_start();

// SECURITY CHECK: Redirect to login if user isn't logged in yet
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// 1. DATABASE CONFIGURATION
$host     = 'localhost';
$dbName   = 'pet_database'; 
$username = 'root';               
$password = '';                   

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// 2. FETCH CHOSEN ANIMAL DETAILS
$animal_id = isset($_GET['animal_id']) ? intval($_GET['animal_id']) : 0;

if ($animal_id === 0) {
    die("Error: No animal ID was provided in the URL! Your link from index.php might be broken.");
}

$stmt = $pdo->prepare("SELECT * FROM adoptableanimals WHERE animal_id = :id");
$stmt->execute(['id' => $animal_id]);
$pet = $stmt->fetch();

if (!$pet) {
    die("Error: No pet was found in your database matching the animal_id: " . htmlspecialchars($animal_id));
}

// 3. PROCESS THE APPOINTMENT SUBMISSION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_date = $_POST['appointment_date'] ?? '';

    // FIXED LINE 39 AREA: We select * to avoid missing an 'id' column name mismatch
    $user_stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $user_stmt->execute(['username' => $_SESSION['username']]);
    $user = $user_stmt->fetch();

    if ($user && !empty($appointment_date)) {
        // DETECT USER ID COLUMN NAME AUTOMATICALLY
        // Checks if it's 'id', 'user_id', or grabs the first column of the users table
        $detected_user_id = $user['id'] ?? $user['user_id'] ?? reset($user);

        try {
            // Logs data to your appointments table schema
            $insert_stmt = $pdo->prepare('INSERT INTO appointments (user_id, animal_id, appointment_date) VALUES (:user_id, :animal_id, :appointment_date)');
            $insert_stmt->execute([
                'user_id' => $detected_user_id,
                'animal_id' => $animal_id,
                'appointment_date' => $appointment_date
            ]);
            
            header("Location: index.php?appointment=success");
            exit;
        } catch (PDOException $e) {
            $error_message = "Error scheduling appointment: " . $e->getMessage();
        }
    } else {
        $error_message = "Please select a valid date and time.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule an Appointment - PetHaven</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="styleadmin.css"> 
</head>
<body>

    <div class="dashboard-screen-wrapper">
        <div class="dashboard-box" style="max-width: 600px; padding-left: 430px;">
            
            <header class="dashboard-header">
                <div class="admin-profile-badge">
                    <span>Logged in as: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
                    <div class="admin-avatar-circle"></div>
                </div>
            </header>

            <main>
                <h1 class="dashboard-title" style="text-align: center;">Book an Appointment</h1>

                <?php if (isset($error_message)): ?>
                    <div style="color: red; font-family: sans-serif; margin-bottom: 20px; font-weight: bold; text-align: center;">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <div class="table-card" style="padding: 25px; align-items: center; text-align: center; gap: 15px;">
                    
                    <img src="<?php echo htmlspecialchars($pet['img']); ?>" 
                         alt="<?php echo htmlspecialchars($pet['name']); ?>" 
                         style="width: 180px; height: 180px; object-fit: cover; border: 2px solid #003459; border-radius: 12px; box-shadow: 2px 2px 8px rgba(0,0,0,0.1);">
                    
                    <h2 style="margin: 5px 0 0 0; font-family: 'Georgia', serif; color: #003459;">
                        Meet <?php echo htmlspecialchars($pet['name']); ?>
                    </h2>
                </div>

                <form action="appointment.php?animal_id=<?php echo $animal_id; ?>" method="POST" style="margin-top: 25px;">
                    
                    <div style="margin-bottom: 25px; display: flex; flex-direction: column; gap: 8px;">
                        <label for="appointment_date" style="font-family: 'Georgia', serif; font-size: 18px; color: #003459; font-weight: bold;">
                            Select Date & Time:
                        </label>
                        <input type="datetime-local" id="appointment_date" name="appointment_date" required 
                               style="font-family: 'Georgia', serif; font-size: 16px; padding: 12px; border: 2px solid #003459; border-radius: 6px; color: #003459; background-color: #ffffff; box-sizing: border-box; width: 100%;">
                    </div>

                    <div style="display: flex; gap: 20px; justify-content: center; align-items: center; margin-top: 10px;">
                        <a href="index.php" class="btn-back" style="text-align: center; min-width: 100px; line-height: 24px;">Cancel</a>
                        
                        <button type="submit" class="menu-card" style="border-radius: 8px; font-size: 16px; padding: 6px 25px; min-width: 150px; margin-bottom: 0;">
                            Confirm Booking <i class="fa-solid fa-calendar-check"></i>
                        </button>
                    </div>

                </form>
            </main>

        </div>
    </div>

</body>
</html>