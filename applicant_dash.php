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
    <h2 class="text-2xl font-semibold mb-4">Welcome to the Applicant Dashboard</h2>
    <?php
      $userId = $_SESSION['user_id'];
      // Fetch applicant's name from the users table based on their ID
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
        echo "<p class='mb-4'>Welcome, Applicant: $applicantName</p>";
      } else {
        echo "Applicant name not found";
      }

      $conn->close();
    ?>

    <h2 class="text-xl font-semibold mb-2">Search for Jobs</h2>
    <form action="applicant_dash.php" method="get" class="mb-4">
      <div class="flex items-center">
        <input type="text" name="search" placeholder="Search by Job Title" class="rounded-l-full w-full py-2 px-4 mr-0 border-t border-b border-l text-gray-800 border-gray-200 bg-white">
        <button type="submit" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-r-full focus:outline-none focus:shadow-outline">Search</button>
      </div>
    </form>

    <ul>
      <li class="mb-2"><a href="applicant_view_jobs.php" class="w-full bg-black text-white p-2 rounded hover:bg-gray-800">View Jobs</a></li>
      <li class="mb-2"><a href="applicant_details.php" class="w-full bg-black text-white p-2 rounded hover:bg-gray-800">Add/Edit Details</a></li>
      <li><a href="job_status.php" class="w-full bg-black text-white p-2 rounded hover:bg-gray-800">View Jobs Status</a></li>
    </ul>
  </div>

</body>
</html>
