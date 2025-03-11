<?php
session_start(); // Start the session

// Include the database configuration file
include('../database/config.php'); // Make sure this path is correct

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username']; // Get the username from the session
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Initialize an array to hold patient data
$patients = [];

// Fetch patient data from the database
$sql = "SELECT * FROM patients"; // Adjust the table name if necessary
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch all patient records
    while ($row = $result->fetch_assoc()) {
        $patients[] = $row; // Add each patient record to the array
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Records</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        .main-content {
            flex: 1;
            padding: 20px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .patient-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; /* Space between patient records */
        }
        .patient-record {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            background: #fff;
            width: calc(33.33% - 20px); /* Three records per row with gap */
            box-sizing: border-box; /* Include padding and border in width */
        }
        .patient-info {
            margin-bottom: 10px;
        }
        .patient-info label {
            font-weight: bold;
        }
        
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <h2>SCMS</h2>
            <ul class="menu">
                <li>
                    <span class="toggle dashboard"><i class="fa-solid fa-house"></i> Dashboard</span>
                </li>
                <li>
                    <span class="toggle"><i class="fa-solid fa-hospital-user"></i> Patient</span>
                    <ul class="submenu">
                        <li><a href="patients.php">Add Patient</a></li>
                        <li><a href="view_records.php">View Records</a></li>
                        <li><a href="#search-filter-patients">Search & Filter Patients</a></li>
                        <li><a href="#edit-patient-info">Edit Patient Information</a></li>
                    </ul>
                </li>
                <li>
                    <span class="toggle"><i class="fa-solid fa-capsules"></i> Medicine</span>
                    <ul class="submenu">
                        <li><a href="medicines.php">Add Medicines</a></li>
                        <li><a href="#search-filter-medicines">Search & Filter Medicines</a></li>
                        <li><a href="#expiry-date-tracking">Expiry Date Tracking</a></li>
                    </ul>
                </li>
                <li><a href="#settings"><i class="fa-solid fa-gears"></i> Settings</a></li>
            </ul>
            <a href="login.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </aside>
        
        <header class="header">
        <div class="admin-info">ADMINISTRATOR, Hi <?php echo htmlspecialchars($username); ?></div> <!-- Admin info on the right -->
        </header>
        
        <main class="main-content">
            <h2>Patient Records</h2>
            <div class="patient-container">
                <?php foreach ($patients as $patient): ?>
                    <div class="patient-record">
                        <br>
                        <div class="patient-info">
                            <label>Full Name</label> <?php echo htmlspecialchars($patient['full_name']); ?>
                        </div><br>
                        <div class="patient-info">
                            <label>DOB</label> <?php echo htmlspecialchars($patient['dob']); ?>
                        </div><br>
                        <div class="patient-info">
                            <label>Gender</label> <?php echo htmlspecialchars($patient['gender']); ?>
                        </div><br>
                        <div class="patient-info">
                            <label>Contact Number</label> <?php echo htmlspecialchars($patient['contact_number']); ?>
                        </div><br>
                        <div class="patient-info">
                            <label>Email</label> <?php echo htmlspecialchars($patient['email']); ?>
                        </div><br>
                        <div class="patient-info">
                            <label>Address</label> <?php echo htmlspecialchars($patient['address']); ?>
                        </div><br>
                        <div class="patient-info">
                            <label>Blood Type</label> <?php echo htmlspecialchars($patient['blood_type']); ?>
                        </div><br>
                        <div class="patient-info">
                            <label>Allergies</label> <?php echo htmlspecialchars($patient['allergies']); ?>
                        </div><br>
                        <div class="patient-info">
                            <label>Assigned Doctor</label> <?php echo htmlspecialchars($patient['assigned_doctor']); ?>
                        </div><br>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
    </div>

    <script>
        // JavaScript to toggle submenu visibility
        const toggles = document.querySelectorAll('.toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                const submenu = toggle.nextElementSibling;
                submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
            });
        });

        document.querySelector(".toggle.dashboard").addEventListener("click", function() {
            window.location.href = "dashboard.php";
        });
    </script>
</body>
</html>