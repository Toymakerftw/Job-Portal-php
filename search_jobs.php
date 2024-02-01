<?php
// Connect to the database
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

// Fetch job details based on the search query
if (isset($_GET['search'])) {
  $searchQuery = $_GET['search'];

  // Perform a database query to search for jobs based on the search query
  $sql = "SELECT * FROM jobs WHERE title LIKE '%$searchQuery%'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Fetch job details from the database
    $jobs = array();
    while ($row = $result->fetch_assoc()) {
      $jobs[] = $row;
    }

    // Output the job details as JSON
    echo json_encode($jobs);
  } else {
    echo "No jobs found matching the search criteria";
  }
}

$conn->close();
?>