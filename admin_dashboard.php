<?php
// admin_dashboard.php
session_start();

// SECURITY CHECK: Ensure only logged-in administrators can access this workspace
if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_role'] !== 'admin') {
    // If not an admin, boot them back to the login page safely
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styleadmin.css">
</head>
<body>
<div class="box">
    <header class="container dashboard-header">
        <a href="#" class="admin_profile_badge" style="display: flex; align-items: center; gap: 12px; text-decoration: none; color: #003459;" title="Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?>">
            <span>Admin</span>
            <div class="admin-avatar-circle"></div>
        </a>
    </header>

    <main class="container">
        
        <h1 class="dashboard-title">Admin Dashboard</h1>

        <div class="dashboard-grid">
            
            <a href="userlist.php" class="menu-card">User List</a>
            
            <a href="vetinfo.php" class="menu-card">Vet Info</a>
            
            <a href="petinfo.php" class="menu-card">Pet Info</a>
            
            <a href="strayanimal.php" class="menu-card">Stray animal</a>
            
        </div>

        <div class="logout-container">
            <a href="logout.php" class="btn-logout">Logout System</a>
        </div>

    </main>
</div>
</body>
</html>