<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Include your custom styles if needed -->
    <title>Applicant Details</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>

<body class="bg-gray-100">

<?php
session_start(); // Start the session

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

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM applicants WHERE email = '$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        // Applicant already exists, perform update
        $updateQuery = "UPDATE applicants SET 
                        name = '$name',
                        address = '$address',
                        phone = '$phone',
                        qualification = '$qualification',
                        certifications = '$certifications',
                        experience = '$experience',
                        salary = '$salary',
                        resume_path = '$resumeTargetDir$resumeNewName',
                        picture_path = '$pictureTargetDir$pictureNewName'
                        WHERE email = '$email'";

        if ($conn->query($updateQuery) === TRUE) {
            echo json_encode(['message' => 'Applicant details updated successfully']);
        } else {
            echo json_encode(['error' => 'Error updating record: ' . $conn->error]);
        }
    } else {
        // Applicant does not exist, perform insert
        $insertQuery = "INSERT INTO applicants (name, address, email, phone, qualification, certifications, experience, salary, resume_path, picture_path) VALUES ('$name', '$address', '$email', '$phone', '$qualification', '$certifications', '$experience', '$salary', '$resumeTargetDir$resumeNewName', '$pictureTargetDir$pictureNewName')";

        if ($conn->query($insertQuery) === TRUE) {
            echo json_encode(['message' => 'Applicant details submitted successfully']);
        } else {
            echo json_encode(['error' => 'Error inserting record: ' . $conn->error]);
        }
    }

    $conn->close();
} else {
    //echo "Invalid request";
}
?>

    <div class="container mx-auto mt-8 flex justify-center">
    <form id="updateApplicantdetailsForm" action="applicant_details.php" method="post" enctype="multipart/form-data" class="bg-white p-8 rounded shadow-md w-full md:w-96">
            <h2 class="text-2xl font-semibold mb-4">Applicant Details</h2>
            <div class="mb-4">
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Username" required>
            </div>

            <div class="mb-4">
                <input type="text" id="address" name="address" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Address" required>
            </div>

            <div class="mb-4">
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Email ID" required>
            </div>

            <div class="mb-4">
                <input type="text" id="phone" name="phone" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Phone" required>
            </div>

            <div class="mb-4">
                <input type="text" id="qualification" name="qualification" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Education Qualification" required>
            </div>

            <div class="mb-4">
                <input type="text" id="certifications" name="certifications" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Certifications">
            </div>

            <div class="mb-4">
                <input type="text" id="experience" name="experience" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Experience" required>
            </div>

            <div class="mb-4">
                <input type="text" id="salary" name="salary" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Expected Salary" required>
            </div>

            <div class="mb-4 filelabel">
                <label for="resume" class="block text-gray-700">Upload Resume</label>
                <input type="file" id="resume" name="resume" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Upload Resume" required onchange="validateFileUpload('resume')">
            </div>

            <div class="mb-4 filelabel">
                <label for="picture" class="block text-gray-700">Upload Picture</label>
                <input type="file" id="picture" name="picture" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Upload Picture" required onchange="validateFileUpload('picture')">
            </div>

            <div class="mb-4">
                <input type="submit" value="Submit" class="w-full bg-black text-white p-2 rounded hover:bg-gray-800">
            </div>
        </form>
    </div>
    <script>
        function validateFileUpload(inputId) {
    var fileInput = document.getElementById(inputId);
    var filePath = fileInput.value;
    var allowedExtensions = /(\.pdf|\.docx|\.jpg|\.jpeg|\.png)$/i;

    if (!allowedExtensions.exec(filePath)) {
        // Display an alert or customize the error handling as needed
        alert('Invalid file type. Allowed file types: PDF, DOCX, JPG, JPEG, PNG.');
        fileInput.value = ''; // Clear the file input
        return false;
    }
    return true;
}

$(document).ready(function() {
    $('#updateApplicantdetailsForm').submit(function(e) {
        e.preventDefault();

        // Validate file uploads before submitting the form
        var isResumeValid = validateFileUpload('resume');
        var isPictureValid = validateFileUpload('picture');

        if (isResumeValid && isPictureValid) {
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: 'applicant_details.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Display a toast message for success
                    Toastify({
                        text: "Success! Details Updated",
                        duration: 3000,
                        gravity: "bottom",
                        position: 'right',
                        backgroundColor: "green"
                    }).showToast();
                },
                error: function() {
                    alert('An error occurred while updating the job.');
                }
            });
        }
    });
});

    </script>

</body>

</html>
