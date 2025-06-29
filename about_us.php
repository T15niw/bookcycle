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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About us</title>
    <link rel="icon" href="logo/bookcycle.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Lexend&display=swap" rel="stylesheet">
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Lexend:wght@100..900&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
      body {
        font-family: "Lexend", sans-serif;
        background-color: #238649;
      }
/************************************************************/
        header {
        background-image: url(Photos/about_us/background.jpeg);
        background-size: cover;
        background-position: center;
      }
/**************************HeroSection*****************************/
    .heroSection {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 88vh;
        padding: 50px 5px;
        overflow: hidden;
        font-family: 'Lexend', sans-serif;
    }
    .heroSection h1 {
        font-size: 80px;
        font-weight: 900;
        color: black;
        line-height: 1.6;
        margin: 0;
        text-shadow: 3px 3px 8px rgba(0, 0, 0, 0.3); 
        width: 100%;
    }
    .old {
        text-align: right;
        padding-right: 25px;
    }
    .new {
        text-align: left;
        padding-left: 25px;
    }
/************************OurMission*********************************/
    .ourMission {
        background-color: #238649;
        padding: 65px 70px;
        display: flex;
        align-items: center;
        gap: 80px; 
        font-family: 'Lexend', sans-serif;
    }
    .ourMission .ourMissionTitle {
        flex: 1;
        min-width: 500px;
        height: 360px;
        background-image: url('Photos/about_us/our\ mission.jpg');
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    .ourMission .ourMissionTitle::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.2);
        z-index: 1;
    }
    .ourMission h2 {
        color: #fff;
        font-size: 65px;
        font-weight: 800;
        line-height: 1.1;
        text-align: center;
        margin: 0;
        position: relative;
        z-index: 2;
    }
    .ourMissionPara {
        flex: 1;
        min-width: 450px;
    }
    .ourMission p {
        color: white;
        font-size: 31px;
        font-weight: 300;
        margin: 0;
        text-align: center;
    }
/**********************OurValues************************************/
    .ourValues {
        background-image: url('photos/about_us/background.jpeg');
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        gap: 40px;
        padding: 65px 70px;
        font-family: 'Lexend', sans-serif;
    }
    .ourValues .values_div {
        flex: 1.2;
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    .value {
        display: flex;
        align-items: flex-start; 
        gap: 18px;
    }
    .value img {
        width: 60px;
        height: auto;
        flex-shrink: 0;
    }
    .value h3 {
        font-size: 32px; 
        font-weight: 600;
        color: black;
        margin: 0 0 8px 0;
    }
    .value p {
        font-size: 22px; 
        font-weight: 400;
        color: black;
        line-height: 1.4; 
        margin: 0;
    }
    .ourValues .ourValuesTitle {
        flex: 0.8;
        height: 500px;
        background-image: url('Photos/about_us/our values.png');
        background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    .ourValues .ourValuesTitle h2 {
        color: black;
        font-size: 60px;
        font-weight: 900;
        text-shadow: 0px 4px 4px rgba(255, 255, 255, 0.50);
        margin-top: 0;
        text-align: center;
    }
/*****************************OurVision*****************************/
    .ourVision {
        background-color: #238649;
        padding: 65px 70px;
        display: flex;
        align-items: center;
        gap: 80px; 
        font-family: 'Lexend', sans-serif;
    }
    .ourVision .ourVisionTitle {
        flex: 1;
        min-width: 500px;
        height: 360px;
        background-image: url('Photos/about_us/our\ vision.jpeg');
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    .ourVision .ourVisionTitle::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.2);
        z-index: 1;
    }
    .ourVision h2 {
        color: #fff;
        font-size: 65px;
        font-weight: 800;
        line-height: 1.1;
        text-align: center;
        margin: 0;
        position: relative;
        z-index: 2;
    }
    .ourVisionPara {
        flex: 1;
        min-width: 450px;
    }
    .ourVision p {
        color: white;
        font-size: 32px;
        font-weight: 300;
        margin: 0;
        text-align: center;
    }
/************************WhyItMatters*********************************/
    .whyItMatters {
        background-image: url('Photos/about_us/background.jpeg');
        background-size: cover;
        background-position: center;
        padding: 70px 80px;
        font-family: 'Lexend', sans-serif;
    }
    .whyItMatters h2 {
        text-align: center;
        font-size: 65px;
        font-weight: 800;
        color: black;
        margin-bottom: 50px;
        margin-top: 0;
        text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.3);
    }
    .why {
        display: flex;
        align-items: center;
        gap: 60px;
    }
    .paragra {
        flex: 2;
        min-width: 800px;
    }
    .paragra p {
        font-size: 28px;
        font-weight: 300;
        color: black;
        line-height: 35px;
        margin: 0;
        text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.30);
    }
    .elachMattersParagra {
    color: #000;
    font-size: 33px;
    font-weight: 700;
    }
    .globe img {
        max-width: 350px;
        height: auto; 
    }
