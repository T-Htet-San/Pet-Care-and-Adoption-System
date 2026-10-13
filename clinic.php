<?php
$vets = [
    [
        "name" => "Happy Paws Veterinary Clinic",
        "desc" => "Providing complete care for pets including vaccinations, surgery, and grooming.",
        "location" => "Downtown Area",
        "img" => "vet1.jpg"
    ],
    [
        "name" => "Healthy Pets Center",
        "desc" => "Experienced veterinarians offering emergency and routine checkups.",
        "location" => "North City",
        "img" => "vet2.jpg"
    ],
    [
        "name" => "Care Animal Hospital",
        "desc" => "Advanced medical care with modern equipment and friendly staff.",
        "location" => "West District",
        "img" => "vet3.jpg"
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Vet Services - PetHaven</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

<!-- NAVBAR (SAME AS INDEX) -->
<nav class="navbar navbar-expand-lg">

<a class="navbar-brand fw-bold" href="index.php">PetHaven</a>

<div class="collapse navbar-collapse">

<ul class="navbar-nav mx-auto">
<li class="nav-item"><a class="nav-link" href="adoption.php">Adoption</a></li>
<li class="nav-item"><a class="nav-link active" href="vet.php">Vet</a></li>
<li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
<li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
</ul>

<button class="btn">Login/Register</button>

</div>
</nav>


<!-- PAGE TITLE -->
<div class="mt-5 text-center">
    <h3>Find Trusted Veterinary Services</h3>
    <p>Explore nearby veterinary clinics and hospitals for your pet’s health and care.</p>
</div>


<!-- SEARCH BAR -->
<div class="search-box text-center mt-4 mb-5">
    <input type="text" class="form-control w-50 mx-auto" placeholder="Search by location or clinic name...">
</div>


<!-- VET CARDS -->
<div id="vetList">

<?php foreach($vets as $vet): ?>

<div class="pet-card">

<div class="row align-items-center">

<div class="col-md-2">
<img src="<?php echo $vet['img']; ?>">
</div>

<div class="col-md-3 text-center">
<h5><?php echo $vet['name']; ?></h5>
<p><?php echo $vet['location']; ?></p>
</div>

<div class="col-md-5">
<p><?php echo $vet['desc']; ?></p>
</div>

<div class="col-md-2 text-end">
<button class="btn2">View</button>
</div>

</div>

</div>

<?php endforeach; ?>

</div>


<!-- LOAD MORE -->
<button class="btn2 load-btn">
Load more clinics
</button>


<hr>


<!-- FOOTER (SAME AS INDEX) -->
<div class="footer">

<h5>PetHaven</h5>

<div class="row">

<div class="col-md-4">
<p>Helping pets find loving homes and families.</p>
<p>Connecting pets with caring families, one adoption at a time.</p>
</div>

<div class="col-md-4">
    <li><a class="nav-link" href="contact.php">Home</a></li>
    <li><a class="nav-link" href="contact.php">Adoption</a></li>
    <li><a class="nav-link" href="contact.php">Vet Services</a></li>
    <li><a class="nav-link" href="contact.php">Contact</a></li>
    <li><a class="nav-link" href="contact.php">About Us</a></li>
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

</body>
</html>