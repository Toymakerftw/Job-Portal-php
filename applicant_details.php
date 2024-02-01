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

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'applicant') {
        header("Location: login.php"); // Redirect to the login page if the user is not logged in or is not an applicant
        exit();
    }
    ?>

    <div class="container mx-auto mt-8 flex justify-center">
        <form action="submit_applicant.php" method="post" enctype="multipart/form-data" class="bg-white p-8 rounded shadow-md w-full md:w-96">
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

            <div class="mb-4">
                <input type="file" id="resume" name="resume" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Upload Resume" required>
            </div>

            <div class="mb-4">
                <input type="file" id="picture" name="picture" class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black" placeholder="Upload Picture" required>
            </div>

            <div class="mb-4">
                <input type="submit" value="Submit" class="w-full bg-black text-white p-2 rounded hover:bg-gray-800">
            </div>
        </form>
    </div>
</body>

</html>
