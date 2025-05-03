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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("INSERT INTO medicines (name, dosage, quantity, expiry_date, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $name, $dosage, $quantity, $expiry_date, $description);

    $name = htmlspecialchars($_POST['name']);
    $dosage = htmlspecialchars($_POST['dosage']);
    $quantity = htmlspecialchars($_POST['quantity']);
    $expiry_date = htmlspecialchars($_POST['expiry_date']);
    $description = htmlspecialchars($_POST['description']);

    if ($stmt->execute()) {
        header("Location: store_medicine.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Add Medicine</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
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
            position: fixed; /* Keep the sidebar fixed */
            height: 100%; /* Full height */
            display: flex;
            flex-direction: column; /* Arrange items in a column */
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .menu {
            flex: 1; /* Allow the menu to grow and take available space */
            list-style-type: none;
        }

        .menu li {
            margin: 15px 0;
        }

        .menu li span {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            cursor: pointer; /* Change cursor to pointer for better UX */
            padding: 10px; /* Add padding for better click area */
            transition: background 0.3s; /* Smooth background transition */
        }

        .menu li span:hover {
            background-color: #34495e; /* Hover effect for Patient and Medicine */
        }

        .menu li .submenu {
            display: none; /* Hide submenus by default */
            padding-left: 15px; /* Indent submenu items */
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
            background-color: #34495e; /* Same hover effect as other links */
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

        input[type="text"],
        input[type="date"] {
            width: 100%; /* Full width */
            padding: 10px; /* Padding inside input fields */
            margin-bottom: 15px; /* Space below input fields */
            border: 1px solid #ccc; /* Border color */
            border-radius: 4px; /* Rounded corners for input fields */
            font-size: 14px; /* Font size for input fields */
        }

        input[type="date"] {
            width: 100%; /* Adjust width for expiry date input */
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

        .edit, .delete {
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
            <div class="admin-info">ADMINISTRATOR, Hi <?php echo htmlspecialchars($username); ?></div> <!-- Admin info on the right -->
        </header>
        
        <main class="main-content">
            <h2>Add Medicine</h2>
            <form method="POST" action="">
                <input type="text" name="name" placeholder="Medicine Name" required>
                <input type="text" name="dosage" placeholder="Dosage" required>
                <input type="text" name="quantity" placeholder="Quantity" required>
                <input type="date" name="expiry_date" placeholder="Expiry Date" required>
                <input type="text" name="description" placeholder="Description" required>
                <input type="submit" value="Add Medicine">
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