<?php
session_start();

// database connection
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

$errorMessage = '';

// Form processing
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // get email and password from the form
    $email = trim($_POST['email']);
    $pass = $_POST['password'];

    // validation to ensure fields are not empty
    if (empty($email) || empty($pass)) {
        $errorMessage = 'Please enter both email and password.';
    } else {
        try {
            // SQL statement to find the user by email
            $sql = "SELECT email_client_ID, password, first_name FROM client WHERE email_client_ID = :email";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            // see if one user exactly was found
            if ($stmt->rowCount() == 1) {
                // Fetch the user's data
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // verify if the two passwords are matching (entered, DB)
                if (password_verify($pass, $user['password'])) {
                    
                    // Regenerate session ID for security
                    session_regenerate_id(true);

                    // Store user data in the session to mark them as logged in
                    $_SESSION['loggedin'] = true;
                    $_SESSION['email'] = $user['email_client_ID'];
                    $_SESSION['name'] = $user['first_name']; 

                    // Redirect to the homepage
                    header("Location: index.php");
                    exit();

                } else {
                    $errorMessage = 'Password incorrect.';
                }
            } else {
                // no user was found with that email address
                $errorMessage = 'Invalid email or password.';
            }

        } catch (PDOException $e) {
            $errorMessage = 'A database error occurred. Please try again later.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log In</title>
    <link rel="icon" href="logo/bookcycle.png" type="image/x-icon" />
    <link
      href="https://fonts.googleapis.com/css2?family=Lexend&display=swap"
      rel="stylesheet"
    />
    <style>
      *,
      *::before,
      *::after {
        box-sizing: border-box;
      }
      body {
        font-family: "Lexend", sans-serif;
        background-image: url(Photos/logIn_signUp/background.jpg);
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0;
        padding: 0;
      }
      body::before {
        content: ""; 
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: 0; 
      }
      main {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        position: relative; 
        z-index: 1; 
      }
      .logo {
        position: fixed;
        top: 29px;
        left: 46px;
        z-index: 2; 
      }
      .logInCard {
        background-color: #ffffff;
        padding: 50px 68px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
        text-align: left;
        width: 525px;
      }
      .backToHome {
        display: flex;
        align-items: center;
        text-decoration: none;
        color: #238649;
        font-size: 28px;
      }
      .leftArrow {
        width: 29px;
        height: 29px;
        margin-right: 12px;
      }
      h1 {
        color: black;
        font-size: 30px;
        margin-top: 50px;
        margin-bottom: 18px;
        font-weight: bold;
      }
      h3 {
        color: #6c757d;
        font-size: 25px;
        font-weight: normal;
        width: 407px;
        margin-top: 0;
        margin-bottom: 25px;
      }
      form {
        display: flex;
        flex-direction: column;
      }
      #email,
      #PW {
        width: 100%;
        height: 65px;
        padding: 14px 18px;
        margin-bottom: 5px;
        border: 1px solid #6c757d;
        border-radius: 5px;
        font-size: 20px;
      }
      #email:focus,
      #PW:focus {
        outline: none;
        border-color: #1c6b3a;
        box-shadow: 0 0 0 3px rgba(35, 134, 73, 0.2);
      }
      #email::placeholder,
      #PW::placeholder {
        color: #838383;
      }
      button {
        background-color: #238649;
        color: white;
        border: none;
        padding: 13px;
        border-radius: 8px;
        font-size: 20px;
        font-family: "Lexend", sans-serif;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
      }
      button:hover {
        background-color: #1c6b3a;
      }
      .forgotPW {
        display: block;
        color: #238649;
        text-decoration: none;
        font-size: 20px;
        margin-bottom: 5px;
        text-align: right;
        font-weight: bold;
      }
      p {
        text-align: center;
        color: #6c757d;
        font-size: 19px;
        margin-top: 8px;
        margin-bottom: 19px;
      }
      .signUp {
        display: block;
        margin-top: 9px;
        color: #238649;
        font-weight: bold;
        text-decoration: none;
        font-size: 24px;
      }
      .signUp:hover {
        text-decoration: underline;
      }
      .error-message {
            color: #D8000C;
            background-color: #FFD2D2;
            border: 1px solid #D8000C;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
  </head>
  <body>
    <main>
      <div>
        <a href="index.php" class="logo"
          ><img src="logo/logo_white Shadow.png" alt=""
        /></a>
      </div>
      <div class="logInCard">
        <a href="index.php" class="backToHome"
          ><img
            src="Icons/UI/logIn_signUp/icons8-vers-l'avant-100.png"
            class="leftArrow"
          />BACK TO HOME</a
        >
        <h1>LOG IN</h1>
        <h3>One click. One book. Big impact.</h3>
        <form action="logIn.php" method="post">
        
        <!-- error message -->
        <?php if (!empty($errorMessage)): ?>
            <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>

        <label for="email"></label>
        <input
            type="email"
            name="email"  
            id="email"
            placeholder="Email Address"
            required
        /><br />

        <label for="PW"></label>
        <input
            type="password"
            name="password" 
            id="PW"
            placeholder="Password"
            required
        /><br />

        <a href="#" class="forgotPW">Forgot Password?</a><br />
        <button type="submit">Log In</button><br />
    </form>
        <p>
          Don’t have an account? <br />
          <a href="signUp.php" class="signUp">SIGN UP HERE</a>
        </p>
      </div>
    </main>
  </body>
</html>
