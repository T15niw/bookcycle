<?php
session_start();

//db connection
$host = 'localhost';
$dbname = 'bookcycle';
$user = 'root';
$password = ''; 

$message = ''; // success or error messages
$message_type = ''; // variable to hold the class for styling the message 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// signUp form
// check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // store form data in appropriate vars
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone_number']);
    $contactMethod = $_POST['contact_method'];
    $city = trim($_POST['city']);
    $pass = $_POST['password'];
    $confirmPass = $_POST['confirm_password'];

    // validate Passwords
    if ($pass !== $confirmPass) {
        $message = "Passwords do not match. Please try again.";
        $message_type = "error";
    } else {
        
        try {
            // check if the email already exists
            $checkSql = "SELECT email_client_ID FROM client WHERE email_client_ID = :email";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bindParam(':email', $email);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                // email already exists
                $message = "An account with this email address already exists.";
                $message_type = "error";
            } else {
                // no email was found then hash pw and store
                $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

                $sql = "INSERT INTO client (email_client_ID, first_name, last_name, phone_number, preferred_contact_method, city, password) 
                        VALUES (:email, :first_name, :last_name, :phone_number, :contact_method, :city, :password)";

                $stmt = $conn->prepare($sql);

                // Bind parameters
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':first_name', $firstName);
                $stmt->bindParam(':last_name', $lastName);
                $stmt->bindParam(':phone_number', $phone);
                $stmt->bindParam(':contact_method', $contactMethod);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':password', $hashedPassword);

                // execute the statement
                $stmt->execute();
                
                // success message
                $message = "Sign up successful! Welcome to BookCycle.";
                $message_type = "success";
            }
        } catch (PDOException $e) {
            // database errors 
            $message = "An unexpected error occurred. Please try again later.";
            $message_type = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" href="logo/bookcycle.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Lexend&display=swap" rel="stylesheet">
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
        position: relative;
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
      .signUpCard {
        background-color: #ffffff;
        padding: 50px 42px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
        text-align: left;
        width: 680px;
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
        font-size: 25px;
        margin-top: 50px;
        margin-bottom: 18px;
        font-weight: bold;
      }
      form {
        display: flex;
        flex-direction: column;
        justify-content: center;
      }
      .form_row{
        display: flex;
        flex-direction: row;
        gap: 12px;
      }
      #stName, #ndName, #email, #telNum, #preConMethod, #city,
      #PW, #confirmPW {
        width: 100%;
        height: auto;
        padding: 20px 18px;
        margin-bottom: 18px;
        border: 1px solid #6c757d;
        border-radius: 5px;
        font-size: 20px;
      }
      #stName:focus, #ndName:focus, #email:focus, #telNum:focus, #preConMethod:focus, #city:focus,
      #PW:focus, #confirmPW:focus{
        outline: none;
        border-color: #1c6b3a;
        box-shadow: 0 0 0 3px rgba(35, 134, 73, 0.2);
      }
      #stName::placeholder, #ndName::placeholder, #email::placeholder, #telNum::placeholder,
     #city::placeholder, #PW::placeholder, #confirmPW::placeholder {
        color: #838383;
      }
      button {
        background-color: #238649;
        color: white;
        border: none;
        padding: 13px;
        margin-top: 25px;
        border-radius: 8px;
        font-size: 20px;
        font-family: "Lexend", sans-serif;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
        width: fit-content;
        align-self: center; 
      }
      button:hover {
        background-color: #1c6b3a;
      }
      span{
        color: #238649;
        font-weight: bold;
        cursor: pointer;
      }
      p {
        text-align: center;
        color: #6c757d;
        font-size: 19px;
        margin-top: 2px;
      }
      .logIn {
        display: block;
        margin-top: 9px;
        color: #238649;
        font-weight: bold;
        text-decoration: none;
        font-size: 24px;
      }
      .logIn:hover {
        text-decoration: underline;
      }

      .message {
          padding: 15px;
          margin-bottom: 20px;
          border-radius: 5px;
          font-family: sans-serif;
          font-size: 1em;
          text-align: center;
      }
      .error {
          color: #D8000C;
          background-color: #FFD2D2;
          border: 1px solid #D8000C;
      }
      .success {
          color: #270;
          background-color: #DFF2BF;
          border: 1px solid #270;
      }
    </style>
</head>
<body>
    <main>
        <div><a href="index.php" class="logo"><img src="logo/logo_white Shadow.png" alt=""></a></div>
        <div class="signUpCard">
         <a href="index.php" class="backToHome"><img src="Icons/UI/logIn_signUp/icons8-vers-l'avant-100.png" class="leftArrow">BACK TO HOME</a>
         <h1>SIGN UP AND START MAKING AN IMPACT</h1>
         <form action="signUp.php" method="post">
    
        <?php if (!empty($message)): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="form_row">
            <label for="firstName"></label>
            <input type="text" name="first_name" id="stName" placeholder="First name" required>
            <label for="lastName"></label>
            <input type="text" name="last_name" id="ndName" placeholder="Last name" required>
        </div>
        <div class="form_row">
            <label for="email"></label>
            <input type="email" name="email" id="email" placeholder="Email Address" required>
            <label for="telNum"></label>
            <input type="tel" name="phone_number" id="telNum" placeholder="Phone Number" required>
        </div>
        <div class="form_row">
            <label for="preConMethod"></label>
            <select name="contact_method" id="preConMethod" required>
                <option value="" disabled selected>Preferred Contact Method</option>
                <option value="calls">Calls</option>
                <option value="whatsApp">WhatsApp</option>
                <option value="emails">Emails</option>
            </select>
            <label for="city"></label>
            <input type="text" name="city" id="city" placeholder="City" required>
        </div>
        <div class="form_row">
            <label for="PW"></label>
            <input type="password" name="password" id="PW" placeholder="Password" required>
            <label for="confirmPW"></label>
            <input type="password" name="confirm_password" id="confirmPW" placeholder="Confirm Password" required>
        </div>
        <div class="form_row">
            <input type="checkbox" name="privacyPolicy" id="privacyPolicy" required>
            <label for="privacyPolicy" class="privacyPolicy">I have read and agreed to the <span>terms</span> and <span>privacy policy</span>.</label>
        </div>
        <button type="submit">Sign Up</button><br>
    </form>
         <p>Already have an account?<br>
         <a href="logIn.php" class="logIn">LOG IN NOW</a></p>
        </div>
     </main>
</body>
</html>