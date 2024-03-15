<?php
// Start a new session
session_start();

// Database connection details
$host = "localhost"; // or your host
$username = "root";
$password = "";
$database = "projet";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Login or Register based on the button clicked
    if (isset($_POST['login'])) {
        // Login logic
        $sql = "SELECT * FROM users WHERE email='$email' AND password='".md5($password)."'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Success - Set session variables and redirect to a different page
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            // Redirect to user profile or dashboard page
            header("Location: dashboard.php");
        } else {
            // Failure - Redirect back to login with error
            header("Location: login.html?error=Invalid credentials");
        }
    } elseif (isset($_POST['register'])) {
        // Registration logic
        // First, check if user already exists
        $checkUser = "SELECT * FROM users WHERE email='$email'";
        $checkResult = $conn->query($checkUser);
        
        if ($checkResult->num_rows == 0) {
            // User does not exist, proceed with registration
            $hashedPassword = md5($password);
            $registerSql = "INSERT INTO users (email, password) VALUES ('$email', '$hashedPassword')";
            if ($conn->query($registerSql) === TRUE) {
                // Success - Redirect to login page
                header("Location: login.html?success=Account created successfully. Please login.");
            } else {
                // Failure - Redirect back with error
                header("Location: register.html?error=Error in registration");
            }
        } else {
            // User already exists
            header("Location: register.html?error=User already exists");
        }
    }
}

$conn->close();
?>
