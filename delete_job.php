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

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "DELETE FROM jobs WHERE id=$id";

  if ($conn->query($sql) === TRUE) {
    echo "Job deleted successfully";
  } else {
    echo "Error deleting job: " . $conn->error;
  }
} else {
  echo "Invalid job ID";
}

$conn->close();
?>
