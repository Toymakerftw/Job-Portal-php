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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['job_id'])) {
  $jobId = $_POST['job_id'];
  // Fetch the applicant's ID from the session
  $applicantId = $_SESSION['user_id'];

  // Insert the application into the applications table
  $sql = "INSERT INTO applications (job_id, applicant_id) VALUES ($jobId, $applicantId)";

  if ($conn->query($sql) === TRUE) {
    echo "Job application submitted successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
?>
