<?php
// 1. INITIALIZE SESSION (Must run first to read user login state cookies)
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>About Us - PetHaven</title>

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
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link active" href="about.php">About Us</a></li>
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


    <div class="about-hero">

        <img src="about1.jpg" alt="About Us Banner">

        <div class="hero-overlay">
            <h1>About Us</h1>
        </div>

    </div>


    <div class="about-info">

        <div class="info-box">
            <h3>Our Mission</h3>
            <p>
                Our mission is to help abandoned and rescued pets
                find safe, loving, and permanent homes while
                supporting responsible pet ownership.
            </p>
        </div>

        <div class="info-box">
            <h3>Our Vision</h3>
            <p>
                We envision a world where every pet receives
                proper care, compassion, and a family that
                truly values them.
            </p>
        </div>

        <div class="info-box">
            <h3>Our Purpose</h3>
            <p>
                PetHaven exists to connect people with pets,
                provide adoption resources, and promote
                animal welfare in the community.
            </p>
        </div>

    </div>


    <div class="team-section">

        <h2>Our Team</h2>

        <div class="team-grid">

            <div class="team-card">
                <img src="nick.jpg" alt="Nick">
                <h4>Nick</h4>
            </div>

            <div class="team-card">
                <img src="heather.jpg" alt="Heather">
                <h4>Heather</h4>
            </div>

            <div class="team-card">
                <img src="josh.jpg" alt="Josh">
                <h4>Josh</h4>
            </div>

        </div>

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
                <li>
                    <p>Social Media Option: 
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