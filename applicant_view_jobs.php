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
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <title>Applicant Dashboard</title>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto mt-8">
    <h2 class="text-2xl font-semibold mb-4">Available Jobs</h2>
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
          echo "<div class='bg-white rounded-md p-4 mb-4'>";
          echo "<h3 class='text-xl font-semibold mb-2'>" . $row["title"] . "</h3>";
          echo "<p class='text-gray-700 mb-2'>Skill: " . $row["skill"] . "</p>";
          echo "<p class='text-gray-700 mb-2'>Salary: " . $row["salary"] . "</p>";
          echo "<p class='text-gray-700 mb-2'>Duration: " . $row["duration"] . "</p>";
          echo "<p class='text-gray-700 mb-2'>Location: " . $row["location"] . "</p>";
          echo "<p class='text-gray-700 mb-2'>Details: " . $row["details"] . "</p>";
          echo "<form action='apply_job.php' method='post' class='mb-2'>";
          echo "<input type='hidden' name='job_id' value='" . $row["id"] . "'>";
          echo "<button type='submit' class='w-full bg-black text-white p-2 rounded hover:bg-gray-800'>Apply</button>";
          echo "</form>";
          echo "</div>";
        }
      } else {
        echo "<p>No jobs found</p>";
      }

      $conn->close();
    ?>
  </div>
</body>
</html>

