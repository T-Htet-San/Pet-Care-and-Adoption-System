<?php
session_start();

// Ensure only admins can edit
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$host = 'localhost';
$dbName = 'pet_database';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get the ID from the URL
$vet_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the vet info
$stmt = $pdo->prepare("SELECT * FROM vets WHERE vet_id = ?");
$stmt->execute([$vet_id]);
$vet = $stmt->fetch();

if (!$vet) {
    die("Veterinarian not found.");
}

// Update the database when form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE vets SET name = ?, email = ?, qualification = ?, experience = ?, detail = ? WHERE vet_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['name'], 
        $_POST['email'], 
        $_POST['qualification'], 
        $_POST['experience'], 
        $_POST['detail'], 
        $vet_id
    ]);
    
    // Redirect back to the vet listing page after save
    header("Location: vets.php?status=success");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Vet Information</title>
    <link rel="stylesheet" href="adminstyles.css">
    <link rel="stylesheet" href="editstyles.css"> 
</head>
<body>

<div class="dashboard-screen-wrapper">
    <div class="edit-vet-container">
        <h1 class="edit-vet-title">Edit Vet information</h1>

        <form method="POST">
            <div class="edit-row">
                <div class="edit-label">Dr. NAME</div>
                <input type="text" name="name" class="edit-input" value="<?php echo htmlspecialchars($vet['name']); ?>" required>
            </div>

            <div class="edit-row">
                <div class="edit-label">EMAIL</div>
                <input type="email" name="email" class="edit-input" value="<?php echo htmlspecialchars($vet['email']); ?>" required>
            </div>

            <div class="edit-row">
                <div class="edit-label">QUALIFICATION</div>
                <input type="text" name="qualification" class="edit-input" value="<?php echo htmlspecialchars($vet['qualification']); ?>">
            </div>

            <div class="edit-row">
                <div class="edit-label">EXPERIENCE</div>
                <input type="text" name="experience" class="edit-input" value="<?php echo htmlspecialchars($vet['experience']); ?>">
            </div>

            <div class="edit-row">
                <div class="edit-label-info" style="align-self: stretch;">ADDITIONAL INFORMATION</div>
                <textarea name="detail" class="edit-textarea" rows="6"><?php echo htmlspecialchars($vet['detail']); ?></textarea>
            </div>
            
            <div class="edit-footer">
                <a href="vetinfo.php" class="cancelbtn">Cancel</a>
                <button type="submit" class="save-btn">EDIT</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>