<?php
session_start();
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

//check if admin logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_logIn.php");
    exit();
}

$admin_email = $_SESSION['admin_email'];
$message = ''; //succ error msg
$message_type = ''; // succ error

// password change operation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    try {
        // get the current hashed pw from db
        $stmt = $conn->prepare("SELECT password FROM admin WHERE email_admin_ID = :email");
        $stmt->bindParam(':email', $admin_email);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($current_password, $admin['password'])) {
            // corrent pw id correct? now validate akhrin
            if (empty($new_password)) {
                $message = "New password cannot be empty.";
                $message_type = 'error';
            } elseif (strlen($new_password) < 8) {
                $message = "New password must be at least 8 characters long.";
                $message_type = 'error';
            } elseif ($new_password !== $confirm_password) {
                $message = "New password and confirmation do not match.";
                $message_type = 'error';
            } else {
                // kollo tamam? hash the new pw and send to db
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                
                $update_stmt = $conn->prepare("UPDATE admin SET password = :password WHERE email_admin_ID = :email");
                $update_stmt->bindParam(':password', $new_hashed_password);
                $update_stmt->bindParam(':email', $admin_email);
                
                if ($update_stmt->execute()) {
                    $message = "Password updated successfully!";
                    $message_type = 'success';
                } else {
                    $message = "Failed to update password. Please try again.";
                    $message_type = 'error';
                }
            }
        } else {
            // incorrect entered pw
            $message = "Incorrect current password.";
            $message_type = 'error';
        }

    } catch (PDOException $e) {
        $message = "Database error: " . $e->getMessage();
        $message_type = 'error';
    }
}

