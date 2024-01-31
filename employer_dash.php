<?php
session_start(); // Start the session

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
  // Redirect to login page if not logged in as an employer
  header("Location: login.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employer Dashboard</title>
</head>
<body>
  <h2>Welcome to the Employer Dashboard</h2>
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
      $employerName = $row["username"];
      echo "<p>Welcome, Employer: $employerName</p>";
    } else {
      echo "Employer name not found";
    }

    $conn->close();
  ?>

  <ul>
    <li><a href="add_job.php">Add Job</a></li>
    <li><a href="view_jobs.php">View Jobs</a></li>
  </ul>
</body>
</html>
