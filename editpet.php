<?php
session_start();

// Security Check
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$host = 'localhost'; $dbName = 'pet_database'; $username = 'root'; $password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) { die("Database connection failed: " . $e->getMessage()); }

// Fetch Pet ID
$pet_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM adoptableanimals WHERE animal_id = ?");
$stmt->execute([$pet_id]);
$pet = $stmt->fetch();

if (!$pet) { die("Pet not found."); }

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE adoptableanimals SET name = ?, species = ?, description = ? WHERE animal_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_POST['name'], $_POST['species'], $_POST['description'], $pet_id]);
    
    // Redirect to pet list after saving
    header("Location: petinfo.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Pet Information</title>
    <link rel="stylesheet" href="adminstyles.css">
    <link rel="stylesheet" href="editstyles.css"> 
</head>
<body>

<div class="dashboard-screen-wrapper">
    <div class="edit-vet-container">
        <h1 class="edit-vet-title">Edit Pet information</h1>

        <form method="POST">
            <div class="edit-row">
                <div class="edit-label">NAME</div>
                <input type="text" name="name" class="edit-input" value="<?php echo htmlspecialchars($pet['name']); ?>" required>
            </div>

            <div class="edit-row">
                <div class="edit-label">SPECIES</div>
                <input type="text" name="species" class="edit-input" value="<?php echo htmlspecialchars($pet['species']); ?>" required>
            </div>

            <div class="edit-row">
                <div class="edit-label-info" style="align-self: stretch;">DESCRIPTION</div>
                <textarea name="description" class="edit-textarea" rows="6"><?php echo htmlspecialchars($pet['description']); ?></textarea>
            </div>
            
            <div class="edit-footer">
                <a href="petinfo.php" class="cancelbtn">Cancel</a>
                <button type="submit" class="save-btn">EDIT</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>