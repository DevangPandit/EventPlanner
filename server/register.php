<?php
// Process the form submission if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('db_connection.php'); // Include your database connection file

    // Retrieve form data and sanitize
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = htmlspecialchars($_POST['role']);

    // Prepare SQL statement
    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    // Execute the statement and handle success or failure
    if ($stmt->execute()) {
        // Show success message and redirect
        echo "<script>alert('Registration successful!'); window.location.href='index.php';</script>";
        exit;
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../styles/register.css">
    <script src="../scripts/register.js" defer></script>
</head>
<body>

<h1>User Registration</h1>

<?php
// Show error message if any
if (isset($error)) {
    echo "<p style='color: red;'>$error</p>";
}
?>

<form method="POST" action="" id="registrationForm">
    <input type="text" id="name" name="name" placeholder="Full Name" required><br>
    <input type="email" id="email" name="email" placeholder="Email" required><br>
    <input type="password" id="password" name="password" placeholder="Password" required><br>
    <select id="role" name="role" required>
        <option value="organizer">Organizer</option>
        <option value="attendee">Attendee</option>
    </select><br>
    <button type="submit">Register</button>
</form>

</body>
</html>



