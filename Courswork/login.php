<?php 
include 'db_connect.php'; 
session_start(); // Start the session

// Initialize variables
$username = '';
$password = '';
$error_message = '';

// Process the login form when submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user data from the database
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: Home.php'); // Redirect to homepage after login
            exit;
        } else {
            $error_message = "Incorrect username or password!";
        }
    } catch (PDOException $e) {
        $error_message = "An error occurred: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Inline styles for simplicity */
        .container { 
            width: 100%; 
            max-width: 400px; 
            padding: 20px; 
            margin: auto; 
            text-align: center; 
        }
        .form-group { 
            display: flex; 
            align-items: center; 
            margin-bottom: 15px; 
            position: relative; 
        }
        .form-control { 
            flex: 1; 
            padding: 10px; 
            font-size: 16px;
            border: 1px solid #ddd; 
            border-radius: 5px; 
            margin-left: 10px; 
            width: calc(100% - 30px);
        }
        .icon { 
            font-size: 20px;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            cursor: pointer;
            color: #888;
            font-size: 18px;
        }
    </style>
</head>
<body>
<img src="https://example.com/dolphin.png" alt="Dolphin" class="dolphin" />

<div class="container">
    <h1>Vinwo</h1>
    <h2>BY Anh Khoa</h2>
    <div class="tab-container">
        Login
    </div>
    
    <div id="login-form" style="display: block;">
        <form action="login.php" method="POST">
            <?php if (!empty($error_message)) : ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <div class="form-group">
                <i class="fas fa-user icon"></i> <!-- User icon -->
                <input type="text" class="form-control" name="username" placeholder="Username" required>
            </div>
            
            <div class="form-group">
                <i class="fas fa-lock icon"></i> <!-- Password icon -->
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                <span class="toggle-password" onclick="togglePassword()">
                    <i class="fas fa-eye" id="toggle-icon"></i>
                </span>
            </div>
            
            <button type="submit" class="btn">Login</button>
        </form>
    </div>

    <br> <br>
    <div class="link-container">
        <p>Don't have an account? <a href="register.php">Register Here</a></p>
    </div>
    <div class="admin-link">
        <a href="admin_login.php">Admin Login</a>
    </div>
    <div class="contact-link">
        <a href="mailto:huynhanhkhoa2707@gmail.com">Contact Admin</a>
    </div>
    <script>
    function togglePassword() {
        // Get the password input field and the toggle icon element
        const passwordInput = document.getElementById("password");
        const toggleIcon = document.getElementById("toggle-icon");
        // Check the current type of the password input field
        if (passwordInput.type === "password") {
        // If the type is 'password', change it to 'text' to show the password
            passwordInput.type = "text";
        // Change the icon from eye-slash (hidden) to eye (visible)
            toggleIcon.classList.replace("fa-eye-slash", "fa-eye");
        } else {
        // If the type is 'text', change it back to 'password' to hide the password
            passwordInput.type = "password";
        // Change the icon back to eye-slash (hidden) from eye (visible)
            toggleIcon.classList.replace("fa-eye", "fa-eye-slash");
        }
    }
    </script>
    <?php include 'templates/header.php'; ?>
</body>
</html>

