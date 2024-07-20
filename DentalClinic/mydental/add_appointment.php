<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="queries.css" />
    <title>Schedule New Appointment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
</head>

<body>
    <div class="dashboard">
        <!-- Vertical menu -->
        <nav class="menu">
            <div class="logo">
                <h2>DentalClinic</h2>
            </div>
            <ul class="menu-list">
                <li>
                    <a href="index.php"><i class="fa-solid fa-home"></i> Home</a>
                </li>
                <li>
                    <a href="admin.php"><i class="fa-regular fa-gauge"></i> Dashboard</a>
                </li>
                <li>
                    <a href="appointment.php">
                        <i class="fa-regular fa-calendar-check"></i> Appointments
                    </a>
                </li>
                <li>
                    <a href="patient.php"><i class="fa-solid fa-user-injured"></i> Patients</a>
                </li>
                <li>
                    <a href="dentist.php"><i class="fa-solid fa-user-md"></i> Dentist</a>
                </li>
                <li>
                    <a href="service.php"><i class="fa-solid fa-list-alt"></i> Services</a>
                </li>
                <li>
                    <a href="service_by_dentist.php"><i class="fa-solid fa-tooth"></i> Services by Dentist</a>
                </li>
                <li>
                    <a href="reports.php"><i class="fa fa-clipboard-list"></i> Reports</a>
                </li>
                <li>
                    <a href="log.php"><i class="fa-solid fa-history"></i> Logs</a>
                </li>
            </ul>
        </nav>

        <div class="main-content">
            <div class="form-container">
                <h1>Schedule New Appointment</h1>
                <form action="add_appointment.php" method="POST">
                    <!-- Patient Selection -->
                    <label for="PatientID">Patient:</label>
                    <select id="PatientID" name="PatientID" required>
                        <?php
                        // Database connection
                        $conn = new mysqli("localhost", "root", "", "dentalclinic");
                        
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        
                        // Query to fetch patient IDs and names
                        $patientQuery = "SELECT PatientID, CONCAT(FirstName, ' ', LastName) AS PatientName FROM patient";
                        $patientResult = $conn->query($patientQuery);
                        
                        while ($row = $patientResult->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row['PatientID']) . '">' . htmlspecialchars($row['PatientName']) . '</option>';
                        }
                        ?>
                    </select>

                    <!-- Dentist Selection -->
                    <label for="DentistID">Dentist:</label>
                    <select id="DentistID" name="DentistID" required>
                        <?php
                        // Query to fetch dentist IDs and names
                        $dentistQuery = "SELECT DentistID, CONCAT(FirstName, ' ', LastName) AS DentistName FROM dentist";
                        $dentistResult = $conn->query($dentistQuery);
                        
                        while ($row = $dentistResult->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row['DentistID']) . '">' . htmlspecialchars($row['DentistName']) . '</option>';
                        }
                        ?>
                    </select>

                    <!-- Service Selection -->
                    <label for="ServiceCode">Service:</label>
                    <select id="ServiceCode" name="ServiceCode" required>
                        <?php
                        // Query to fetch service codes and names
                        $serviceQuery = "SELECT ServiceCode, ServiceName FROM service";
                        $serviceResult = $conn->query($serviceQuery);
                        
                        while ($row = $serviceResult->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row['ServiceCode']) . '">' . htmlspecialchars($row['ServiceName']) . '</option>';
                        }
                        ?>
                    </select>

                    <!-- Appointment Date -->
                    <label for="AppointmentDate">Appointment Date:</label>
                    <input type="date" id="AppointmentDate" name="AppointmentDate" required />

                    <!-- Appointment Time -->
                    <label for="AppointmentTime">Appointment Time:</label>
                    <input type="time" id="AppointmentTime" name="AppointmentTime" required />

                    <!-- Appointment Status -->
                    <label for="AppointmentStatus">Appointment Status:</label>
                    <select id="AppointmentStatus" name="AppointmentStatus" required>
                        <option value="Upcoming">Upcoming</option>
                        <option value="Completed">Completed</option>
                        <option value="Missed">Missed</option>
                        <option value="Cancelled">Cancelled</option>
                    </select>

                    <button type="submit">Schedule Appointment</button>
                </form>
                <div class="success-message" id="successMessage" style="display: none;">
                    Appointment scheduled successfully!
                </div>
            </div>
        </div>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Retrieve form data
            $PatientID = $_POST['PatientID'];
            $DentistID = $_POST['DentistID'];
            $ServiceCode = $_POST['ServiceCode'];
            $AppointmentDate = $_POST['AppointmentDate'];
            $AppointmentTime = $_POST['AppointmentTime'];
            $AppointmentStatus = $_POST['AppointmentStatus'];

            // Database connection
            $conn = new mysqli("localhost", "root", "", "dentalclinic");
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Insert data into the appointment table
            $sql = "INSERT INTO appointment (PatientID, DentistID, ServiceCode, AppointmentDate, AppointmentTime, AppointmentStatus) VALUES (?, ?, ?, ?, ?, ?)";
            
            if ($statement = $conn->prepare($sql)) {
                $statement->bind_param("iissss", $PatientID, $DentistID, $ServiceCode, $AppointmentDate, $AppointmentTime, $AppointmentStatus);
                
                if ($statement->execute()) {
                    echo "<script>document.getElementById('successMessage').style.display = 'block';</script>";
                } else {
                    echo "<p>Error scheduling appointment: " . $statement->error . "</p>";
                }

                $statement->close();
            } else {
                echo "<p>Database error: " . $conn->error . "</p>";
            }

            // Close the database connection
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
