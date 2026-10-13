<?php 
//$conn = mysqli_connect("localhost","root","","pet_database");
 ?>

<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "pet_database";

$conn = new mysqli($host, $user, $pass, $dbname);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

// Fetch first 3 pets
$limit = 3;
$sql = "SELECT * FROM pets LIMIT $limit";
$result = $conn->query($sql);
$pets = [];
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $pets[] = $row;
    }
}
?>