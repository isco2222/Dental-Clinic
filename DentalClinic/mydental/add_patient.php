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
            <h1>Add New Patient</h1>
              <form action="add_patient.php" method="POST">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" required />
                
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" required />
                
                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required />
                
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required />
                
                <label for="phoneNumber">Phone Number:</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" required />
                
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required />
                
                <label for="city">City:</label>
                <input type="text" id="city" name="city" required />
                
                <label for="zipCode">Zip Code:</label>
                <input type="text" id="zipCode" name="zipCode" required />
                
                <button type="submit">Add Patient</button>
              </form>
              <div class="success-message" id="successMessage" style="display: none;">
                Patient added successfully!
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
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $zipCode = $_POST['zipCode'];

        // Insert data into the patient table
        $sql = "INSERT INTO patient (FirstName, LastName, DOB, Gender, Email, PhoneNumber, Address, City, ZipCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($statement = $conn->prepare($sql)) {
          $statement->bind_param("sssssssss", $firstName, $lastName, $dob, $gender, $email, $phoneNumber, $address, $city, $zipCode);
          
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

