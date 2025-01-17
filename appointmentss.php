<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "doctor_connect");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize $appointments
$appointments = [];

// Query to fetch appointments
$sql = "SELECT id, patient_name, doctor_name, appointment_time, email FROM appointments";
$result = $conn->query($sql);

// Populate $appointments array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Your CSS styles here */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9;
        }
        header {
            background-color: #0056b3;
            color: #fff;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            font-style: italic;
        }

        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin-left: 15px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #ffcc00;
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .add-form {
            margin-top: 20px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .add-form h3 {
            color: #0056b3;
        }
        .add-form form label {
            display: block;
            margin-top: 10px;
        }
        .add-form form input,
        .add-form form select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .add-form form button {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        .add-form form button:hover {
            background: #0056b3;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .card h3 {
            margin-bottom: 10px;
            color: #0056b3;
        }
        .card p {
            margin: 5px 0;
        }
        .card form {
            margin-top: 10px;
        }
        .card form button {
            margin-right: 10px;
            padding: 8px 12px;
            border: none;
            background: #007bff;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .card form button:hover {
            background: #0056b3;
        }
        footer {
            background: #0056b3;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            margin-top: 40px;
        }
        footer .social-icons a {
            margin: 0 10px;
            color: #fff;
            text-decoration: none;
            font-size: 18px;
        }
        footer .social-icons a:hover {
            color: #f4f4f9;
        }
    </style>
</head>
<body>


    <header>
        <div class="header-container">
            <div class="logo">DoctorConnect</div>
            <nav>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="doctors.html">Doctors</a></li>
                    <li><a href="appointmentss.php">Appointments</a></li>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </nav>
        </div>
    </header>

<div class="container">
    <h2>Manage Appointments</h2>

    <!-- Add Appointment Form -->
    <div class="add-form">
        <h3>Add Appointment</h3>
        <form action="appointments.php" method="POST">
            <input type="hidden" name="action" value="insert">
            <label for="patient_name">Patient Name:</label>
            <input type="text" id="patient_name" name="patient_name" required>

            <label for="doctor_name">Doctor Name:</label>
            <select id="doctor_name" name="doctor_name" required>
                <option value="Dr. Smith">Dr. Smith</option>
                <option value="Dr. Johnson">Dr. Johnson</option>
                <option value="Dr. Lee">Dr. Lee</option>
            </select>

            <label for="appointment_time">Appointment Time:</label>
            <input type="datetime-local" id="appointment_time" name="appointment_time" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <button type="submit">Add Appointment</button>
        </form>
    </div>

    <!-- Appointment Cards -->
    <?php foreach ($appointments as $appointment): ?>
        <div class="card">
            <h3><?= htmlspecialchars($appointment['patient_name']) ?></h3>
            <p><strong>Doctor:</strong> <?= htmlspecialchars($appointment['doctor_name']) ?></p>
            <p><strong>Time:</strong> <?= htmlspecialchars($appointment['appointment_time']) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($appointment['email']) ?></p>

            <!-- Update Form -->
            <form action="appointments.php" method="POST">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="id" value="<?= $appointment['id'] ?>">
    
    <label for="patient_name_<?= $appointment['id'] ?>">Patient Name:</label>
    <input type="text" id="patient_name_<?= $appointment['id'] ?>" name="patient_name" value="<?= htmlspecialchars($appointment['patient_name']) ?>" required>

    <label for="doctor_name_<?= $appointment['id'] ?>">Doctor Name:</label>
    <select id="doctor_name" name="doctor_name" required>
                <option value="Dr. Smith">Dr. Smith</option>
                <option value="Dr. Johnson">Dr. Johnson</option>
                <option value="Dr. Lee">Dr. Lee</option>
            </select>

    <label for="appointment_time_<?= $appointment['id'] ?>">Appointment Time:</label>
    <input type="datetime-local" id="appointment_time_<?= $appointment['id'] ?>" name="appointment_time" value="<?= htmlspecialchars($appointment['appointment_time']) ?>" required>

    <label for="email_<?= $appointment['id'] ?>">Email:</label>
    <input type="email" id="email_<?= $appointment['id'] ?>" name="email" value="<?= htmlspecialchars($appointment['email']) ?>" required>

    <button type="submit">Save Changes</button>
</form>


            <!-- Delete Form -->
            <form action="appointments.php" method="POST" style="display: inline;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $appointment['id'] ?>">
                <button type="submit">Delete</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
<footer>
    <p>&copy; 2025 DoctorConnect. All Rights Reserved.</p>
    <div class="social-icons">
        <a href="#">Facebook</a> | 
        <a href="#">Twitter</a> | 
        <a href="#">Instagram</a>
    </div>
</footer>
</body>
</html>
