<?php
include('db_connection.php');

// Handle RSVP increment
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $event_id = intval($_GET['id']); // Ensure it's an integer

    // Increment the RSVP count for the event
    $sql = "UPDATE events SET rsvp = rsvp + 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $event_id);
        if ($stmt->execute()) {
            // Redirect with success message
            header("Location: event_list.php?success=rsvp");
            exit();
        } else {
            $error_message = "Error updating RSVP: " . $stmt->error;
        }
    } else {
        $error_message = "Error preparing statement: " . $conn->error;
    }
}

// Fetch events
$sql = "SELECT * FROM events";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Planner</title>
    <link rel="stylesheet" href="../styles/event_list.css">
</head>
<body>

<!-- Display success or error messages -->
<div id="message">
    <?php if (isset($_GET['success']) && $_GET['success'] == 'rsvp'): ?>
        <p class="success">RSVP Successful!</p>
    <?php elseif (isset($error_message)): ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>
</div>

<h1>Event List</h1>

<div class="event-list">
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="event">
                <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <p><strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                <p><strong>RSVPs:</strong> <?php echo htmlspecialchars($row['rsvp']); ?></p>
                <a href="event_list.php?id=<?php echo $row['id']; ?>" class="rsvp-link">RSVP</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No events found.</p>
    <?php endif; ?>
</div>

<a href="index.php">
    <button type="button">Back</button>
</a>

</body>
</html>

