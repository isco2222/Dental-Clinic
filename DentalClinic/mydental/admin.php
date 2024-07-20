<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dental Clinic Dashboard</title>
    <!-- Link to Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Link to CSS -->
    <link rel="stylesheet" href="styles.css" />
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
                    <a href="appointment.php"><i class="fa-regular fa-calendar-check"></i> Appointments</a>
                </li>
                <li>
                    <a href="patient.php"><i class="fa-solid fa-user-injured"></i> Patients</a>
                </li>
                <li>
                    <a href="dentist.php"><i class="fa-solid fa-user-md"></i> Dentists</a>
                </li>
                <li>
                    <a href="service.php"><i class="fa-solid fa-list-alt"></i> Services</a>
                </li>
                <li>
                    <a href="service_by_dentist.php"><i class="fa-solid fa-tooth"></i> Services by Dentist</a>
                </li>
                <li>
                    <a href="reports.php"
                    ><i class="fa fa-clipboard-list"></i></i>Reports</a
                    >
                </li>
                <li>
                    <a href="log.php"><i class="fa-solid fa-history"></i> Logs</a>
                </li>
            </ul>
        </nav>

        <!-- Main content area -->
        <div class="main-content">
            <header class="main-header">
                <h1>Hey there, Welcome.</h1>
            </header>

            <!-- Charts Section -->
            <section class="charts-section">
                <div class="chart-container">
                    <canvas id="appointmentsChart"></canvas>
                </div>
                <div class="chart-container">
                    <canvas id="patientsChart"></canvas>
                </div>
                <div class="chart-container">
                    <canvas id="dentistsChart"></canvas>
                </div>
            </section>

            <!-- Stats Section -->
            <section class="stats">
                <?php
                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "dentalclinic";

                // Establish connection
                $conn = new mysqli($servername, $username, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to count total appointments by status
                $appointmentStatusQuery = "SELECT AppointmentStatus, COUNT(*) AS count FROM appointment GROUP BY AppointmentStatus";
                $appointmentStatusResult = $conn->query($appointmentStatusQuery);

                $appointmentData = [
                    'Upcoming' => 0,
                    'Completed' => 0,
                    'Missed' => 0,
                    'Cancelled' => 0,
                ];

                while ($row = $appointmentStatusResult->fetch_assoc()) {
                    $status = $row['AppointmentStatus'];
                    $count = $row['count'];
                    $appointmentData[$status] = $count;
                }

                // Query to count total patients by age group
                $patientAgeQuery = "SELECT COUNT(*) AS count, 
                                        CASE 
                                            WHEN TIMESTAMPDIFF(YEAR, DOB, CURDATE()) >= 18 THEN 'Adults' 
                                            ELSE 'Children' 
                                        END AS age_group 
                                    FROM patient 
                                    GROUP BY age_group";

                $patientAgeResult = $conn->query($patientAgeQuery);

                $patientData = [
                    'Adults' => 0,
                    'Children' => 0,
                ];

                while ($row = $patientAgeResult->fetch_assoc()) {
                    $ageGroup = $row['age_group'];
                    $count = $row['count'];
                    $patientData[$ageGroup] = $count;
                }

                // Query to count total dentists
                $dentistQuery = "SELECT COUNT(*) AS totalDentists FROM dentist";
                $dentistResult = $conn->query($dentistQuery);
                $totalDentists = $dentistResult->fetch_assoc()['totalDentists'];

                // Close the connection
                $conn->close();

                // Display stats
                echo '<div class="stat-box">';
                echo '<h3>Appointments</h3>';
                echo '<p>Total: ' . array_sum($appointmentData) . '</p>';
                echo '</div>';

                echo '<div class="stat-box">';
                echo '<h3>Patients</h3>';
                echo '<p>Total: ' . array_sum($patientData) . '</p>';
                echo '</div>';

                echo '<div class="stat-box">';
                echo '<h3>Dentists</h3>';
                echo '<p>Total: ' . $totalDentists . '</p>';
                echo '</div>';

                // Output the data in JSON format for use in JavaScript
                echo '<script>';
                echo 'const appointmentsData = {';
                echo '    labels: ["Upcoming", "Completed", "Missed", "Cancelled"],';
                echo '    data: [' . $appointmentData['Upcoming'] . ', ' . $appointmentData['Completed'] . ', ' . $appointmentData['Missed'] . ', ' . $appointmentData['Cancelled'] . '],';
                echo '};';

                echo 'const patientsData = {';
                echo '    labels: ["Adults", "Children"],';
                echo '    data: [' . $patientData['Adults'] . ', ' . $patientData['Children'] . '],';
                echo '};';

                echo 'const dentistsData = {';
                echo '    labels: ["General", "Specialists"],';
                echo '    data: [' . $totalDentists . ', 0],'; // Assuming you want to use 'General' and 'Specialists' labels. Modify as needed.
                echo '};';

                echo '</script>';
                ?>

            </section>
        </div>
    </div>

    <!-- JavaScript for Charts -->
    <script>
        // Create Pie chart for appointments
        const appointmentsChart = new Chart(
        document.getElementById("appointmentsChart"),
        {
            type: "pie",
            data: {
                labels: appointmentsData.labels,
                datasets: [
                    {
                        data: appointmentsData.data,
                        backgroundColor: ["#4caf50", "#ffeb3b", "#f44336", "#9c27b0"],
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom",
                    },
                },
            },
        }
    );

    // Create Bar chart for patients
    const patientsChart = new Chart(
        document.getElementById("patientsChart"),
        {
            type: "bar",
            data: {
                labels: patientsData.labels,
                datasets: [
                    {
                        data: patientsData.data,
                        backgroundColor: ["#3f51b5", "#9c27b0"],
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        }
    );

    // Create Pie chart for dentists
    const dentistsChart = new Chart(
        document.getElementById("dentistsChart"),
        {
            type: "pie",
            data: {
                labels: dentistsData.labels,
                datasets: [
                    {
                        data: dentistsData.data,
                        backgroundColor: ["#ff9800", "#00bcd4"],
                    },
                ],
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom",
                    },
                },
            },
        }
    );
    </script>
</body>

</html>
