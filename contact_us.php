<?php
// Start session for flash messages
session_start();

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer files
require 'PHP_mail/Exception.php';
require 'PHP_mail/PHPMailer.php';
require 'PHP_mail/SMTP.php';

// --- THIS IS THE MOST IMPORTANT FIX ---
// Only run this code if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- Sanitize and Validate Form Data ---
    $fullName = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $message_body = trim($_POST['message']); // Renamed variable to avoid conflict

    if (empty($fullName) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($message_body)) {
        // If validation fails, set an error message
        $_SESSION['flash_message'] = "Please fill out all fields correctly.";
        $_SESSION['flash_type'] = "error";
    } else {
        // --- If validation passes, create a new PHPMailer instance ---
        $mail = new PHPMailer(true);

        try {
            // --- Server settings ---
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tasnimmezgueldi@gmail.com'; // Your Gmail address
            $mail->Password   = 'vsbm eaxl tykl euqx';      // Your Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // --- Recipients ---
            $mail->setFrom('tasnimmezgueldi@gmail.com', 'BookCycle Contact Form');
            $mail->addAddress('tasnimmezgueldi@gmail.com');
            $mail->addReplyTo($email, $fullName);

            // --- Content ---
            $mail->isHTML(true);
            $mail->Subject = 'New Contact Form Submission from ' . $fullName;
            $mail->Body    = "<h3>New Message from Contact Form</h3>
                              <p><b>Name:</b> " . htmlspecialchars($fullName) . "</p>
                              <p><b>Email:</b> " . htmlspecialchars($email) . "</p>
                              <hr>
                              <p><b>Message:</b><br>" . nl2br(htmlspecialchars($message_body)) . "</p>";
            $mail->AltBody = "Name: $fullName\nEmail: $email\n\nMessage:\n$message_body";

            $mail->send();
            
            // Set success message
            $_SESSION['flash_message'] = 'Thank you! Your message has been sent.';
            $_SESSION['flash_type'] = 'success';

        } catch (Exception $e) {
            // Set error message if sending fails
            $_SESSION['flash_message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            $_SESSION['flash_type'] = 'error';
        }
    }

    // --- Redirect back to the form to show the message ---
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact us</title>
    <link rel="icon" href="logo/bookcycle.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Lexend&display=swap" rel="stylesheet">
    <style>
        body {
          font-family: 'Lexend', sans-serif;
          background-image: url(Photos/contact_us/background.jpg);
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        margin: 0;
        padding: 0;
          box-sizing: border-box;
    color: black;
        }
        .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 40px;
      }
      nav ul {
        display: flex;
        gap: 35px;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
      }
      .navItems {
        color: #238649;
        font-size: 22px;
        font-weight: bold;
        text-shadow: 0px 4px 4px rgb(255, 255, 255, 0.95);
      }
      .navItems:hover {
        color: #32eb2a;
        cursor: pointer;
      }
      .navItems button {
        background-color: #32eb2a;
        color: white;
        padding: 6px 35px;
        border-radius: 20px;
        font-size: 18px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 7px;
        border: 1px solid white;
      }
      .navItems button:hover {
        background-color: #238649;
        cursor: pointer;
      }
      a {
        text-decoration: none;
        color: inherit;
      }
      main{
        display: flex;
        flex-wrap: wrap; 
        justify-content: center;
    gap: 30px 50px;
    margin-bottom: 20px;
      }
      h1 {
    flex-basis: 100%; 
    text-align: center;
    font-size: 65px;
    font-weight: bolder;
    margin-bottom: 5px;
    margin-top: 0;
    text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.40);
}
.contactForm{
    flex-basis: 380px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.contactInfo{ 
    flex-basis: 400px;
    padding-left: 5px;
}
#fName, #email, #message {
    width: 400px;
    padding: 15px;
    margin-bottom: 20px; 
    border: 1px solid #e0e0e0;
    border-radius: 5px;
    font-family: 'Lexend', sans-serif;
    font-size: 16px;
    background-color: #f9f9f9;
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.20);
      }
      #fName::placeholder, #email::placeholder, #message::placeholder{
        color: #888;
      }
      textarea{
        height: 180px;
      }
      button{
         background-color: #238649;
    color: white;
    padding: 8px 48px;
    border: none;
    border-radius: 5px;
    font-family: 'Lexend', sans-serif;
    font-size: 18px;
    font-weight: lighter;
    cursor: pointer;
    transition: background-color 0.2s ease;
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.20);
      }
      button:hover{
         background-color: #1c6b3a;
      }
      .giveUs{
        font-size: 19px;
        text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.20);
      }
      .contact-item {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 25px;
}
.contact-item img {
    width: 30px; 
    height: 30px;

}
.contact-item h3 {
    font-size: 1.2em;
    font-weight: 600;
    color: #000000;
    margin-top: 0;
    margin-bottom: 5px;
    text-shadow: 0 1px 3px rgba(0,0,0,0.2);
}
.contact-item p {
    font-size: 1em;
    color: #555;
    margin: 0;
    line-height: 1.5;
    text-shadow: 0 1px 3px rgba(0,0,0,0.2);
}
.onMap{
    display: inline-flex;
    justify-content: center;
    gap: 8px;
    color: #238649;
    font-weight: 600;
    font-size: 19px;
    margin-top: 10px;
}
.onMap img {
    width: 22px;
    height: 22px;
    rotate: -45deg;
}
.onMap:hover{
text-decoration: underline;
text-decoration-thickness: 2px;
}
hr{
    border: 0;
    height: 4px;
    width: 395px;
    background-color: #000000;
    margin-top: 10px;
    margin-bottom: 15px;
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.20);
}
.socials{
    display: flex;
    justify-content: center;
}
.socials a img{
     width: 60px;
    height: 60px;
}

