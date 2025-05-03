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

// Initialize variables
$patient = null;

// Check if the ID is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch patient data from the database
    $sql = "SELECT * FROM patients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc(); // Fetch the patient record
    } else {
        echo "No patient found.";
        exit();
    }
} else {
    echo "No ID provided.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    ];

    // Update the patient record in the database
    // Update the patient record in the database
$update_sql = "UPDATE patients SET full_name=?, dob=?, gender=?, contact_number=?, email=?, address=?, blood_type=?, allergies=?, conditions=?, surgeries=?, medications=?, family_history=?, assigned_doctor=?, reason_for_visit=?, emergency_contact_name=?, relationship=?, emergency_contact_number=? WHERE id=?";
$update_stmt = $conn->prepare($update_sql);

// Ensure the number of parameters matches the number of columns
$update_stmt->bind_param("sssssssssssssssssi", 
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
        $id // This is the ID of the patient being updated
    );

    if ($update_stmt->execute()) {
        // Redirect to view records after successful update
        header("Location: view_records.php");
        exit();
    } else {
        echo "Error: " . $update_stmt->error;
    }

    // Close the statement
    $update_stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Patient Record</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2 ?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

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
            <h2>Update Patient Record</h2>
            <form method="POST" action="update_records.php?id=<?php echo $id; ?>">
                <h3>Basic Patient Information:</h3>
                
                <div class="form-group">
                    <div>
                        <label for="full_name">Full Name:</label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($patient['full_name']); ?>" required>
                    </div>
                    <div>
                        <label for="dob">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" value="<?php echo htmlspecialchars($patient['dob']); ?>" required>
                    </div>
                    <div>
                        <label for="gender">Gender:</label>
                        <select id="gender" name="gender" required>
                            <option value="male" <?php echo $patient['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                            <option value="female" <?php echo $patient['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                            <option value="other" <?php echo $patient['gender'] == 'other' ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="contact_number">Contact Number:</label>
                        <input type="tel" id="contact_number" name="contact_number" value="<?php echo htmlspecialchars($patient['contact_number']); ?>" required>
                    </div>
                    <div>
                        <label for="email">Email Address (Optional):</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>">
                    </div>
                    <div>
                        <label for="address">Home Address:</label>
                        <textarea id="address" name="address" required><?php echo htmlspecialchars($patient['address']); ?></textarea>
                    </div>
                </div>

                <h3>Medical Information:</h3>
                <div class="form-group">
                    <div>
                        <label for="blood_type">Blood Type:</label>
                        <input type="text" id="blood_type" name="blood_type" value="<?php echo htmlspecialchars($patient['blood_type']); ?>" required>
                    </div>
                    <div>
                        <label for="allergies">Allergies (If any):</label>
                        <input type="text" id="allergies" name="allergies" value="<?php echo htmlspecialchars($patient['allergies']); ?>">
                    </div>
                    <div>
                        <label for="conditions">Existing Medical Conditions:</label>
                        <input type="text" id="conditions" name="conditions" value="<?php echo htmlspecialchars($patient['conditions']); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="surgeries">Past Surgeries or Treatments:</label>
                        <input type="text" id="surgeries" name="surgeries" value="<?php echo htmlspecialchars($patient['surgeries']); ?>">
                    </div>
                    <div>
                        <label for="medications">Current Medications:</label>
                        <input type="text" id="medications" name="medications" value="<?php echo htmlspecialchars($patient['medications']); ?>">
                    </div>
                    <div>
                        <label for="family_history">Family Medical History:</label>
                        <input type="text" id="family_history" name="family_history" value="<?php echo htmlspecialchars($patient['family_history']); ?>">
                    </div>
                </div>

                <div class="form-group">
                    <div>
                        <label for="assigned_doctor">Assigned Doctor:</label>
                        <input type="text" id="assigned_doctor" name="assigned_doctor" value="<?php echo htmlspecialchars($patient['assigned_doctor']); ?>">
                    </div>
                    <div>
                        <label for="reason_for_visit">Reason for Visit:</label>
                        <textarea id="reason_for_visit" name="reason_for_visit" required><?php echo htmlspecialchars($patient['reason_for_visit']); ?></textarea>
                    </div>
                </div>

                <h3>Emergency Contact:</h3>
                <div class="form-group">
                    <div>
                        <label for="emergency_contact_name">Emergency Contact Name:</label>
                        <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="<?php echo htmlspecialchars($patient['emergency_contact_name']); ?>" required>
                    </div>
                    <div>
                        <label for="relationship">Relationship:</label>
                        <input type="text" id="relationship" name="relationship" value="<?php echo htmlspecialchars($patient['relationship']); ?>" required>
                    </div>
                    <div>
                        <label for="emergency_contact_number">Emergency Contact Number:</label>
                        <input type="tel" id="emergency_contact_number" name="emergency_contact_number" value="<?php echo htmlspecialchars($patient['emergency_contact_number']); ?>" required>
                    </div>
                </div>

                <input type="submit" value="Update Patient">
            </form>
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