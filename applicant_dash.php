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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
  $(document).ready(function(){
    $('#searchForm').submit(function(e){
      e.preventDefault(); // Prevent form submission
      var searchQuery = $('#searchInput').val(); // Get the search query
      $.ajax({
        type: 'GET',
        url: 'search_jobs.php', // PHP file to handle the search logic
        data: { search: searchQuery },
        success: function(response){
          var jobs = JSON.parse(response); // Parse the JSON response
          var resultsHtml = '<div class="grid grid-cols-3 gap-4">';
          jobs.forEach(function(job){
            resultsHtml += '<div class="bg-white rounded-lg shadow-md p-4">';
            resultsHtml += '<h3 class="text-lg font-semibold mb-2">' + job.title + '</h3>';
            resultsHtml += '<p class="text-gray-600">Skills:' + job.skill + '</p>';
            resultsHtml += '<p class="text-gray-600">Details:' + job.details + '</p>';
            resultsHtml += '<p class="text-gray-600">Location: ' + job.location + '</p>';
            resultsHtml += '<p class="text-gray-600">Salary: ' + job.salary + '</p>';
            // Add the apply button with a link to the job application page
            resultsHtml += '<button class="w-full bg-black text-white p-2 rounded hover:bg-gray-800 mt-4" onclick="applyForJob(' + job.id + ')">Apply</button>';
            resultsHtml += '</div>';
          });
          resultsHtml += '</div>';
          $('#searchResults').html(resultsHtml); // Display the search results as cards
        }
      });
    });
  });

      // Function to handle job application
      function applyForJob(jobId) {
      // Send an AJAX request to apply_job.php
      $.ajax({
        type: 'POST',
        url: 'apply_job.php',
        data: { job_id: jobId },
        success: function(response) {
          // Display a message or take further action based on the response
          alert(response); // You can replace this with a more user-friendly notification
        }
      });
    }

</script>
<style>
  .container {
    padding-bottom: 20px; /* Adjust the padding-bottom value as needed */
  }

  #searchResults {
    margin-top: 20px; /* Adjust the margin-top value as needed */
  }

  ul {
    margin-top: 20px; /* Adjust the margin-top value as needed */
  }

  li {
    margin-bottom: 10px; /* Adjust the margin-bottom value as needed */
  }
</style>
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
    <form id="searchForm" class="mb-4">
      <div class="flex items-center">
        <input type="text" id="searchInput" placeholder="Search by Job Title" class="rounded-l-full w-full py-2 px-4 mr-0 border-t border-b border-l text-gray-800 border-gray-200 bg-white">
        <button type="submit" class="bg-black hover:bg-gray-800 text-white font-bold py-2 px-4 rounded-r-full focus:outline-none focus:shadow-outline">Search</button>
      </div>
    </form>

    <div id="searchResults"></div>

    <ul>
      <li class="mb-2"><a href="applicant_view_jobs.php" class="w-full bg-black text-white p-2 rounded hover:bg-gray-800">View Jobs</a></li>
      <li class="mb-2"><a href="applicant_details.php" class="w-full bg-black text-white p-2 rounded hover:bg-gray-800">Add/Edit Details</a></li>
      <li><a href="job_status.php" class="w-full bg-black text-white p-2 rounded hover:bg-gray-800">View Jobs Status</a></li>
    </ul>
  </div>

</body>
</html>
