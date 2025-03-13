<?php 
session_start(); // Start the session
$error = ""; // Initialize the variable
if (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
}

// Include the database configuration file
include('../database/config.php'); // Adjust the path as necessary

// Login logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password, account FROM users_acc WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $account);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Password is correct, start session and redirect based on account type
            $_SESSION['username'] = $username;
            $_SESSION['account'] = $account; // Store account type in session

            // Redirect based on account type
            if ($account === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else if ($account === 'staff') {
                header("Location: ../staff/dashboard.php");
            } else {
                header("Location: login.php?error=Invalid account type");
            }
            exit();
        } else {
            // Invalid password
            header("Location: login.php?error=Invalid password");
            exit();
        }
    } else {
        // No user found
        header("Location: login.php?error=No user found");
        exit();
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - School Management System</title>
    
    <style>
        /* Your CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #e9eff1; /* Light background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            max-width: 400px;
            width: 100%;
            padding: 40px; /* Increased padding */
            background-color: #ffffff; /* White background */
            border-radius: 8px; /* More rounded corners */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Enhanced shadow */
        }

        h2 {
            text-align: center;
            color: #1877f2; /* Facebook-like blue color */
            margin-bottom: 20px; /* Bottom margin for spacing */
        }

        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
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
        input[type="password"] {
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

        .footer {
            text-align: center;
            margin-top: 20px; /* Space above footer */
        }

        .footer a {
            color: #1877f2; /* Link color */
            text-decoration: none;
        }

        /* Style for the new account button */
        .create-account {
            background-color: #2c3e50; /* Dark color */
            color: white;
            border: none;
            padding: 10px; /* Reduced padding */
            border-radius: 5px;
            cursor: pointer;
            width: 70%; /* Smaller width than the login button */
            font-size: 16px; /* Same font size */
            transition: background 0.3s;
        }

        .create-account:hover {
            background-color: #1a242f; /* Darker shade on hover */
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login to SCMS</h2>
        <br>
        <br>
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <input type="text" id="username" name="username" placeholder="Email or phone number" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <br>
            <br>
            <input type="submit" value="Log In">
        </form>
        
    </div>
</body>
</html>