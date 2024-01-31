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
      <link rel="stylesheet" href="styles.css">
      <title>Update Job</title>
    </head>
    <body>
      <div class="container">
        <h2>Update Job</h2>
        <form id="updateJobForm" action="process_update_job.php" method="post">
          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
          <input type="text" name="title" value="<?php echo $row['title']; ?>" placeholder="Title" required>
          <input type="text" name="skill" value="<?php echo $row['skill']; ?>" placeholder="Skill" required>
          <input type="number" name="salary" value="<?php echo $row['salary']; ?>" placeholder="Salary" required>
          <input type="text" name="duration" value="<?php echo $row['duration']; ?>" placeholder="Duration" required>
          <input type="text" name="location" value="<?php echo $row['location']; ?>" placeholder="Location" required>
          <textarea name="details" placeholder="Details" required><?php echo $row['details']; ?></textarea>
          <button type="submit">Update Job</button>
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
