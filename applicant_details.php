<?php
session_start(); // Start the session

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'applicant') {
  header("Location: login.php"); // Redirect to the login page if the user is not logged in or is not an applicant
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Applicant Details</title>
</head>
<body>
  <h2>Applicant Details</h2>
  <form action="submit_applicant.php" method="post" enctype="multipart/form-data">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required><br><br>

    <label for="email">Email ID:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="phone">Phone:</label>
    <input type="text" id="phone" name="phone" required><br><br>

    <label for="qualification">Education Qualification:</label>
    <input type="text" id="qualification" name="qualification" required><br><br>

    <label for="certifications">Certifications:</label>
    <input type="text" id="certifications" name="certifications"><br><br>

    <label for="experience">Experience:</label>
    <input type="text" id="experience" name="experience" required><br><br>

    <label for="salary">Expected Salary:</label>
    <input type="text" id="salary" name="salary" required><br><br>

    <label for="resume">Upload Resume:</label>
    <input type="file" id="resume" name="resume" required><br><br>

    <label for="picture">Upload Picture:</label>
    <input type="file" id="picture" name="picture" required><br><br>

    <input type="submit" value="Submit">
  </form>
</body>
</html>
