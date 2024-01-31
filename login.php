<?php
session_start(); // Start the session

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

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
  $row = $result->fetch_assoc();
  $_SESSION['user_id'] = $row['id']; // Store user id in session
  $_SESSION['role'] = $row['role']; // Store user role in session

  if ($row['role'] == 'applicant') {
    header("Location: applicant_dash.php");
  } elseif ($row['role'] == 'employer') {
    header("Location: employer_dash.php");
  }
} else {
  echo "Invalid username or password";
}

$conn->close();
?>

