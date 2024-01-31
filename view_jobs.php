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
  <link rel="stylesheet" href="styles.css">
  <title>View Jobs and Applicants</title>
</head>
<body>
  <div class="container">
    <h2>Jobs List</h2>
    <table>
      <tr>
        <th>Title</th>
        <th>Skill</th>
        <th>Salary</th>
        <th>Duration</th>
        <th>Location</th>
        <th>Details</th>
        <th>Actions</th>
        <th>Applicants</th>
      </tr>
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
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["skill"] . "</td>";
            echo "<td>" . $row["salary"] . "</td>";
            echo "<td>" . $row["duration"] . "</td>";
            echo "<td>" . $row["location"] . "</td>";
            echo "<td>" . $row["details"] . "</td>";
            echo "<td><a href='delete_job.php?id=" . $row["id"] . "'>Delete</a> | <a href='update_job.php?id=" . $row["id"] . "'>Update</a></td>";
            echo "<td>";

            // Query to fetch applicants for the current job
            $jobId = $row["id"];
            //$applicantsSql = "SELECT * FROM applications WHERE job_id = $jobId";
            $applicantsSql = "SELECT * FROM applications WHERE job_id = $jobId AND status != 'rejected'";
            $applicantsResult = $conn->query($applicantsSql);

            if ($applicantsResult->num_rows > 0) {
              while ($applicant = $applicantsResult->fetch_assoc()) {
                // Fetch applicant's name from the users table based on their ID
                $applicantId = $applicant["applicant_id"];
                $applicantNameSql = "SELECT username FROM users WHERE id = $applicantId";
                $applicantNameResult = $conn->query($applicantNameSql);
                $applicantName = $applicantNameResult->fetch_assoc()["username"];

                // Display applicant's name
                //echo $applicantName . ", ";
                echo "<td><a href='view_applicants.php?job_id=" . $row["id"] . "'>View Applicants</a></td>";
              }
            } else {
              echo "No applicants";
            }

            echo "</td>";

            echo "</tr>";
          }
        } else {
          echo "0 results";
        }

        $conn->close();
      ?>
    </table>
  </div>
</body>
</html>
