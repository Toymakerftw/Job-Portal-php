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
  <div class="container mx-auto mt-8">
    <?php
    session_start(); // Start the session

    if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'applicant') {
      header("Location: login.php"); // Redirect to the login page if the user is not logged in or is not an applicant
      exit();
    }
    ?>

    <h2 class="text-2xl font-semibold mb-4">Applicant Details</h2>
    <form action="submit_applicant.php" method="post" enctype="multipart/form-data">
      <div class="mb-4">
        <label for="name" class="block text-gray-700">Name:</label>
        <input type="text" id="name" name="name" class="form-input mt-1 block w-full" required>
      </div>

      <div class="mb-4">
        <label for="address" class="block text-gray-700">Address:</label>
        <input type="text" id="address" name="address" class="form-input mt-1 block w-full" required>
      </div>

      <div class="mb-4">
        <label for="email" class="block text-gray-700">Email ID:</label>
        <input type="email" id="email" name="email" class="form-input mt-1 block w-full" required>
      </div>

      <div class="mb-4">
        <label for="phone" class="block text-gray-700">Phone:</label>
        <input type="text" id="phone" name="phone" class="form-input mt-1 block w-full" required>
      </div>

      <div class="mb-4">
        <label for="qualification" class="block text-gray-700">Education Qualification:</label>
        <input type="text" id="qualification" name="qualification" class="form-input mt-1 block w-full" required>
      </div>

      <div class="mb-4">
        <label for="certifications" class="block text-gray-700">Certifications:</label>
        <input type="text" id="certifications" name="certifications" class="form-input mt-1 block w-full">
      </div>

      <div class="mb-4">
        <label for="experience" class="block text-gray-700">Experience:</label>
        <input type="text" id="experience" name="experience" class="form-input mt-1 block w-full" required>
      </div>

      <div class="mb-4">
        <label for="salary" class="block text-gray-700">Expected Salary:</label>
        <input type="text" id="salary" name="salary" class="form-input mt-1 block w-full" required>
      </div>

      <div class="mb-4">
        <label for="resume" class="block text-gray-700">Upload Resume:</label>
        <input type="file" id="resume" name="resume" class="form-input mt-1 block w-full" required>
      </div>

      <div class="mb-4">
        <label for="picture" class="block text-gray-700">Upload Picture:</label>
        <input type="file" id="picture" name="picture" class="form-input mt-1 block w-full" required>
      </div>

      <div class="mb-4">
        <input type="submit" value="Submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
      </div>
    </form>
  </div>
</body>
</html>
