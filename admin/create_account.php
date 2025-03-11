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

    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users_acc (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        
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
    <title>Create Account - School Management System</title>
    
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

        .register-container {
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
    <div class="register-container">
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
            <input type="submit" value="Create Account">
        </form>
        <div class="footer">
            <hr style="margin: 20px 0;"> <!-- Horizontal line with margin for space -->
            <input type="button" value="Back to Login" class="create-account" onclick="window.location.href='login.php'" style="margin-top: 20px;">
        </div>
    </div>
</body>
</html>