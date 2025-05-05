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

// Fetch medicines from the database
$medicines = [];
$sql = "SELECT * FROM medicines"; // Adjust the table name if necessary
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch all medicine records
    while ($row = $result->fetch_assoc()) {
        $medicines[] = $row; // Add each medicine record to the array
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
    <title>Store Medicines</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400;600&display=swap" rel="stylesheet" />
    
    <style>
        * {
            box-sizing: border-box;
            font-family: "Josefin Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: weight;
            font-style: normal;
            margin: 0;
            padding: 0;
        }

        input[type="submit"],
        button {
            background-color: #2980b9; /* Button background color */
            color: white; /* Button text color */
            border: none; /* Remove border */
            padding: 10px 15px; /* Padding for button */
            border-radius: 5px; /* Rounded corners for button */
            cursor: pointer; /* Pointer cursor on hover */
            transition: background 0.3s; /* Smooth background transition */
        }

        input[type="submit"]:hover,
        button:hover {
            background-color: #1c598a; /* Darker shade on hover */
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
            flex: 1; /* Allow the menu to grow and take available space */
            list-style-type: none;
        }

        

        .menu li span {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            cursor: pointer; /* Change cursor to pointer for better UX */
            padding: 10px; /* Add padding for better click area */
            transition: background 0.3s; /* Smooth background transition */
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
            color: white; /* Text color */
            text-decoration: none; /* Remove underline */
            padding: 10px; /* Same padding as other links */
            border-radius: 5px; /* Same border radius */
            margin-top: 15px; /* Add margin for spacing */
        }

        .logout:hover {
            background-color: #34495e; /* Same hover effect as other links */
        }

        .header {
            background-color: #2980b9; /* Header background color */
            color: white; /* Text color */
            padding: 15px; /* Padding for the header */
            display: flex; /* Use flexbox for layout */
            justify-content: flex-end; /* Align items to the right */
            align-items: center; /* Center items vertically */
            border-bottom: 2px solid #1c598a; /* Add a bottom border for separation */
            position: fixed; /* Fix the header at the top */
            top: 0; /* Align to the top */
            left: 250px; /* Align to the right of the sidebar */
            right: 0; /* Align to the right */
            z-index: 1000; /* Ensure it stays above other content */
        }

        .admin-info {
            font-size: 16px; /* Font size for admin info */
            font-weight: bold; /* Make it bold */
        }

        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 250px; /* Add margin to prevent overlap with fixed sidebar */
            margin-top: 70px; /* Add margin to prevent overlap with fixed header */
            background-color: #ecf0f1; /* Main content background color */
        }

        h2, h3 {
            color: #2980b9; /* Heading color */
            margin-bottom: 15px; /* Space below headings */
        }

        input[type="text"] {
            width: 100%; /* Full width */
            padding: 10px; /* Padding inside input fields */
            margin-bottom: 15px; /* Space below input fields */
            border: 1px solid #ccc; /* Border color */
            border-radius: 4px; /* Rounded corners for input fields */
            font-size: 14px; /* Font size for input fields */
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
        }

        th {
            background-color: #3ddbd9;
            color: white;
        }

        .actions {
            display: flex;
            gap: 10px; /* Space between action buttons */
        }

        .edit, .delete, .get-medicine {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-size: 0.9rem;
        }

        .edit {
            background-color: #28a745; /* Green for edit */
        }

        .edit:hover {
            background-color: #218838; /* Darker green on hover */
        }

        .delete {
            background-color: #dc3545; /* Red for delete */
        }

        .delete:hover {
            background-color: #c82333; /* Darker red on hover */
        }

        .get-medicine {
            background-color: #007bff; /* Blue for get medicine */
        }

        .get-medicine:hover {
            background-color: #0056b3; /* Darker blue on hover */
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
            <h2>Store Medicines</h2>
            <table id="medicineTable">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Dosage</th>
                        <th>Quantity</th>
                        <th>Expiry Date</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medicines as $medicine): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($medicine['name']); ?></td>
                            <td><?php echo htmlspecialchars($medicine['dosage']); ?></td>
                            <td><?php echo htmlspecialchars($medicine['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($medicine['expiry_date']); ?></td>
                            <td><?php echo htmlspecialchars($medicine['description']); ?></td>
                            <td class="actions">
                                <a href="update_medicine.php?id=<?php echo $medicine['id']; ?>" class="edit"><i class="fa-solid fa-edit"></i> Edit</a>
                                <a href="delete_medicine.php?id=<?php echo $medicine['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this medicine?');"><i class="fa-solid fa-trash"></i> Delete</a>
                                <a href="get_medicine.php?id=<?php echo $medicine['id']; ?>" class="get-medicine"><i class="fa-solid fa-pills"></i> Get Medicine</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
