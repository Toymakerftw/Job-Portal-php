<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $address = $_POST["address"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $qualification = $_POST["qualification"];
  $certifications = $_POST["certifications"];
  $experience = $_POST["experience"];
  $salary = $_POST["salary"];

  $resumeName = $_FILES["resume"]["name"];
  $resumeTmpName = $_FILES["resume"]["tmp_name"];
  $resumeTargetDir = "resumes/";
  $resumeTargetFile = $resumeTargetDir . basename($resumeName);

  $pictureName = $_FILES["picture"]["name"];
  $pictureTmpName = $_FILES["picture"]["tmp_name"];
  $pictureTargetDir = "pictures/";
  $pictureTargetFile = $pictureTargetDir . basename($pictureName);

  // Generate unique names for resume and picture files
  $applicantId = uniqid();
  $currentDate = date("YmdHis");
  $resumeNewName = $applicantId . "-" . $currentDate . "-resume." . pathinfo($resumeName, PATHINFO_EXTENSION);
  $pictureNewName = $applicantId . "-" . $currentDate . "-picture." . pathinfo($pictureName, PATHINFO_EXTENSION);

  // Move uploaded files to the target directory with the new names
  move_uploaded_file($resumeTmpName, $resumeTargetDir . $resumeNewName);
  move_uploaded_file($pictureTmpName, $pictureTargetDir . $pictureNewName);

  // Store the applicant details and file paths in the database
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

  $sql = "INSERT INTO applicants (name, address, email, phone, qualification, certifications, experience, salary, resume_path, picture_path) VALUES ('$name', '$address', '$email', '$phone', '$qualification', '$certifications', '$experience', '$salary', '$resumeTargetDir$resumeNewName', '$pictureTargetDir$pictureNewName')";

  if ($conn->query($sql) === TRUE) {
    echo "Applicant details submitted successfully";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
} else {
  echo "Invalid request";
}
?>
