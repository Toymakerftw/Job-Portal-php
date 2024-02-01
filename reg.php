<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    /* Add your styles here */
  </style>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto h-screen flex justify-center items-center">
    <div class="bg-white p-8 rounded shadow-md w-full md:w-96">
      <h2 class="text-2xl font-semibold mb-6">Sign Up</h2>
      <form id="registrationForm" action="reg.php" method="post">
        <input type="text" id="username" name="username" placeholder="Username" required
               class="w-full px-4 py-2 border rounded mt-1 focus:outline-none focus:border-black">

        <input type="password" id="password" name="password" placeholder="Password" required
               class="w-full px-4 py-2 border rounded mt-1 focus:outline-none focus:border-black">

        <div class="flex mt-2">
          <input type="radio" id="applicant" name="role" value="applicant" checked
                 class="mr-2">
          <label for="applicant" class="text-sm text-gray-600">Applicant</label>
          <input type="radio" id="employer" name="role" value="employer"
                 class="ml-4 mr-2">
          <label for="employer" class="text-sm text-gray-600">Employer</label>
        </div>

        <button type="submit" class="w-full bg-black text-white p-2 rounded mt-4 hover:bg-gray-800">Register</button>
      </form>

      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        $username = $_POST['username'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";

        if ($conn->query($sql) === TRUE) {
          echo "New record created successfully";
        } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
      }
      ?>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>
