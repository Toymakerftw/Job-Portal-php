<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
    // Redirect to login page if not logged in as an employer
    header("Location: login.php");
    exit();
  }

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

  // Fetch the employer's ID from the session
  $userId = $_SESSION['user_id'];

  $title = $_POST['title'];
  $skill = $_POST['skill'];
  $salary = $_POST['salary'];
  $duration = $_POST['duration'];
  $location = $_POST['location'];
  $details = $_POST['details'];

  $sql = "INSERT INTO jobs (title, skill, salary, duration, location, details, employer_id) VALUES ('$title', '$skill', '$salary', '$duration', '$location', '$details', '$userId')";

  if ($conn->query($sql) === TRUE) {
    echo "New job added successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <title>Add Job</title>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto mt-8">
    <div class="bg-white p-8 rounded shadow-md">
      <h2 class="text-2xl font-semibold mb-4">Add Job</h2>
      <form id="addJobForm" action="add_job.php" method="post" class="space-y-4">
        <input type="text" id="title" name="title" placeholder="Title" required
               class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black">
        <input type="text" id="skill" name="skill" placeholder="Skill" required
               class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black">
        <input type="number" id="salary" name="salary" placeholder="Salary" required
               class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black">
        <input type="text" id="duration" name="duration" placeholder="Duration" required
               class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black">
        <input type="text" id="location" name="location" placeholder="Location" required
               class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black">
        <textarea id="details" name="details" placeholder="Details" required
                  class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black"></textarea>
        <button type="submit" class="w-full bg-black text-white p-2 rounded hover:bg-gray-800">Add Job</button>
      </form>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>