/*************************meet tha team*******************************/
    .team {
        padding: 80px 20px;
        text-align: center;
    }
    .team h2 {
        font-family: 'Lexend', sans-serif;
        font-size: 65px;
        font-weight: 800;
        color: white;
        margin-bottom: 60px;
    }
    .teamPics {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        gap: 100px;
    }
    .member {
        max-width: 200px;
    }
    .teamPics img {
        width: 190px;
        height: 190px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 22px;
    }
    .teamPics p {
        font-family: 'Caveat', cursive;
        font-size: 50px;
        font-weight: 700;
        color: white;
        margin: 0;
    }
/***************************Footer*****************************/
        footer {
            background-image: url('Photos/about_us/background.jpeg');
            background-size: cover;
            background-position: center;
            padding: 35px 40px 5px 80px; 
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
            margin-top: 60px;
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
            font-weight: bold;
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
        }
    </style>
</head>
<body>
    <header>
        <?php
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                // if logged in, show logged-in navbar
                include 'include/navbar_logged_in.php';
            } else {
                // if not, show logged-out navbar
                include 'include/navbar_logged_out.php';
            }
        ?>

        <!-- hero secchon -->
<section class="heroSection">
        <h1 class="old">Turning Old Pages</h1>
        <h1 class="new">Into New Opportunities</h1>
        </section>
    </header>
    <main>

    <!-- our michon-->
    <section class="ourMission">
        <div class="ourMissionTitle">
            <h2>Our <br> Mission</h2>
        </div>
        <div class="ourMissionPara">
            <p>Every year, tons of school books go to waste. At BookCycle, we give them a second life. <br>By reusing and recycling school books, we reduce paper waste, and protect our planet, one book at a time.</p>
        </div>
    </section>

    <!-- our values-->
   <section class="ourValues">
    <div class="values_div">
        <div class="value">
            <img src="Icons/UI/about_us/icons8-protection-de-l'environnement-100.png" alt="Sustainability Icon">
            <div class="value-text">
                <h3>Sustainability</h3>
                <p>We protect the planet by reducing paper waste while promoting recycling.</p>
            </div>
        </div>
        <div class="value">
            <img src="Icons/UI/about_us/icons8-poignée-de-main-100.png" alt="Integrity Icon">
            <div class="value-text">
                <h3>Integrity</h3>
                <p>We operate with honesty and transparency at every step.</p>
            </div>
        </div>
        <div class="value">
            <img src="Icons/UI/about_us/icons8-coup-de-poing-avant-100.png" alt="Empowerment Icon">
            <div class="value-text">
                <h3>Empowerment</h3>
                <p>We encourage everyone to make a difference by donating, volunteering, or partnering with us.</p>
            </div>
        </div>
    </div>
    <div class="ourValuesTitle">
        <h2>Our <br> Values</h2>
    </div>
</section>
        <!-- our vijon -->
    <section class="ourVision">
        <div class="ourVisionTitle">
            <h2>Our <br> vision</h2>
        </div>
        <div class="ourVisionPara">
            <p>We aim to promote eco-friendly habits, building a circular economy for books, where every book finds a second life whether in a student's hands or as recycled material for new creations.</p>
        </div>
    </section>

    <!-- 3lach it matters -->
    <section class="whyItMatters">
        <h2>Why it Matters</h2>
        <div class="why">
        <div class="paragra">
            <p>Paper that ends up in landfills instead of being reused or recycled, leads to <span class=" elachMattersParagra">unnecessary waste, pollution,</span> and <span class=" elachMattersParagra">resource depletion.</span> <br><br><span class=" elachMattersParagra">Paper waste</span> contributes significantly to <span class=" elachMattersParagra">deforestation</span> and <span class=" elachMattersParagra">energy consumption.</span> In fact, producing <span class=" elachMattersParagra">one ton of paper</span> requires around <span class=" elachMattersParagra">17 trees</span> and over <span class=" elachMattersParagra">26,000 liters of water.</span> <br><br><span class=" elachMattersParagra">Your small action can make a big difference. <br>Together, we can build a more sustainable and conscious community.</span></p>
        </div>
        <div class="globe">
            <img src="Photos/about_us/why it matters.png" alt="">
        </div>
        </div>
    </section>
    <!-- team dyalna -->
    <section class="team">
        <h2>Meet the team</h2>
        <div class="teamPics"> 
        <div class="member">
            <img src="Photos/about_us/team member 1.png" alt="">
            <p>Véronique</p>
        </div>
        <div class="member">
            <img src="Photos/about_us/team member 2.jpg" alt="">
            <p>Tasnim</p>
        </div>
        <div class="member">
            <img src="Photos/about_us/team member 3.png" alt="">
            <p>Narjis</p>
        </div>
        <div class="member">
            <img src="Photos/about_us/team member 4 .png" alt="">
            <p>Mohamed</p>
        </div>
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
    <p class="copyRights">CopyRights © 2025 BookCycle. All rights reserved <br><b>Tasnim Mezgueldi</b></p>
</footer>
</body>
</html>