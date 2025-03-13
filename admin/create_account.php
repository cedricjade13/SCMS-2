<?php 
session_start(); // Start session
$error = ""; // Initialize error variable
$success = ""; // Initialize success message

// Include the database configuration file
include('../database/config.php'); // Adjust the path as necessary

// Registration logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $account_type = htmlspecialchars($_POST['account_type']); // Get account type

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users_acc (username, password, account) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $account_type); // Include account type
        
        // Attempt to execute the statement
        if ($stmt->execute()) {
            $success = "Account created successfully! You can now log in.";
        } else {
            $error = "Error creating account. Please try again.";
        }

        // Close the statement
        $stmt->close();
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
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <title>Create Account - School Management System</title>

    
    <style>
   

        h2 {
            text-align: center;
            color: #1877f2; /* Facebook-like blue color */
            margin-bottom: 20px; /* Bottom margin for spacing */
        }

        .error, .success {
            margin-bottom: 15px;
            text-align: center;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        .footer {
            text-align: center;
            margin-top: 20px; /* Space above footer */
        }

        .footer a {
            color: #1877f2; /* Link color */
            text-decoration: none;
        }

        input[type="submit"] {
            background-color: #1877f2; /* Facebook blue */
            color: white;
            border: none;
            padding: 15px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%; /* Full width */
            font-size: 16px; /* Increase font size */
            transition: background 0.3s;
            box-sizing: border-box; /* Include padding and border in the element's total width */
        }

        input[type="text"],
        input[type="password"],
        select {
            padding: 15px; /* Increased padding for inputs */
            margin-bottom: 15px;
            border: 1px solid #ddd; /* Light border */
            border-radius: 5px; /* Rounded corners */
            font-size: 16px; /* Increase font size */
            width: 100%; /* Full width */
            box-sizing: border-box; /* Ensure the total width includes padding */
        }

        input[type="submit"]:hover {
            background-color: #145dbf; /* Darker shade on hover */
        }

        .create-account {
            background-color: #2c3e50; /* Dark color */
            color: white;
            border: none;
            padding: 10px; /* Reduced padding */
            border-radius: 5px;
            cursor: pointer;
            width: 70%; /* Smaller width than the login button */
            font-size:  16px; /* Same font size */
            transition: background 0.3s;
        }

        .create-account:hover {
            background-color: #1a242f; /* Darker shade on hover */
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
                        <li><a href="#search-filter-medicines">Search & Filter Medicines</a></li>
                        <li><a href="#expiry-date-tracking">Expiry Date Tracking</a></li>
                    </ul>
                </li>
                <li><a href="create_account.php"><i class="fa-solid fa-user"></i> Manage Account</a></li>
                <li><a href="#settings"><i class="fa-solid fa-gears"></i> Settings</a></li>
            </ul>
            <a href="login.php" class="logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
        </aside>
        
        <header class="header">
            <div class="admin-info">ADMINISTRATOR, Hi <?php echo htmlspecialchars($username); ?></div> <!-- Display the username -->
        </header>    

        <div class="main-content">
            <h2>Create an Account</h2>
            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form method="POST" action="create_account.php">
                <input type="text" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                <select id="account_type" name="account_type" required>
                    <option value="" disabled selected>Select Account Type</option>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                </select>
                <input type="submit" value="Create Account">
            </form>
            <div class="footer">
                <hr style="margin: 20px 0;"> <!-- Horizontal line with margin for space -->
                <input type="button" value="Back to Login" class="create-account" onclick="window.location.href='login.php'" style="margin-top: 20px;">
            </div>
        </div>
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