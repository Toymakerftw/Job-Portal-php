<?php
session_start(); // Start the session

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
  // Redirect to login page if not logged in as an employer
  header("Location: login.php");
  exit();
}

if (isset($_GET['applicant_id']) && isset($_GET['job_id'])) {
  $applicantId = $_GET['applicant_id'];
  $jobId = $_GET['job_id']; // Add code to retrieve the job ID from the form

  // Connect to the database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "portal";
  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Query to fetch applicant details
  $applicantDetailsSql = "SELECT * FROM applicants WHERE id = $applicantId";
  $applicantDetailsResult = $conn->query($applicantDetailsSql);

  if ($applicantDetailsResult->num_rows > 0) {
    $applicant = $applicantDetailsResult->fetch_assoc();
    // Display applicant details
    echo "<h2>Applicant Details</h2>";
    echo "<p>Name: " . $applicant['name'] . "</p>";
    echo "<p>Address: " . $applicant['address'] . "</p>";
    echo "<p>Email: " . $applicant['email'] . "</p>";
    echo "<p>Phone: " . $applicant['phone'] . "</p>";
    echo "<p>Education Qualification: " . $applicant['qualification'] . "</p>";
    echo "<p>Certifications: " . $applicant['certifications'] . "</p>";
    echo "<p>Experience: " . $applicant['experience'] . "</p>";
    echo "<p>Expected Salary: " . $applicant['salary'] . "</p>";
    // You can add more details as per your database schema
    echo "<a href='" . $applicant['resume_path'] . "' download>Download Resume</a>";

  // Add a button to reject the applicant
  echo "<form action='reject_applicant.php' method='post'>";
  echo "<input type='hidden' name='applicant_id' value='" . $applicant['id'] . "'>";
  echo "<input type='hidden' name='job_id' value='" . $jobId . "'>"; // Add hidden input for job ID
  echo "<input type='submit' value='Reject Applicant'>";
  echo "</form>";

  // Add a button to shortlist the applicant
  echo "<form action='shortlist_applicant.php' method='post'>";
  echo "<input type='hidden' name='applicant_id' value='" . $applicant['id'] . "'>";
  echo "<input type='hidden' name='job_id' value='" . $jobId . "'>"; // Add hidden input for job ID
  echo "<input type='submit' value='Shortlist Applicant'>";
  echo "</form>";

  } else {
    echo "Applicant details not found";
  }

  $conn->close();
} else {
  echo "Applicant ID not provided";
}
?>
