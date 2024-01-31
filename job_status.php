<?php
session_start(); // Start the session

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'applicant') {
  // Redirect to login page if not logged in as an applicant
  header("Location: login.php");
  exit();
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "portal";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the current user's ID
$applicantId = $_SESSION['user_id'];

// Query to fetch job applications and their status
$jobStatusSql = "SELECT jobs.title, applications.status FROM applications JOIN jobs ON applications.job_id = jobs.id WHERE applications.applicant_id = $applicantId";

$jobStatusResult = $conn->query($jobStatusSql);

if ($jobStatusResult->num_rows > 0) {
  echo "<h2>Job Application Status</h2>";
  echo "<table>";
  echo "<tr><th>Job Title</th><th>Status</th></tr>";
  while ($row = $jobStatusResult->fetch_assoc()) {
    echo "<tr><td>" . $row["title"] . "</td><td>" . $row["status"] . "</td></tr>";
  }
  echo "</table>";
} else {
  echo "No job applications found";
}

$conn->close();
?>
