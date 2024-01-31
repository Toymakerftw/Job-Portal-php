<?php
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

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  $sql = "SELECT * FROM jobs WHERE id=$id";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Display a form pre-filled with the existing job information for updating
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
      <link rel="stylesheet" href="styles.css">
      <title>Update Job</title>
    </head>
    <body class="bg-gray-100">
      <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-semibold mb-4">Update Job</h2>
        <form id="updateJobForm" action="process_update_job.php" method="post" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
          <div class="mb-4">
            <input type="text" name="title" value="<?php echo $row['title']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Title" required>
          </div>
          <div class="mb-4">
            <input type="text" name="skill" value="<?php echo $row['skill']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Skill" required>
          </div>
          <div class="mb-4">
            <input type="number" name="salary" value="<?php echo $row['salary']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Salary" required>
          </div>
          <div class="mb-4">
            <input type="text" name="duration" value="<?php echo $row['duration']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Duration" required>
          </div>
          <div class="mb-4">
            <input type="text" name="location" value="<?php echo $row['location']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Location" required>
          </div>
          <div class="mb-6">
            <textarea name="details" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Details" required><?php echo $row['details']; ?></textarea>
          </div>
          <div class="flex items-center justify-between">
            <button type="submit" class="w-full bg-black text-white p-2 rounded hover:bg-gray-800" type="button">
              Update Job
            </button>
          </div>
        </form>
      </div>
    </body>
    </html>
    <?php
  } else {
    echo "Job not found";
  }
} else {
  echo "Invalid job ID";
}

$conn->close();
?>
