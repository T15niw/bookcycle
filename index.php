<?php
session_start();

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

// error succ msg
$message = '';
$message_type = '';

// form submichon
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // check if user is logged in
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        
        // if not tell them to
        $message = "You must be logged in to submit a request.";
        $message_type = "error";

    } else {
        // if logged in
        // retrieve form data
        $category = $_POST['category'];
        $quantity = $_POST['quantity'];
        $pickup_address = trim($_POST['pickup_address']);
        $pickup_date = $_POST['pickup_date'];
        $additional_notes = trim($_POST['additional_notes']);
        
        $client_email = $_SESSION['email'];

        try {
            $sql = "INSERT INTO request_form (
                        email_client_ID, 
                        submission_date, 
                        category, 
                        quantity, 
                        pickup_address, 
                        pickup_date, 
                        additional_remarks, 
                        status, 
                        books_price
                    ) VALUES (
                        :email_client_id, 
                        NOW(), 
                        :category, 
                        :quantity, 
                        :pickup_address, 
                        :pickup_date, 
                        :additional_remarks, 
                        'processing', 
                        0.00
                    )";
            
            $stmt = $conn->prepare($sql);
            
            // Bind the parameters
            $stmt->bindParam(':email_client_id', $client_email);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':quantity', $quantity);
            $stmt->bindParam(':pickup_address', $pickup_address);
            $stmt->bindParam(':pickup_date', $pickup_date);
            $stmt->bindParam(':additional_remarks', $additional_notes);
            
            // Execute the query
            $stmt->execute();
            
            // success message
            $message = "Your request was submitted successfully!";
            $message_type = "success";

        } catch (PDOException $e) {
            // database errors
            $message = "An error occurred while saving your request. Please try again.";
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
    <title>Homepage</title>
    <link rel="icon" href="logo/bookcycle.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Lexend&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="import" href="font/Lexend-Black.ttf"><link rel="import" href="font/Lexend-Bold.ttf"><link rel="import" href="font/Lexend-ExtraBold.ttf"><link rel="import" href="font/Lexend-Medium.ttf"><link rel="import" href="font/Lexend-SemiBold.ttf"><link rel="import" href="font/Lexend-Regular.ttf"><link rel="import" href="font/Lexend-Light.ttf">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Lexend:wght@100..900&display=swap');
        body {
          font-family: 'Lexend', sans-serif;
          background-color: #238649;
          margin: 0;
          padding: 0;
        }
        /*********************Navbar********************************/
         .navbar {
        background-image: url('Photos/Homepage/background.jpeg');
        background-size: cover;
        background-position: center; 
        box-sizing: border-box;
      }
     
      /*************************HeroSection***************************/
      .hero{
            display: flex;
            justify-content: space-around;
      }
        .heroSection h1{
        text-align: left;
        font-size: 75px;
        font-weight: 800;
        margin-top: 100px;
        margin-left: 25px;
        background: url(Photos/Homepage/background.jpeg);
        background-size: cover;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        }
        .heroSection p{
            width: 800px;
            height: 80px;
            text-align: center;
            color: white;
            font-size: 30px;
            font-weight: 300;
            text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.10);
            margin-left: 250px;
            margin-bottom:20px
        }
        .heroSection button{
            display: flex;
            width: 400px;
            height: 80px;
            padding: 22px 60px;
            align-self: center;
            justify-content: center;
            border-radius: 50px 50px 8px 8px;
            border: none;
            background: #32EB2A;
            color: white;
            text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.15);
            font-family: 'Lexend', sans-serif;
            font-size: 25px;
            font-weight: bold;
            margin-left: 450px;
            margin-bottom: 40px;
        }
        .heroSection button:hover{
            cursor: pointer;
            background-color: #23a31e;
        }
        /***********************Process*****************************/
        .process {
            background-image: url('Photos/Homepage/background.jpeg');
            background-size: cover;
            background-position: center;
            padding: 80px 20px;
            text-align: center;
        }
        .process h2 {
            font-family: "Lexend", sans-serif;
            font-size: 70px;
            font-weight: 800;
            color: #238649;
            margin: 0;
        }
        .process > h3 {
            font-family: "Caveat", cursive;
            font-size: 50px;
            font-weight: 400;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
            margin-top: 10px;
            margin-bottom: 35px;
        }
        .etapes {
            display: flex;
            justify-content: center;
            align-items: stretch;
            gap: 30px;
        }
        .step {
            background-color: #238649;
            color: white;
            padding: 20px 15px 35px 15px;
            border-radius: 25px;
            min-width: 230px;
            max-width: 260px;
            display: flex;
            flex-direction: column;
            align-items: center; 
        }
        .step h3 {
            font-family: 'Caveat', cursive;
            font-size: 35px;
            font-weight: 500;
            line-height: 1.2;
            margin-top: 15px;
            margin-bottom: 15px;
        }
        .step p {
            font-size: 20px;
            font-weight: 300;
            line-height: 1.3;
            margin-top: 20px;
        }
        /***********************Request form*****************************/
        #request_form {
        display: flex;
        align-items: center;
        background-color: #238649;
        color: white;
        font-family: 'Lexend', sans-serif; ;
        overflow: hidden;
        }
        .formTxts{
            flex: 1.2;
            padding: 60px 5%;
        }
        .booksImg {
            flex: 0.8;
            align-self: stretch; 
        }
        .booksImg img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            display: block;
        }
        #request_form h1 {
            font-size: 65px;
            font-weight: 800;
            margin-bottom: 20px;
            margin-top: 0;
            padding-top: 0;
            background: url(Photos/Homepage/background.jpeg);
            background-size: cover;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        #request_form h5 {
            font-size: 24px;
            font-weight: 200;
            margin-top: 0;
            margin-bottom: 15px;
            color: white;
        }
        #request_form input,
        #request_form select,
        #request_form textarea {
            width: 100%;
            padding: 16px 45px;
            margin-bottom: 15px;
            border: none;
            border-radius: 8px;
            background-color: #fff;
            font-size: 20px;
            font-weight: 250;
            font-family: 'Lexend', sans-serif;
            color:  rgba(0, 0, 0, 0.50);;
            box-sizing: border-box;
        }
        #request_form input::placeholder,
        #request_form textarea::placeholder {
            color: #9E9E9E;
            opacity: 1;
        }
        #request_form select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23555' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 45px center;
        }
        #request_form textarea {
            min-height: 150px;
            resize: vertical;
        }
        #request_form button {
            background-color: #32EB2A; 
            color: white;
            border: none;
            border-radius: 8px;
            padding: 14px 64px;
            font-size: 24px;
            font-weight: 600;
            font-family: 'Lexend', sans-serif ;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            display: inline-block;
            width: 215;
            align-self: center;
        }
        #request_form button[type="submit"]:hover {
            background-color: #2dbb2d;
        }
        /************************Footer*******************************/
        footer {
            background-image: url('photos/Homepage/background.jpeg');
            background-size: cover;
            background-position: center;
            padding: 10px 40px 5px 80px; 
            font-family: 'Lexend', sans-serif;
            font-size: 20px;
        }
        .footerDivs{
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 80px;
            margin-bottom: 35px;
        }
        .usefuLinks, .customerService {
            flex-basis: 30%; 
        }
        .usefuLinks a, .customerService a{
            line-height: 2.2;
        }
        .logo { 
            flex-basis: 38%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left; 
            margin-top: 80px;
            font-size: 10px;
        }
        .logo a img{
            width: 350px;
            margin-bottom: 0;
        }
        .logo a p{
            margin-top: 0;
            font-size: 15;
        }
        footer h3 {
            color: #238649; 
            font-size: 30px;
            font-weight: 700;
            border-bottom: 3px solid #238649;
            padding-bottom: 5px;
            margin-bottom: 18px;
            display: inline-block;
            text-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        footer a {
            color: black;
            text-decoration: none;
            font-size: 25px;
            font-weight: 300;
            text-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        footer a:hover {
            text-decoration: underline;
        }
        .follow{
            border-bottom: none;
            margin-top: 3px;
            margin-bottom: 0;
            text-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }
        .icon{
            width: 55px;
            height: 55px;
        }
        .copyRights{
            text-align: center;
            font-weight: 300;
        }

        .message { padding: 15px; margin-bottom: 20px; border-radius: 4px; text-align: center; }
        .success { background-color: #d4edda; color: #155724; }
        .error { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
<header>
    <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                // if they are show logged-in navbar
                include 'include/navbar_logged_in.php';
            } else {
                // if not show logged-out navbar
                include 'include/navbar_logged_out.php';
            }
        ?>
</header>
<main>
    <section class="heroSection">
        <div class="hero">
        <div><h1>Recycle Books. <br>Save Trees. <br>Love the Earth!</h1></div>
        <div><img src="Photos/Homepage/hero section.png" alt=""></div>
    </div>
    <div class="section">
    <p>Not sure what to do with your old school books?<br>We’ve got you covered!</p>
    <a href="#request_form" ><button type="button" >Request a Pickup</button></a>
    </div>
    </section>
    <section class="process">
        <h2>How it works</h2>
        <h3>Turn your old and used Books into Cash!</h3>
        <div class="etapes">
        <div class="step">
            <img src="Icons/UI/homepage/icons8-envoyer-un-document-100.png" alt="">
            <h3>1 Submit Form</h3><br><br>
            <p>Fill out our form and let us know what you have.</p>
        </div>
        <div class="step">
            <img src="Icons/UI/homepage/icons8-camion-100.png" alt="">
            <h3>2 We Pick Them <br> Up</h3>
            <p>Our team schedules a pickup and collects your books at your convenience.</p>
        </div>
        <div class="step">
            <img src="Icons/UI/homepage/icons8-pas-cher-2-100.png" alt="">
            <h3>3 We Weigh <br>& Price Your Books</h3>
            <p>More Kilos, More Cash! <br>Fewer Books? We Buy Individually.</p>
        </div>
        <div class="step">
            <img src="Icons/UI/homepage/icons8-recycle-100.png" alt="">
            <h3>4 Books Get <br> a New Life</h3>
            <p>Usable books are resold at low prices to libraries, and damaged ones are sent for recycling.</p>
        </div>
    </div>
    </section>
    <section id="request_form">
        <div class="formTxts">
        <h1>Let’s do business!</h1>
        <h5>About Your Books</h5>
        <form action="#request_form" method="post">

        <?php if (!empty($message)): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

            <label for="category"></label>
            <select name="category" id="category" required>
                <option value="" disabled selected>Category</option>
                <option value="books">Books</option>
                <option value="notebooks">Notebooks</option>
                <option value="both">Both</option>
            </select><br>
            <label for="quantity"></label>
            <select name="quantity" id="quantity" required>
                <option value="" disabled selected>Quantity</option>
                <option value="5 - 10 book">5 - 10 book</option>
                <option value="10 - 50 book">10 - 50 book</option>
                <option value="50+ book">50+ book</option>
            </select><br>
            <label for="address"></label>
            <input type="text" name="pickup_address" id="address" placeholder="Pickup Address" required><br>
            <label for="date"></label>
            <input type="date" name="pickup_date" id="date" placeholder="Pickup Date" required><br>
            <label for="addNotes"></label>
            <textarea name="additional_notes" id="addNotes" placeholder="Additional Notes"></textarea><br>
            <button type="submit">Submit</button>
            </form>
        </div>
        <div class="booksImg"> 
            <img src="Photos/Homepage/request form.png" alt="">
        </div>
    </section>
</main>
<footer>
    <div class="footerDivs">
    <div class="usefuLinks">
    <h3>Useful links</h3> <br>
        <a href="about_us.php" class="usefuLinks">About us</a><br>
        <a href="colaborate_with_us.php" class="usefuLinks">Collaborate with us</a><br>
        <a href="" class="usefuLinks">Privacy policy</a><br>
        <a href="" class="usefuLinks"> Terms & Conditions</a><br>
    </div>
    <div class="customerService">
        <h3>Customer Service</h3> <br>
        <a href="contact_us.php">Contact Us</a><br>
        <a href="colaborate_with_us.php">FAQ</a><br>
        <h3 class="follow">Follow us</h3><br>
        <a  href="https://www.facebook.com" target="_blank"><img src="Icons/UI/icons8-facebook-nouveau-200.png" alt="FB" class="icon"></a>
        <a  href="https://www.instagram.com" target="_blank"><img src="Icons/UI/icons8-instagram-200.png" alt="IG" class="icon"></a>
        <a  href="https://x.com" target="_blank"><img src="Icons/UI/icons8-x-200.png" alt="X" class="icon"></a>
        <a  href="https://www.youtube.com" target="_blank"><img src="Icons/UI/icons8-youtube-200.png" alt="Ytb" class="icon"></a>
    </div>
    <div class="logo">
        <a href="index.php"><img src="logo/footer.png" alt=""></a>
        <a href="https://maps.app.goo.gl/ZkFxrk1bbLt5jyUe8" target="_blank"><p>Solicode, Hawma Seddam <br>Tangier,<br> Morocco, North Africa</p></a>
    </div>
</div>
    <p class="copyRights">CopyRights © 2025 BookCycle. All rights reserved <br><span style="font-weight: 900;">Tasnim Mezgueldi</span></p>
</footer>
</body>
</html>