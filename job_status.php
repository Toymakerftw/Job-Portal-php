<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css"> <!-- Include your custom styles if needed -->
  <title>Job Application Status</title>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto mt-8">
    <?php
    session_start(); // Start the session

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'applicant') {
      // Redirect to login page if not logged in as an applicant
      header("Location: login.php");
      exit();
    }

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "portal";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Get the current user's ID
    $applicantId = $_SESSION['user_id'];

    // Query to fetch job applications and their status
    $jobStatusSql = "SELECT jobs.title, applications.status FROM applications JOIN jobs ON applications.job_id = jobs.id WHERE applications.applicant_id = $applicantId";

    $jobStatusResult = $conn->query($jobStatusSql);

    if ($jobStatusResult->num_rows > 0) {
      echo "<h2 class='text-2xl font-semibold mb-4'>Job Application Status</h2>";
      echo "<table class='w-full border-collapse border border-gray-300'>";
      echo "<thead><tr><th class='py-2 px-4 border-b'>Job Title</th><th class='py-2 px-4 border-b'>Status</th></tr></thead>";
      echo "<tbody>";
      while ($row = $jobStatusResult->fetch_assoc()) {
        echo "<tr><td class='py-2 px-4 border-b'>" . $row["title"] . "</td><td class='py-2 px-4 border-b'>" . $row["status"] . "</td></tr>";
      }
      echo "</tbody></table>";
    } else {
      echo "<p>No job applications found</p>";
    }

    $conn->close();
    ?>
  </div>
</body>
</html>
