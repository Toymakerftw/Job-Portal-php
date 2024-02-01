<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css"> <!-- Include your custom styles if needed -->
  <title>View Applicants</title>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto mt-8 p-8 bg-white rounded-md">
    <?php
    session_start(); // Start the session

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
      // Redirect to login page if not logged in as an employer
      header("Location: login.php");
      exit();
    }

    if (isset($_GET['job_id'])) {
      $jobId = $_GET['job_id'];

      // Connect to the database
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "portal";
      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Query to fetch applicants for the selected job
      //$applicantsSql = "SELECT * FROM applications WHERE job_id = $jobId";
      $applicantsSql = "SELECT * FROM applications WHERE job_id = $jobId AND status != 'rejected'";
      $applicantsResult = $conn->query($applicantsSql);

      if ($applicantsResult->num_rows > 0) {
        echo "<h2 class='text-2xl font-semibold mb-4'>Applicants for the Job</h2>";
        echo "<ul>";
        while ($applicant = $applicantsResult->fetch_assoc()) {
          $applicantId = $applicant["applicant_id"];
          $applicantNameSql = "SELECT username FROM users WHERE id = $applicantId";
          $applicantNameResult = $conn->query($applicantNameSql);
          $applicantName = $applicantNameResult->fetch_assoc()["username"];
          echo "<li><a href='view_applicant_details.php?applicant_id=$applicantId&job_id=$jobId' class='text-blue-500 hover:underline'>$applicantName</a></li>"; // Pass job ID to view_applicant_details.php
        }
        echo "</ul>";
      } else {
        echo "<p>No applicants for this job</p>";
      }

      $conn->close();
    } else {
      echo "<p>Job ID not provided</p>";
    }
    ?>
  </div>
</body>
</html>
