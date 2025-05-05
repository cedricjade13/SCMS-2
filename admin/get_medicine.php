<?php
session_start();

// Include the database configuration file
include('../database/config.php');

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Check if the medicine ID is set
if (!isset($_GET['id'])) {
    echo "No medicine ID provided.";
    exit();
}

$medicine_id = intval($_GET['id']);

// Initialize variables
$medicine = null;
$patients = [];

// Fetch medicine details
$sql = "SELECT * FROM medicines WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $medicine_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $medicine = $result->fetch_assoc();
} else {
    echo "Medicine not found.";
    exit();
}

// Fetch patients for the select dropdown
$sql_patients = "SELECT id, full_name FROM patients ORDER BY full_name ASC";
$result_patients = $conn->query($sql_patients);

if ($result_patients->num_rows > 0) {
    while ($row = $result_patients->fetch_assoc()) {
        $patients[] = $row;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantity_to_get = intval($_POST['quantity_to_get']);
    $selected_patient_id = intval($_POST['patient_id']);

    if ($quantity_to_get <= 0) {
        $error = "Please enter a valid quantity.";
    } elseif ($quantity_to_get > $medicine['quantity']) {
        $error = "Quantity requested exceeds available stock.";
    } else {
        // Update medicine quantity (subtract the quantity taken)
        $new_quantity = $medicine['quantity'] - $quantity_to_get;
        $update_sql = "UPDATE medicines SET quantity = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_quantity, $medicine_id);
        if ($update_stmt->execute()) {
            // Record the transaction in the medicine_dispenses table
            $insert_sql = "INSERT INTO medicine_dispenses (patient_id, medicine_id, quantity) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("iii", $selected_patient_id, $medicine_id, $quantity_to_get);
            $insert_stmt->execute();
            $insert_stmt->close();

            // Redirect to store_medicine.php with success message
            header("Location: store_medicine.php?message=Medicine dispensed successfully");
            exit();
        } else {
            $error = "Failed to update medicine quantity: " . $update_stmt->error;
        }
        $update_stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Get Medicine</title>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;600&display=swap" rel="stylesheet" />
<style>
    * {
        box-sizing: border-box;
        font-family: "Josefin Sans", sans-serif;
        margin: 0;
        padding: 0;
    }

    input[type="submit"],
    button {
        background-color: #2980b9;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
    }

    input[type="submit"]:hover,
    button:hover {
        background-color: #1c598a;
    }

    .container {
        display: flex;
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

    .sidebar h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    .menu {
        flex: 1;
        list-style-type: none;
        padding-left: 0;
    }

    

    .menu li span {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        cursor: pointer;
        padding: 10px;
        transition: background 0.3s;
    }

    

    .menu li a {
        color: white;
        text-decoration: none;
        padding: 10px;
        display: block;
        border-radius: 5px;
        transition: background 0.3s;
    }

    

    .logout {
        color: white;
        text-decoration: none;
        padding: 10px;
        border-radius: 5px;
        margin-top: 15px;
    }

    .logout:hover {
        background-color: #34495e;
    }

    .header {
        background-color: #2980b9;
        color: white;
        padding: 15px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        border-bottom: 2px solid #1c598a;
        position: fixed;
        top: 0;
        left: 250px;
        right: 0;
        z-index: 1000;
    }

    .admin-info {
        font-size: 16px;
        font-weight: bold;
    }

    .main-content {
        flex: 1;
        padding: 20px;
        margin-left: 250px;
        margin-top: 70px;
        background-color: #fff;
        border-radius: 8px;
        max-width: 600px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    h2 {
        color: #2980b9;
        margin-bottom: 20px;
        text-align: center;
    }

    form label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    input[type="number"],
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
    }

    .error {
        color: #dc3545;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .info {
        margin-bottom: 15px;
        font-size: 16px;
        color: #555;
    }
</style>
</head>
<body>
<div class="container">
    <aside class="sidebar">
        <h2>SCMS</h2>
        <ul class="menu">
            <li><span class="toggle dashboard"><i class="fa-solid fa-house"></i> Dashboard</span></li>
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
        <h2>Get Medicine</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="info">Current Quantity: <?php echo htmlspecialchars($medicine['quantity']); ?></div>

            <label for="quantity_to_get">How many medicines will you get?</label>
            <input type="number" name="quantity_to_get" id="quantity_to_get" min="1" max="<?php echo htmlspecialchars($medicine['quantity']); ?>" required>

            <label for="patient_id">Select Patient</label>
            <select name="patient_id" id="patient_id" required>
                <option value="">-- Select Patient --</option>
                <?php foreach ($patients as $patientOption): ?>
                    <option value="<?php echo htmlspecialchars($patientOption['id']); ?>"><?php echo htmlspecialchars($patientOption['full_name']); ?></option>
                <?php endforeach; ?>
            </select>

            <input type="submit" value="Submit">
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

    document.querySelector(".toggle.dashboard").addEventListener("click", function() {
        window.location.href = "dashboard.php";
    });
</script>
</body>
</html>
