<?php
session_start(); // Start the session

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
  // Redirect to login page if not logged in as an employer
  header("Location: login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['applicant_id']) && isset($_POST['job_id'])) {
  $applicantId = $_POST['applicant_id'];
  $jobId = $_POST['job_id']; // Add code to retrieve the job ID from the form

  // Connect to the database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "portal";
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Update applicant status to shortlisted in the database
  $updateSql = "UPDATE applications SET status = 'shortlisted' WHERE applicant_id = $applicantId AND job_id = $jobId"; // Modify the update query

  if ($conn->query($updateSql) === TRUE) {
    echo "Applicant shortlisted successfully";
  } else {
    echo "Error: " . $conn->error;
  }

  $conn->close();
} else {
  echo "Invalid request";
}
?>