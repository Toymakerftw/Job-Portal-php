<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css"> <!-- Include your custom styles if needed -->
  <title>View Applicant Details</title>
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

    if (isset($_GET['applicant_id']) && isset($_GET['job_id'])) {
      $applicantId = $_GET['applicant_id'];
      $jobId = $_GET['job_id']; // Add code to retrieve the job ID from the form

      // Connect to the database
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "portal";
      $conn = new mysqli($servername, $username, $password, $dbname);

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      // Query to fetch applicant details
      $applicantDetailsSql = "SELECT * FROM applicants WHERE id = $applicantId";
      $applicantDetailsResult = $conn->query($applicantDetailsSql);

      if ($applicantDetailsResult->num_rows > 0) {
        $applicant = $applicantDetailsResult->fetch_assoc();
        // Display applicant details
        echo "<h2 class='text-2xl font-semibold mb-4'>Applicant Details</h2>";
        echo "<p><strong>Name:</strong> " . $applicant['name'] . "</p>";
        echo "<p><strong>Address:</strong> " . $applicant['address'] . "</p>";
        echo "<p><strong>Email:</strong> " . $applicant['email'] . "</p>";
        echo "<p><strong>Phone:</strong> " . $applicant['phone'] . "</p>";
        echo "<p><strong>Education Qualification:</strong> " . $applicant['qualification'] . "</p>";
        echo "<p><strong>Certifications:</strong> " . $applicant['certifications'] . "</p>";
        echo "<p><strong>Experience:</strong> " . $applicant['experience'] . "</p>";
        echo "<p><strong>Expected Salary:</strong> " . $applicant['salary'] . "</p>";
        // You can add more details as per your database schema
        echo "<a href='" . $applicant['resume_path'] . "' download class='text-blue-500 hover:underline'>Download Resume</a>";

        // Add a button to reject the applicant
        echo "<form action='reject_applicant.php' method='post' class='mb-2'>";
        echo "<input type='hidden' name='applicant_id' value='" . $applicant['id'] . "'>";
        echo "<input type='hidden' name='job_id' value='" . $jobId . "'>"; // Add hidden input for job ID
        echo "<button type='submit' class='bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline'>Reject Applicant</button>";
        echo "</form>";

        // Add a button to shortlist the applicant
        echo "<form action='shortlist_applicant.php' method='post'>";
        echo "<input type='hidden' name='applicant_id' value='" . $applicant['id'] . "'>";
        echo "<input type='hidden' name='job_id' value='" . $jobId . "'>"; // Add hidden input for job ID
        echo "<button type='submit' class='bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline'>Shortlist Applicant</button>";
        echo "</form>";
      } else {
        echo "<p>Applicant details not found</p>";
      }

      $conn->close();
    } else {
      echo "<p>Applicant ID not provided</p>";
    }
    ?>
  </div>
</body>
</html>
