<?php
session_start(); // Start the session

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
  // Redirect to login page if not logged in as an employer
  header("Location: login.php");
  exit();
}

if (isset($_GET['job_id'])) {
  $jobId = $_GET['job_id'];

  // Connect to the database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "portal";
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Query to fetch applicants for the selected job
  $applicantsSql = "SELECT * FROM applications WHERE job_id = $jobId";
  $applicantsResult = $conn->query($applicantsSql);

  if ($applicantsResult->num_rows > 0) {
    echo "<h2>Applicants for the Job</h2>";
    echo "<ul>";
    while ($applicant = $applicantsResult->fetch_assoc()) {
      $applicantId = $applicant["applicant_id"];
      $applicantNameSql = "SELECT username FROM users WHERE id = $applicantId";
      $applicantNameResult = $conn->query($applicantNameSql);
      $applicantName = $applicantNameResult->fetch_assoc()["username"];
      echo "<li><a href='view_applicant_details.php?applicant_id=$applicantId'>$applicantName</a></li>";
    }
    echo "</ul>";
  } else {
    echo "No applicants for this job";
  }

  $conn->close();
} else {
  echo "Job ID not provided";
}
?>
