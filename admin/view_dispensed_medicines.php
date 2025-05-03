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

// Fetch dispensed medicines with patient and medicine info
$dispenses = [];
$sql = "SELECT md.id, p.full_name, m.name AS medicine_name, md.quantity, md.dispense_date 
        FROM medicine_dispenses md 
        JOIN patients p ON md.patient_id = p.id 
        JOIN medicines m ON md.medicine_id = m.id 
        ORDER BY md.dispense_date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dispenses[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Dispensed Medicines</title>
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
    .sidebar {
        width: 250px;
        background-color: #2c3e50;
        color: white;
        padding: 20px;
        position: fixed;
        height: 100%;
        display: flex;
        flex-direction: column;
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
    .menu li {
        margin: 15px 0;
    }
    .menu li span {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        cursor: pointer;
        padding: 10px;
        transition: background 0.3s;
    }
    .menu li span:hover {
        background-color: #34495e;
    }
    .menu li a {
        color: white;
        text-decoration: none;
        padding: 10px;
        display: block;
        border-radius: 5px;
        transition: background 0.3s;
    }
    .menu li a:hover {
        background-color: #34495e;
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
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
        vertical-align: middle;
    }
    th {
        background-color: #3ddbd9;
        color: white;
    }
    h2 {
        color: #2980b9;
        margin-bottom: 20px;
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
        <h2>Dispensed Medicines</h2>
        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Medicine Name</th>
                    <th>Quantity</th>
                    <th>Dispense Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($dispenses) > 0): ?>
                    <?php foreach ($dispenses as $dispense): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($dispense['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($dispense['medicine_name']); ?></td>
                            <td><?php echo htmlspecialchars($dispense['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($dispense['dispense_date']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center;">No dispensed medicines found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>
</div>

<script>
    // JavaScript to toggle submenu visibility
    const toggles = document.querySelectorAll('.toggle');
    toggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const submenu = toggle.nextElementSibling;
            submenu.style.display = (submenu.style.display === 'block') ? 'none' : 'block';
        });
    });

    document.querySelector('.toggle.dashboard').addEventListener('click', () => {
        window.location.href = 'dashboard.php';
    });
</script>
</body>
</html>
