<?php 
include('db_connection.php');

// Handle event deletion
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            header("Location: index.php?success=delete");
            exit();
        } else {
            $error_message = "Error deleting event: " . $stmt->error;
        }
    } else {
        $error_message = "Error preparing statement: " . $conn->error;
    }
}

// Fetch events from the database, ordered by date
$sql = "SELECT * FROM events ORDER BY date DESC"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Planning System - Home</title>
    <link rel="stylesheet" href="../styles/index.css">
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="header-container">
            <h1>Event Planner</h1>
            <nav>
                <ul>
                    <li><a href="add_event.php">Add Event</a></li>
                    <li><a href="search_events.php">Search Events</a></li>
                    <li><a href="register.php">User Registration</a></li>
                    <li><a href="event_list.php">Event List</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Intro Section -->
    <section class="intro">
        <h2>Welcome to the Event Planning System</h2>
        <p>Manage your events, search for upcoming events, register as an organizer or attendee, and much more!</p>
    </section>

    <!-- Success/Error Messages -->
    <?php if (isset($_GET['success']) && $_GET['success'] == 'delete'): ?>
        <p class="success">Event successfully deleted!</p>
    <?php elseif (isset($error_message)): ?>
        <p class="error"><?php echo htmlspecialchars($error_message); ?></p>
    <?php endif; ?>

    <!-- Event Listings Section -->
    <section class="events-list">
        <h2>Upcoming Events</h2><br>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="event-card">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?></p>
                    <p><strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                    <p><strong>Event Type:</strong> <?php echo htmlspecialchars($row['type']); ?></p>
                    <!-- Delete Button -->
                    <form method="GET" action="index.php" onsubmit="return confirm('Are you sure you want to delete this event?');">
                        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="delete-btn">Delete</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No upcoming events found.</p>
        <?php endif; ?>

    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Event Planning System | All rights reserved.</p>
    </footer>

</body>
</html>



