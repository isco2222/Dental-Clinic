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


        <?php
        // Database connection
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "dentalclinic";

        $conn = new mysqli($servername, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        ?>

        <div class="main-content">
          <div class="form-container">
            <h1>Add New Dentist</h1>
              <form action="add_dentist.php" method="POST">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required />
                
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required />
                
                <label for="Specialty">Specialty</label>
                <input type="text" id="Specialty" name="Specialty" required />

                <label for="ContactNumber">Contact Number:</label>
                <input type="tel" id="ContactNumber" name="ContactNumber" required />

                <label for="email">Email</label>
                <input type="email" id="email" name="email" required />

                <label for="service">Services:</label>
                  <select id="service" name="service" required>
                      <?php
                      // Query to fetch services from the database
                      $sql = "SELECT * FROM service";
                      $result = $conn->query($sql);
                      
                      // Check if query returned any results
                      if ($result && $result->num_rows > 0) {
                          // Loop through results and create option elements
                          while ($row = $result->fetch_assoc()) {
                              echo '<option value="' . htmlspecialchars($row['ServiceName']) . '">' . htmlspecialchars($row['ServiceName']) . '</option>';
                          }
                      } else {
                          // Handle case where there are no services in the database
                          echo '<option disabled>No services available</option>';
                      }
                      ?>
                  </select>
                
                <button type="submit">Add Dentist</button>
              </form>
              <div class="success-message" id="successMessage" style="display: none;">
                Dentist added successfully!
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
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $Specialty = $_POST['Specialty'];
        $ContactNumber = $_POST['ContactNumber'];
        $email = $_POST['email'];

        // Insert data into the patient table
        $sql = "INSERT INTO dentist (FirstName, LastName, Specialty, ContactNumber, Email) VALUES (?, ?, ?, ?, ?)";

        if ($statement = $conn->prepare($sql)) {
          $statement->bind_param("sssss", $firstName, $lastName, $Specialty, $ContactNumber, $email);
          
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

