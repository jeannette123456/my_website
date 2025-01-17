<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password
$dbname = "doctor_connect"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert data into the database
    $sql = "INSERT INTO contact_form (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Thank you for contacting us! Your message has been received.'); window.location.href='contact.html';</script>";
    } else {
        echo "<script>alert('Error: Unable to save your message. Please try again later.'); window.location.href='contact.html';</script>";
    }
}

// Close connection
$conn->close();
?>
