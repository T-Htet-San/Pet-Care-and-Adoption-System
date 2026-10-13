<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "pet_database";

$conn = new mysqli($host, $user, $pass, $dbname);
if($conn->connect_error) die("Connection failed: ".$conn->connect_error);

// Get offset from request
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = 3;

$sql = "SELECT * FROM pets LIMIT $offset, $limit";
$result = $conn->query($sql);
$pets = [];
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $pets[] = $row;
    }
}

echo json_encode($pets);
$conn->close();
?>