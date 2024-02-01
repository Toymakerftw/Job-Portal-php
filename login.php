<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <title>Login Page</title>
</head>
<body class="bg-gray-100">
  <div class="container mx-auto h-screen flex justify-center items-center">
    <div class="bg-white p-8 rounded shadow-md w-full md:w-96">
      <h2 class="text-2xl font-semibold mb-6">Login</h2>
      <form id="loginForm" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="mb-4">
          <input type="text" id="username" name="username" placeholder="Username" required
                 class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black">
        </div>
        <div class="mb-4">
          <input type="password" id="password" name="password" placeholder="Password" required
                 class="w-full px-4 py-2 border rounded focus:outline-none focus:border-black">
        </div>
        <button type="submit" class="w-full bg-black text-white p-2 rounded hover:bg-gray-800">Login</button>
      </form>

      <?php
      session_start(); // Start the session

      $servername = "localhost";
      $db_username = "root";
      $db_password = "";
      $dbname = "portal";

      // Create connection
      $conn = new mysqli($servername, $db_username, $db_password, $dbname);

      // Check connection
      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
          $row = $result->fetch_assoc();
          $_SESSION['user_id'] = $row['id']; // Store user id in session
          $_SESSION['role'] = $row['role']; // Store user role in session

          if ($row['role'] == 'applicant') {
            header("Location: applicant_dash.php");
          } elseif ($row['role'] == 'employer') {
            header("Location: employer_dash.php");
          }
        } else {
          echo "Invalid username or password";
        }
      }

      $conn->close();
      ?>
    </div>
  </div>
  <script src="script.js"></script>
</body>
</html>