.message { padding: 1em; margin-bottom: 1em; border-radius: 5px; text-align: center; } 
.success { background-color: #d4edda; color: #155724; } 
.error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <header>
       <?php
            // Check if the user is logged in
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                // If they are logged in, show the logged-in navbar
                include 'include/navbar_logged_in.php';
            } else {
                // If they are not logged in, show the logged-out navbar
                include 'include/navbar_logged_out.php';
            }
        ?>
</header>
<main>
    <h1>How can we help?</h1>
    <div class="contactForm">
        <form action="contact_us.php" method="post">

<?php
                if (isset($_SESSION['flash_message'])) {
                    echo '<div class="message ' . $_SESSION['flash_type'] . '">' . htmlspecialchars($_SESSION['flash_message']) . '</div>';
                    unset($_SESSION['flash_message']);
                    unset($_SESSION['flash_type']);
                }
            ?>

        <label for="fName"></label>
        <input type="text" name="full_name" id="fName" placeholder="Full name" required><br>
        <label for="email"></label>
        <input type="email" name="email" id="email" placeholder="Email" required><br>
        <label for="message"></label>
        <textarea name="message" id="message" placeholder="Message"></textarea><br>
        <button type="submit">Send</button>
        </form>
    </div>
    <div class="contactInfo">
        <p class="giveUs">Give us a call or send a message <br>we will be happy to answer your questions!</p>
        <div class="contact-item">
        <img src="Icons/UI/contact_us/icons8-phone-100.png" alt="">
        <div>
        <h3>Let’s talk</h3>
        <p>+212-612345678</p>
        </div>
        </div>
        <div class="contact-item">
        <img src="Icons/UI/contact_us/icons8-nouveau-message-100.png" alt="">
        <div>
        <h3>General Support</h3>
        <p>info@bookcycle.com</p>
        </div>
        </div>
        <div class="contact-item">
        <img src="Icons/UI/contact_us/icons8-marqueur-100.png" alt="">
        <div>
        <h3>Address</h3>
        <p>Tangier, Morocco, North Africa</p>
        <a href="https://maps.app.goo.gl/PwdokiQHyGyxJBFw8" target="_blank" class="onMap">View on map <img src="Icons/UI/contact_us/icons8-right-100 (1).png" alt=""></a><br>
        </div>
    </div>
    <hr>
    <div class="socials">
        <a  href="https://www.facebook.com" target="_blank"><img src="Icons/UI/icons8-facebook-nouveau-200.png" alt="FB"></a>
        <a  href="https://www.instagram.com" target="_blank"><img src="Icons/UI/icons8-instagram-200.png" alt="IG"></a>
        <a  href="https://x.com" target="_blank"><img src="Icons/UI/icons8-x-200.png" alt="X"></a>
        <a  href="https://www.youtube.com" target="_blank"><img src="Icons/UI/icons8-youtube-200.png" alt="Ytb"></a>
    </div>
</div>
</main> 
</body>
</html>