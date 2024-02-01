<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Include your custom styles if needed -->
    <title>Applicant Details</title>
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
    <div class="container mx-auto mt-8 flex justify-center">
        <form action="applicant_details.php" method="post" enctype="multipart/form-data" class="bg-white p-8 rounded shadow-md w-full md:w-96">
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
                <input type="file" id="resume" name="resume" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Upload Resume" required>
            </div>

            <div class="mb-4 filelabel">
                <label for="picture" class="block text-gray-700">Upload Picture</label>
                <input type="file" id="picture" name="picture" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Upload Picture" required>
            </div>

            <div class="mb-4">
                <input type="submit" value="Submit" class="w-full bg-black text-white p-2 rounded hover:bg-gray-800">
            </div>
        </form>
    </div>
</body>

</html>
