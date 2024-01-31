<?php
session_start(); // Start the session

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer') {
  // Redirect to login page if not logged in as an employer
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
  <title>View Jobs and Applicants</title>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto mt-8">
    <h2 class="text-2xl font-semibold mb-4">Jobs List</h2>
    <table class="w-full border-collapse border border-gray-300">
      <thead>
        <tr>
          <th class="py-2 px-4 border-b">Title</th>
          <th class="py-2 px-4 border-b">Skill</th>
          <th class="py-2 px-4 border-b">Salary</th>
          <th class="py-2 px-4 border-b">Duration</th>
          <th class="py-2 px-4 border-b">Location</th>
          <th class="py-2 px-4 border-b">Details</th>
          <th class="py-2 px-4 border-b">Actions</th>
          <th class="py-2 px-4 border-b">Applicants</th>
        </tr>
      </thead>
      <tbody>
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

          $employerId = $_SESSION['user_id']; // Retrieve employer's ID from the session

          $sql = "SELECT * FROM jobs WHERE employer_id = $employerId";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td class='py-2 px-4 border-b'>" . $row["title"] . "</td>";
              echo "<td class='py-2 px-4 border-b'>" . $row["skill"] . "</td>";
              echo "<td class='py-2 px-4 border-b'>" . $row["salary"] . "</td>";
              echo "<td class='py-2 px-4 border-b'>" . $row["duration"] . "</td>";
              echo "<td class='py-2 px-4 border-b'>" . $row["location"] . "</td>";
              echo "<td class='py-2 px-4 border-b'>" . $row["details"] . "</td>";
              echo "<td class='py-2 px-4 border-b flex'>
                      <a href='delete_job.php?id=" . $row["id"] . "' class='text-white-500 hover:bg-gray-800 p-2 rounded inline-block bg-black text-white px-3 py-1 mr-2'>Delete</a>
                      <a href='update_job.php?id=" . $row["id"] . "' class='text-white-500 hover:bg-gray-800 p-2 rounded inline-block bg-black text-white px-3 py-1'>Update</a>
                    </td>";
              echo "<td class='py-2 px-4 border-b'>";

              // Query to fetch applicants for the current job
              $jobId = $row["id"];
              $applicantsSql = "SELECT * FROM applications WHERE job_id = $jobId AND status != 'rejected'";
              $applicantsResult = $conn->query($applicantsSql);

              if ($applicantsResult->num_rows > 0) {
                echo "<a href='view_applicants.php?job_id=" . $row["id"] . "' class='text-blue-500 hover:underline'>View Applicants</a>";
              } else {
                echo "No applicants";
              }

              echo "</td>";

              echo "</tr>";
            }
          } else {
            echo "<tr><td colspan='8' class='py-2 px-4 text-center'>No jobs found</td></tr>";
          }

          $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>
