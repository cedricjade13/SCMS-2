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

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect patient data from the form
    $patientData = [
        'full_name' => htmlspecialchars($_POST['full_name']),
        'dob' => htmlspecialchars($_POST['dob']),
        'gender' => htmlspecialchars($_POST['gender']),
        'contact_number' => htmlspecialchars($_POST['contact_number']),
        'email' => htmlspecialchars($_POST['email']),
        'address' => htmlspecialchars($_POST['address']),
        'blood_type' => htmlspecialchars($_POST['blood_type']),
        'allergies' => htmlspecialchars($_POST['allergies']),
        'conditions' => htmlspecialchars($_POST['conditions']),
        'surgeries' => htmlspecialchars($_POST['surgeries']),
        'medications' => htmlspecialchars($_POST['medications']),
        'family_history' => htmlspecialchars($_POST['family_history']),
        'assigned_doctor' => htmlspecialchars($_POST['assigned_doctor']),
        'reason_for_visit' => htmlspecialchars($_POST['reason_for_visit']),
        'emergency_contact_name' => htmlspecialchars($_POST['emergency_contact_name']),
        'relationship' => htmlspecialchars($_POST['relationship']),
        'emergency_contact_number' => htmlspecialchars($_POST['emergency_contact_number']),
        'course' => htmlspecialchars($_POST['course']),
        'year_level' => htmlspecialchars($_POST['year_level']),
        'section' => htmlspecialchars($_POST['section']),
        'semester' => htmlspecialchars($_POST['semester']),
        'academic_year' => htmlspecialchars($_POST['academic_year']),
    ];

    // Insert patient data into the database
    $stmt = $conn->prepare("INSERT INTO patients (full_name, dob, gender, contact_number, email, address, blood_type, allergies, conditions, surgeries, medications, family_history, assigned_doctor, reason_for_visit, emergency_contact_name, relationship, emergency_contact_number, course, year_level, section, semester, academic_year) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssssssssssss", 
        $patientData['full_name'], 
        $patientData['dob'], 
        $patientData['gender'], 
        $patientData['contact_number'], 
        $patientData['email'], 
        $patientData['address'], 
        $patientData['blood_type'], 
        $patientData['allergies'], 
        $patientData['conditions'], 
        $patientData['surgeries'], 
        $patientData['medications'], 
        $patientData['family_history'], 
        $patientData['assigned_doctor'], 
        $patientData['reason_for_visit'], 
        $patientData['emergency_contact_name'], 
        $patientData['relationship'], 
        $patientData['emergency_contact_number'], 
        $patientData['course'], 
        $patientData['year_level'], 
        $patientData['section'], 
        $patientData['semester'], 
        $patientData['academic_year']
    );

    if ($stmt->execute()) {
        // Redirect to view records after successful insertion
        header("Location: view_records.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manage Patients</title>
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&amp;family=Poppins:wght@400;500;600&amp;display=swap" rel="stylesheet" />
    <style>
    /* Additional styles for the form layout */
    .form-group {
        display: flex; /* Use flexbox for layout */
        justify-content: space-between; /* Space items evenly */
        margin-bottom: 15px; /* Space below each group */
    }

    .form-group > div {
        flex: 1; /* Allow each field to grow equally */
        margin-right: 10px; /* Space between fields */
    }

    .form-group > div:last-child {
        margin-right: 0; /* Remove margin from the last field */
    }

    .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            position: fixed;
            height: 100vh; /* Full viewport height */
            overflow-y: auto; /* Enable vertical scrolling */
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease; /* Smooth transition for sidebar */
        }

        .menu li {
            margin: 15px 0;
            position: relative; /* Position relative for submenu */
        }

        .menu li .submenu {
            max-height: 0; /* Set max-height to 0 for transition */
            opacity: 0; /* Set opacity to 0 for transition */
            overflow: hidden; /* Hide overflow */
            transition: max-height 0.5s ease, opacity 0.5s ease; /* Smooth transition for submenu */
            display: block; /* Keep the submenu in the flow */
        }

        .menu li .submenu.show {
            max-height: 175px; /* Set a larger max-height for the submenu */
            opacity: 1; /* Set opacity to 1 for transition */
        }

        .menu li span:hover {
            background-color: #34495e; /* Change background on hover */
            transition: background-color 0.3s ease; /* Smooth transition for background */
        }

        .menu li a:hover {
            background-color: #34495e; /* Change background on hover */
            transition: background-color 0.3s ease; /* Smooth transition for background */
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
                        <li><a href="frequent_visits.php"></i> Frequent Visits</a></li>
                    </ul>
                </li>
                <li>
                    <span class="toggle"><i class="fa-solid fa-capsules"></i> Medicine</span>
                    <ul class="submenu">
                        <li><a href="medicines.php">Add Medicines</a></li>
                        <li><a href="store_medicine.php">Search & Filter Medicines</a></li>
                        <li><a href="view_dispensed_medicines.php">View Dispensed Medicines</a></li>
                    </ul>
                </li>
                <li><a href="create_account.php"><i class="fa-solid fa-user"></i> Manage Account</a></li>
                <li><a href="#settings"><i class="fa-solid fa-gears"></i> Settings</a></li>
            </ul>
            <a href="login.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </aside>

        <header class="header">
            <div class="admin-info">ADMINISTRATOR, Hi <?php echo htmlspecialchars($username); ?></div>
        </header>

        <main class="main-content">
            <h2>Add Patient</h2>
            <form method="POST" action="patients.php" novalidate>
                <h3>Basic Patient Information:</h3>

                <div class="form-group">
                    <div>
                        <label for="full_name">Full Name:</label>
                        <input type="text" id="full_name" name="full_name" required />
                    </div>
                    <div>
                        <label for="dob">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" required />
                    </div>
                    <div>
                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="course">Course:</label>
                        <select id="course" name="course" required>
                            <option value="" disabled selected>Select Course</option>
                            <option value="BSIT">BSIT</option>
                            <option value="BSCRIM">BSCRIM</option>
                            <option value="BSBA">BSBA</option>
                            <option value="BSED">BSED</option>
                            <option value="BEED">BEED</option>
                            <option value="BSTM">BSTM</option>
                            <option value="BSHM">BSHM</option>
                        </select>
                    </div>
                    <div>
                        <label for="year_level">Year Level:</label>
                        <select id="year_level" name="year_level" required>
                            <option value="" disabled selected>Select Year Level</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div>
                        <label for="section">Section:</label>
                        <select id="section" name="section" required>
                            <option value="" disabled selected>Select Section</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="contact_number">Contact Number:</label>
                        <input type="tel" id="contact_number" name="contact_number" required />
                    </div>
                    <div>
                        <label for="email">Email Address (Optional):</label>
                        <input type="email" id="email" name="email" />
                    </div>
                    <div>
                        <label for="semester">Semester:</label>
                        <select id="semester" name="semester" required>
                            <option value="" disabled selected>Select Semester</option>
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>
                        </select>
                    </div>
                    <div>
                        <label for="academic_year">Academic Year:</label>
                        <select id="academic_year" name="academic_year" required>
                            <option value="" disabled selected>Select Academic Year</option>
                            <option value="2025-2026">2025-2026</option>
                            <option value="2026-2027">2026-2027</option>
                            <option value="2027-2028">2027-2028</option>
                            <option value="2028-2029">2028-2029</option>
                            <option value="2029-2030">2029-2030</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="address">Home Address:</label>
                        <textarea id="address" name="address" required></textarea>
                    </div>
                </div>

                <h3>Medical Information:</h3>
                <div class="form-group">
                    <div>
                        <label for="blood_type">Blood Type:</label>
                        <input type="text" id="blood_type" name="blood_type" required />
                    </div>
                    <div>
                        <label for="allergies">Allergies (If any):</label>
                        <input type="text" id="allergies" name="allergies" />
                    </div>
                    <div>
                        <label for="conditions">Existing Medical Conditions:</label>
                        <input type="text" id="conditions" name="conditions" />
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="surgeries">Past Surgeries or Treatments:</label>
                        <input type="text" id="surgeries" name="surgeries" />
                    </div>
                    <div>
                        <label for="medications">Current Medications:</label>
                        <input type="text" id="medications" name="medications" />
                    </div>
                    <div>
                        <label for="family_history">Family Medical History:</label>
                        <input type="text" id="family_history" name="family_history" />
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="assigned_doctor">Assigned Doctor:</label>
                        <input type="text" id="assigned_doctor" name="assigned_doctor" />
                    </div>
                    <div>
                        <label for="reason_for_visit">Reason for Visit:</label>
                        <textarea id="reason_for_visit" name="reason_for_visit" required></textarea>
                    </div>
                </div>

                <h3>Emergency Contact:</h3>
                <div class="form-group">
                    <div>
                        <label for="emergency_contact_name">Emergency Contact Name:</label>
                        <input type="text" id="emergency_contact_name" name="emergency_contact_name" required />
                    </div>
                    <div>
                        <label for="relationship">Relationship:</label>
                        <input type="text" id="relationship" name="relationship" required />
                    </div>
                    <div>
                        <label for="emergency_contact_number">Emergency Contact Number:</label>
                        <input type="tel" id="emergency_contact_number" name="emergency_contact_number" required />
                    </div>
                </div>

                <input type="submit" value="Add Patient" />
            </form>
        </main>
    </div>

    <script>
        // JavaScript to toggle submenu visibility
        const toggles = document.querySelectorAll('.toggle');

        toggles.forEach(toggle => {
            toggle.addEventListener('click', () => {
                // Close all submenus
                toggles.forEach(t => {
                    const submenu = t.nextElementSibling;
                    if (submenu) {
                        submenu.classList.remove('show'); // Remove show class to close
                    }
                });

                // Open the clicked submenu
                const submenu = toggle.nextElementSibling;
                if (submenu) {
                    submenu.classList.toggle('show'); // Toggle show class to open/close
                }
            });
        });

        document.querySelector(".toggle.dashboard").addEventListener("click", function () {
            window.location.href = "dashboard.php";
        });
    </script>
</body>
</html>
