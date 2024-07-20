<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="queries.css">
    <title>Update Appointment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="dashboard">
        <!-- Vertical menu -->
        <nav class="menu">
            <div class="logo">
                <h2>DentalClinic</h2>
            </div>
            <ul class="menu-list">
                <li><a href="admin.php"><i class="fa fa-home"></i> Dashboard</a></li>
                <li><a href="appointment.php"><i class="fa-regular fa-calendar-check"></i> Appointments</a></li>
                <li><a href="patient.php"><i class="fa-solid fa-user-injured"></i> Patients</a></li>
                <li><a href="dentist.php"><i class="fa-solid fa-user-md"></i> Dentist</a></li>
                <li><a href="service.php"><i class="fa-solid fa-list-alt"></i> Services</a></li>
                <li><a href="service_by_dentist.php"><i class="fa-solid fa-tooth"></i> Services by Dentist</a></li>
                <li><a href="reports.php"><i class="fa fa-clipboard-list"></i> Reports</a></li>
                <li><a href="log.php"><i class="fa-solid fa-history"></i> Logs</a></li>
                <li><a href="#"><i class="fa-solid fa-cog"></i> Settings</a></li>
            </ul>
        </nav>

        <div class="main-content">
            <div class="form-container">
                <h1>Update Appointment</h1>

                <?php
                // Establish database connection
                $conn = new mysqli("localhost", "root", "", "dentalclinic");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve the AppointmentID from the URL query parameters
                $appointmentID = isset($_GET['AppointmentID']) ? $_GET['AppointmentID'] : null;

                if ($appointmentID !== null && is_numeric($appointmentID)) {
                    // Fetch appointment details based on the AppointmentID
                    $query = "SELECT * FROM appointment WHERE AppointmentID = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i", $appointmentID);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $appointment = $result->fetch_assoc();

                        // Display the form pre-filled with the appointment details
                        echo '<form action="" method="POST">';
                        echo '<input type="hidden" name="AppointmentID" value="' . htmlspecialchars($appointment['AppointmentID']) . '">';

                        // Appointment status selection
                        echo '<label for="AppointmentStatus">Appointment Status:</label>';
                        echo '<select id="AppointmentStatus" name="AppointmentStatus" required>';
                        echo '<option value="Upcoming" ' . ($appointment['AppointmentStatus'] == 'Upcoming' ? 'selected' : '') . '>Upcoming</option>';
                        echo '<option value="Completed" ' . ($appointment['AppointmentStatus'] == 'Completed' ? 'selected' : '') . '>Completed</option>';
                        echo '<option value="Missed" ' . ($appointment['AppointmentStatus'] == 'Missed' ? 'selected' : '') . '>Missed</option>';
                        echo '<option value="Cancelled" ' . ($appointment['AppointmentStatus'] == 'Cancelled' ? 'selected' : '') . '>Cancelled</option>';
                        echo '</select><br>';

                        // Dentist report input
                        echo '<label for="DentistReport">Dentist Report:</label>';
                        echo '<textarea id="DentistReport" name="DentistReport" required>' . htmlspecialchars($appointment['DentistReport']) . '</textarea><br>';

                        // Prescription input
                        echo '<label for="Prescription">Prescription:</label>';
                        echo '<textarea id="Prescription" name="Prescription" required>' . htmlspecialchars($appointment['Prescription']) . '</textarea><br>';

                        // Patient feedback input
                        echo '<label for="PatientFeedback">Patient Feedback:</label>';
                        echo '<textarea id="PatientFeedback" name="PatientFeedback" required>' . htmlspecialchars($appointment['PatientFeedback']) . '</textarea><br>';

                        echo '<button type="submit">Update Appointment</button>';
                        echo '</form>';
                    } else {
                        echo "<p>Appointment not found.</p>";
                    }

                    // Close the statement and result
                    $stmt->close();
                    $result->free();
                } else {
                    echo "<p>Invalid or missing Appointment ID.</p>";
                }

                // Close database connection
                $conn->close();
                ?>

            </div>
        </div>
    </div>
</body>
</html>
