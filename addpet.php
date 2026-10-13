<?php
session_start();
$pdo = new PDO("mysql:host=localhost;dbname=pet_database;charset=utf8mb4", "root", "");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO adoptableanimals (name, species, description) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['name'], $_POST['species'], $_POST['description']]);
    header("Location: petinfo.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add New Pet</title>
    <link rel="stylesheet" href="adminstyles.css">
    <link rel="stylesheet" href="editstyles.css"> 
</head>
<body>
<div class="dashboard-screen-wrapper">
    <div class="edit-vet-container">
        <h1 class="edit-vet-title">Add New Pet</h1>
        <form method="POST">
            <div class="edit-row"><div class="edit-label">NAME</div><input type="text" name="name" class="edit-input" required></div>
            <div class="edit-row"><div class="edit-label">SPECIES</div><input type="text" name="species" class="edit-input" required></div>
            <div class="edit-row"><div class="edit-label" style="align-self: stretch;">DESCRIPTION</div><textarea name="description" class="edit-textarea" rows="6"></textarea></div>
            <div class="edit-footer">
                <a href="petinfo.php" style="margin-right: 20px; color: #003459; text-decoration: none;">Cancel</a>
                <button type="submit" class="save-btn">ADD PET</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>