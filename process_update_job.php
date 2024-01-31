<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST['id'];
  $title = $_POST['title'];
  $skill = $_POST['skill'];
  $salary = $_POST['salary'];
  $duration = $_POST['duration'];
  $location = $_POST['location'];
  $details = $_POST['details'];

  $sql = "UPDATE jobs SET title='$title', skill='$skill', salary='$salary', duration='$duration', location='$location', details='$details' WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    echo "Job updated successfully";
  } else {
    echo "Error updating job: " . $conn->error;
  }
}

$conn->close();
?>
