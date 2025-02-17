<?php
// Include database connection
include('db_connection.php');

// Initialize search query variable
$search_query = "";

// Check if the search parameter is set
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search_query = trim($_GET['search']); // Remove any extra spaces

    // Prepare SQL query to search by title, location, or type
    $sql = "SELECT * FROM events WHERE title LIKE ? OR location LIKE ? OR type LIKE ?";
    $stmt = $conn->prepare($sql);

    // Add wildcards for partial matching
    $search = "%" . $search_query . "%";
    $stmt->bind_param("sss", $search, $search, $search);
} else {
    // Default SQL query to display all events
    $sql = "SELECT * FROM events";
    $stmt = $conn->prepare($sql);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Events</title>
    <link rel="stylesheet" href="../styles/search_events.css">
    <script src="../scripts/search_events.js" defer></script>
</head>
<body>
<div class="container">
    <h1>Search Events</h1>

    <!-- Search Form -->
    <form id="searchForm" method="GET" action="search_events.php">
        <input 
            type="text" 
            name="search" 
            id="searchInput"
            value="<?php echo htmlspecialchars($search_query); ?>" 
            placeholder="Search events by title, location, or type"
        >
        <button type="submit">Search</button>
    </form>

    <div id="eventResults">
        <?php
        // Check if there are results and display them
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='event'>";
                echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<p><strong>Date:</strong> " . htmlspecialchars($row['date']) . "</p>";
                echo "<p><strong>Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
                echo "<p><strong>Type:</strong> " . htmlspecialchars($row['type']) . "</p>";
                echo "<p><strong>RSVPs:</strong> " . htmlspecialchars($row['rsvp']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<div class='no-events'>No events found matching your criteria.</div>";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>

    <!-- Back Button -->
    <section>
        <a href="index.php">
            <button type="button">Back</button>
        </a>
    </section>
</div>
</body>
</html>



