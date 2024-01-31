<?php
session_start(); // Start the session

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'applicant') {
  // Redirect to login page if not logged in as an applicant
  header("Location: login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Applicant Dashboard</title>
</head>
<body>
  
  <h2>Welcome to the Applicant Dashboard</h2>
  <?php
    $userId = $_SESSION['user_id'];
    // Fetch employer's name from the users table based on their ID
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

    $sql = "SELECT username FROM users WHERE id = $userId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $applicantName = $row["username"];
      echo "<p>Welcome, Applicant: $applicantName</p>";
    } else {
      echo "Employer name not found";
    }

    $conn->close();
  ?>
  <h2>Search for Jobs</h2>
  <form action="applicant_dash.php" method="get">
    <input type="text" name="search" placeholder="Search by Job Title">
    <button type="submit">Search</button>
  </form>

  <ul>
    <li><a href="applicant_view_jobs.php">View Jobs</a></li>
    <li><a href="applicant_details.php">Add/Edit Details</a></li>
    <li><a href="job_status.php">View Jobs Status</a></li>
  </ul>

</body>
</html>
