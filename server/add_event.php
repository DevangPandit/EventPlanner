<?php
include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $type = $_POST['type'];

    // Validate the inputs (optional)
    if (empty($title) || empty($description) || empty($date) || empty($location) || empty($type)) {
        echo "All fields are required.";
    } else {
        // Prepare and bind the SQL query
        $stmt = $conn->prepare("INSERT INTO events (title, description, date, location, type) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $description, $date, $location, $type);

        // Execute the query
        if ($stmt->execute()) {
            echo "Event added successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management</title>
    <link rel="stylesheet" href="../styles/add_event.css">
</head>
<body>

<h1>Add Event</h1>
<form method="POST" action="add_event.php">
    <input type="text" name="title" placeholder="Event Title" required><br>
    <textarea name="description" placeholder="Event Description" required></textarea><br>
    <input type="date" name="date" required><br>
    <input type="text" name="location" placeholder="Event Location" required><br>
    <input type="text" name="type" placeholder="Event Type" required><br>
    <button type="submit" name="add_event">Add Event</button>
</form>

<a href=" index.php">
    <button type="button">Back</button>
</a>

</body>
</html>


