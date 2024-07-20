<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="queries.css" />
    <title>Dental Clinic Dashboard</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    />
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
            <a href="appointment.php"
              ><i class="fa-regular fa-calendar-check"></i>Appointments</a
            >
          </li>
          <li>
            <a href="patient.php"
              ><i class="fa-solid fa-user-injured"></i>Patients</a
            >
          </li>
          <li>
            <a href="dentist.php"><i class="fa-solid fa-user-md"></i>Dentist</a>
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

        <div class="main-content">
          <div class="form-container">
            <h1>Add New Service</h1>
              <form action="add_service.php" method="POST">
                <label for="ServiceCode">ServiceCode:</label>
                <input type="text" id="ServiceCode" name="ServiceCode" required />
                
                <label for="ServiceName">ServiceName:</label>
                <input type="text" id="ServiceName" name="ServiceName" required />
                
                <label for="Cost">Cost ($):</label>
                <input type="number" id="Cost" name="Cost" required min="0" step="0.01" placeholder="0.00">
                
                <button type="submit">Add Service</button>
              </form>
              <div class="success-message" id="successMessage" style="display: none;">
                Service added successfully!
              </div>
          </div>
        </div>

        <?php
        // database connection file
        $servername = "localhost";
        $username = "root";
        $password = ""; 
        $database = "dentalclinic"; 
        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Retrieve form data
        $ServiceCode = $_POST['ServiceCode'];
        $ServiceName = $_POST['ServiceName'];
        $Cost = (float) $_POST['Cost'];

        // Insert data into the service table
        $sql = "INSERT INTO service (ServiceCode, ServiceName, Cost) VALUES (?, ?, ?)";

        if ($statement = $conn->prepare($sql)) {
          $statement->bind_param("ssd", $ServiceCode, $ServiceName, $Cost);
          
          if ($statement->execute()) {
            echo "<script>document.getElementById('successMessage').style.display = 'block';</script>";
          } else {
              echo "<p>Error adding patient: " . $statement->error . "</p>";
          }

          $statement->close();
        } else {
          echo "<p>Database error: " . $conn->error . "</p>";
        }

        // Close the database connection
        $conn->close();
        }
        ?>

</body>
</html>

