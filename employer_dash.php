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
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <title>Employer Dashboard</title>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto mt-8">
    <h2 class="text-2xl font-semibold mb-4">Welcome to the Employer Dashboard</h2>
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
        echo "<p class='mb-4'>Welcome, Employer: $employerName</p>";
      } else {
        echo "Employer name not found";
      }

      $conn->close();
    ?>

    <ul class="space-y-2">
      <li><a href="add_job.php" class="text-blue-500 hover:underline">Add Job</a></li>
      <li><a href="view_jobs.php" class="text-blue-500 hover:underline">View Jobs</a></li>
    </ul>
  </div>
</body>
</html>
