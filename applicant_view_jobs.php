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
  <h2>Available Jobs</h2>
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

  if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM jobs WHERE title LIKE '%$search%'";
  } else {
    $sql = "SELECT * FROM jobs";
  }

  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<h3>" . $row["title"] . "</h3>";
      echo "<p>Skill: " . $row["skill"] . "</p>";
      echo "<p>Salary: " . $row["salary"] . "</p>";
      echo "<p>Duration: " . $row["duration"] . "</p>";
      echo "<p>Location: " . $row["location"] . "</p>";
      echo "<p>Details: " . $row["details"] . "</p>";
      echo "<form action='apply_job.php' method='post'>";
      echo "<input type='hidden' name='job_id' value='" . $row["id"] . "'>";
      echo "<button type='submit'>Apply</button>";
      echo "</form>";
    }
  } else {
    echo "No jobs found";
  }

  $conn->close();
  ?>
</body>
</html>
