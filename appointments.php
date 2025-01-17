<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'doctor_connect');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert Appointment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'insert') {
    $patient_name = $_POST['patient_name'];
    $doctor_name = $_POST['doctor_name'];
    $appointment_time = $_POST['appointment_time'];
    $email = $_POST['email'];

    $sql = "INSERT INTO appointments (patient_name, doctor_name, appointment_time, email) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssss', $patient_name, $doctor_name, $appointment_time, $email);
    $stmt->execute();

    header('Location: appointmentss.php');
    exit;
}

// Update Appointment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = $_POST['id'];
    $patient_name = $_POST['patient_name'];
    $doctor_name = $_POST['doctor_name'];
    $appointment_time = $_POST['appointment_time'];
    $email = $_POST['email'];

    $sql = "UPDATE appointments SET patient_name = ?, doctor_name = ?, appointment_time = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssi', $patient_name, $doctor_name, $appointment_time, $email, $id);
    $stmt->execute();

    header('Location: appointmentss.php');
    exit;
}

// Delete Appointment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];

    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();

    header('Location: appointmentss.php');
    exit;
}

// Fetch Appointments
$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);
$appointments = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}
?>