// fetch current admin data for display
try {
    $stmt = $conn->prepare("SELECT admin_name, email_admin_ID FROM admin WHERE email_admin_ID = :email");
    $stmt->bindParam(':email', $admin_email);
    $stmt->execute();
    $current_admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$current_admin) {
        die("Could not find admin data. Please log out and log in again.");
    }
} catch (PDOException $e) {
    die("Could not fetch admin data: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link rel="icon" href="../logo/bookcycle.png" type="image/x-icon" />
    <style>
            @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Lexend:wght@100..900&display=swap');
    :root {
        --primary-green: #32eb2a;
        --light-green-bg: rgba(50, 235, 42, 0.30);
        --text-primary: black;
        --text-secondary: #414142;
        --border-color: #e5e7eb;
        --background-main: #ffffff;
    }
    body { 
        margin: 0; 
        font-family: "Lexend", sans-serif; 
        background-color: #F9F9F9; 
        color: var(--text-primary); 
    }
    .dashboard { 
        min-height: 100vh; 
    }
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        width: 263px;
        z-index: 100;
        flex: 0 0 208px;
        background: var(--background-main, #FFF);
        border: 1px solid var(--Stroke-Color, #EFF0F6);
        display: flex;
        flex-direction: column;
        padding: 25px 35px 38px 18px;
        border-radius: 20px;
        box-sizing: border-box;
    }
        .logo { 
            margin-top: 10px; 
            margin-bottom: 15px; 
            margin-left: 18px; 
            height: 45px; 
        }
        .sidebar-nav { 
            flex-grow: 1; 
        }
        .sidebar ul { 
            list-style: none; 
            padding: 0; 
            margin: 0; 
        }
        .sidebar-nav li a, .sidebar-footer li a { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            padding: 12px 16px; 
            border-radius: 5px; 
            text-decoration: none; 
            color: var(--text-secondary); 
            font-size: 16px; 
            font-weight: 500; 
            transition: background-color 0.2s ease; 
        }
        .sidebar-nav li a:hover, .sidebar-footer li a:hover { 
            background-color: #F9F9F9; 
            color: var(--text-primary); 
        }
        .sidebar-footer li.active a { 
            background-color: var(--light-green-bg); 
            color: var(--primary-green); 
        }
        .sidebar-nav img, .sidebar-footer img { 
            width: 30px; 
            height: 30px; 
        }
    .main-content {
        margin-left: 263px;
        flex-grow: 1;
        padding: 40px 32px;
        background-color: #F9F9F9;
    }
    .content-header h1 { 
        font-size: 28px; 
        font-weight: 700; 
        margin: 0 0 15px 0; 
    }
    hr { 
        margin-bottom: 20px; 
        border: 0; 
        border-top: 1px solid #EFF0F6; 
    }
/* *************************Main Content********************** */



.profile-container {
    margin-top: 25px;
}

.welcome-banner {
    background: linear-gradient(90deg, rgba(50, 235, 42, 0.60) 0%, #238649 100%);
    color: #3E435D;
    padding: 38px 60px;
    border-radius: 12px;
    font-size: 20px;
    font-weight: 500;
    margin-bottom: 40px;
}
.profile-form {
    display: flex;
    flex-direction: column;
    gap: 22px;
}
.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}
.form-group {
    display: flex;
    flex-direction: column;
}
.form-group label {
    font-size: 14px;
    color: var(--text-secondary, #414142);
    margin-bottom: 8px;
    font-weight: 500;
}
.form-group input {
    font-family: "Lexend", sans-serif;
    padding: 14px 16px;
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 8px;
    background-color: #FDFDFD;
    font-size: 15px;
    color: var(--text-secondary, #414142);
    width: 100%;
    box-sizing: border-box;
}
.form-group input:focus {
    outline: none;
    border-color: #238649;
    box-shadow: 0 0 0 2px rgba(35, 134, 73, 0.2);
}
.form-group input:disabled {
    background-color: #F0F0F0;
    color: #888;
    cursor: not-allowed;
    border-color: #e5e7eb;
}
.form-section-title {
    font-size: 24px;
    font-weight: 700;
    margin: 15px 0 -5px 0;
    color: var(--text-primary, black);
}
.change-btn {
    font-family: "Lexend", sans-serif;
    background-color: #238649;
    color: white;
    border: none;
    padding: 15px 45px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s ease;
    align-self: flex-start;
    margin-top: 10px;
}
.change-btn:hover {
    background-color: #1a6b39; 
}
.profile-container { 
    margin-top: 25px; 
}
 .message-banner {
            padding: 15px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
            display: <?php echo empty($message) ? 'none' : 'block'; ?>;
        }
        .message-banner.success {
            background-color: #E2F8E9;
            color: #25D366;
            border: 1px solid #25D366;
        }
        .message-banner.error {
            background-color: #F8E2E2;
            color: #D32525;
            border: 1px solid #D32525;
        }
    </style>
</head>
<body>

    <div class="dashboard">
         <aside class="sidebar">
        <div class="sidebar-header">
            <img src="../logo/Logo black shadow.png"class="logo">
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li><a href="statistics.php"><img src="../Icons/Dashboard/increaseBlack.png"><span>Statistics</span></a></li>
                <li><a href="requests.php"><img src="../Icons/Dashboard/icons8-liste-de-tâches-100.png" alt=""><span>Requests</span></a></li>
                <li><a href="clients.php"><img src="../Icons/Dashboard/utilisateur.png" alt=""><span>Clients</span></a></li>
                <li><a href="volunteers.php"><img src="../Icons/Dashboard/icons8-bénévolat-100.png" alt=""><span>Volunteers</span></a></li>
                <li><a href="partners.php"><img src="../Icons/Dashboard/icons8-collaborating-in-circle-100.png" alt=""><span>Partners</span></a></li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <ul>
                <li class="active"><a href="settings.php"><img src="../Icons/Dashboard/icons8-paramètres-100.png" alt=""><span>Settings</span></a></li>
                <li><a href="admin_logOut.php"><img src="../Icons/Dashboard/icons8-sortie-100.png" alt=""><span>Logout</span></a></li>
            </ul>
        </div>
    </aside>

        <main class="main-content">
            <header class="content-header">
                <h1>Profile</h1>
                <hr>
            </header>

            <div class="profile-container">
                
                <div class="message-banner <?php echo $message_type; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>

                <div class="welcome-banner">
                    Howdy, <?php echo htmlspecialchars($current_admin['admin_name']); ?>!
                </div>

                <form class="profile-form" method="POST" action="settings.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="admin-name">Admin name</label>
                            <input type="text" id="admin-name" value="<?php echo htmlspecialchars($current_admin['admin_name']); ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="email-address">Email address</label>
                            <input type="email" id="email-address" value="<?php echo htmlspecialchars($current_admin['email_admin_ID']); ?>" disabled>
                        </div>
                    </div>

                    <h2 class="form-section-title">Change password</h2>
                    
                    <div class="form-group">
                        <label for="current-password">Current password</label>
                        <input type="password" id="current-password" name="current_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new-password">New password</label>
                        <input type="password" id="new-password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm password</label>
                        <input type="password" id="confirm-password" name="confirm_password" required>
                    </div>

                    <button type="submit" class="change-btn">Change</button>
                </form>
            </div>
        </main>
    </div>

</body>
</html>