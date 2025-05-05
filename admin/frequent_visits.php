<?php
session_start();

// Include the database configuration file
include('../database/config.php');

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: login.php");
    exit();
}

// Query to find patients with 3 or more medicine dispenses within the same week
$frequentDispenses = [];
$sql = "
    SELECT p.id, p.full_name, YEAR(md.dispense_date) AS visit_year, WEEK(md.dispense_date) AS visit_week, COUNT(*) AS dispense_count
    FROM medicine_dispenses md
    JOIN patients p ON md.patient_id = p.id
    GROUP BY p.id, visit_year, visit_week
    HAVING dispense_count >= 3
    ORDER BY visit_year DESC, visit_week DESC, p.full_name
";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $frequentDispenses[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Frequent Visits - SCMS</title>
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
    .container {
        display: flex;
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
    
    .menu li span,
    .menu li a {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        cursor: pointer;
        padding: 10px;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background 0.3s;
    }
    
    .logout {
        color: white;
        text-decoration: none;
        padding: 10px;
        border-radius: 5px;
        margin-top: 15px;
        display: block;
        text-align: center;
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
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    h2 {
        color: #2980b9;
        margin-bottom: 20px;
    }
    .message {
        background-color: #f8d7da;
        color: #842029;
        border: 1px solid #f5c2c7;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 5px;
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
                    <li><a href="frequent_visits.php">Frequent Visits</a></li>
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
        <h2>Frequent Visits</h2>
        <?php if (count($frequentDispenses) > 0): ?>
            <?php foreach ($frequentDispenses as $patient): ?>
                <div class="message">
                    <strong><?php echo htmlspecialchars($patient['full_name']); ?></strong> has visited the clinic multiple times (<?php echo htmlspecialchars($patient['dispense_count']); ?> dispenses) 
                    in week <?php echo htmlspecialchars($patient['visit_week']); ?>, <?php echo htmlspecialchars($patient['visit_year']); ?> and should be referred to the hospital.
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No patients have visited multiple times within a single week.</p>
        <?php endif; ?>
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

    document.querySelector('.toggle.dashboard').addEventListener('click', () => {
        window.location.href = 'dashboard.php';
    });
</script>

</body>
</html>
