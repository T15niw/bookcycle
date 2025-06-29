<?php
session_start();

// if loggedIn redirecte to statistics
if (isset($_SESSION['admin_loggedin']) && $_SESSION['admin_loggedin'] === true) {
    header('Location: statistics.php');
    exit;
}

// db conn
$host = 'localhost';
$dbname = 'bookcycle';
$user = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// error msg var
$errorMessage = '';

// process form data when submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    if (empty($email) || empty($pass)) {
        $errorMessage = 'Please enter both email and password.';
    } else {
        try {
            // find admin by email
            $sql = "SELECT email_admin_ID, password FROM admin WHERE email_admin_ID = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            // check if email exists
            if ($stmt->rowCount() == 1) {
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);

                //verify PW
                if (password_verify($pass, $admin['password'])) {
                    // pw correct, start a nwe session
                    session_regenerate_id(true);

                    // store data in session variables
                    $_SESSION['admin_loggedin'] = true;
                    $_SESSION['admin_email'] = $admin['email_admin_ID'];

                    // Redirect to statistics
                    header("Location: statistics.php");
                    exit();
                } else {
                    // incorrect pW
                    $errorMessage = 'Invalid email or password.';
                }
            } else {
                // no admin found
                $errorMessage = 'Invalid email or password.';
            }
        } catch (PDOException $e) {
            $errorMessage = 'A system error occurred. Please try again later.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Login</title>
    <link rel="icon" href="../logo/bookcycle.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Lexend&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: "Lexend", sans-serif;
        }
        .login-page {
            height: 100%;
            width: 100%;
            background-color: #238649;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            background-color: #ffffff;
            padding: 45px 50px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 450px;
            box-sizing: border-box;
            text-align: center;
        }
        .login-card h2 {
            color: #333333;
            font-size: 24px;
            font-weight: 700;
            margin-top: 40px;
            margin-bottom: 40px;
            letter-spacing: -0.114px;
        }
        .login-form input[type="email"],
        .login-form input[type="password"] {
            width: 350px;
            height: 55px;
            padding: 14px 16px;
            margin-bottom: 25px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background-color: #f7f7f7;
            font-size: 1em;
            font-family: "Lexend", sans-serif;
            box-sizing: border-box;
        }
        .login-form input::placeholder {
            color: #aaaaaa;
        }
        .login-form button {
            width: 180px;
            height: 45px;
            padding: 15px 0px;
            background-color: #32eb2a;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-bottom: 40px;
        }
        .login-form button:hover {
            background-color: #2dbb2d; 
        }
        .error-message { 
            color: #D8000C; 
            background-color: #FFD2D2; 
            border: 1px solid; 
            padding: 10px; 
            border-radius: 4px; 
            margin-bottom: 15px; 
            text-align: center; 
        }
    </style>
</head>
<body>
    <div class="login-page">
        <div class="login-card">
            <h2>Welcome to Bookcycle's<br>Dashboard</h2>

            <?php if (!empty($errorMessage)): ?>
            <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>
            
            <form class="login-form" action="admin_login.php" method="post">
                <input type="email" name="email" placeholder="Email address" required>
                <input type="password" name="password" placeholder="Password" required>
                
                <button type="submit">Log In</button>
            </form>
        </div>
    </div>

</body>
</html>