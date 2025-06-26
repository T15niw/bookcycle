<?php
// Start the session at the very top. This is required for flash messages.
session_start();

// --- DATABASE CONNECTION ---
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

// --- HANDLE FORM SUBMISSION ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- 1. HANDLE FILE UPLOAD ---
    $uploaded_file_path = NULL; 
    $file_upload_error = false;

    if (isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] == 0) {
        $upload_dir = 'collaborate_form_uploaded_files/'; // Make sure this folder exists
        $unique_name = uniqid() . '-' . basename($_FILES['uploaded_file']['name']);
        $target_file = $upload_dir . $unique_name;
        
        if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_file)) {
            $uploaded_file_path = $target_file;
        } else {
            $_SESSION['flash_message'] = "Sorry, there was an error uploading your file.";
            $_SESSION['flash_type'] = "error";
            $file_upload_error = true;
        }
    }

    // --- 2. PROCESS THE REST OF THE FORM (if no file upload error) ---
    if (!$file_upload_error) {
        
        // Get all the form data
        $collaboration_type = $_POST['collaboration_type'];
        $full_name = trim($_POST['full_name']);
        $phone_number = trim($_POST['phone_number']);
        $email = trim($_POST['email']);
        $contact_method = $_POST['contact_method'];
        $city = trim($_POST['city']);
        $user_message = trim($_POST['message']);

        try {
            // --- 3. CHOOSE THE SQL BASED ON COLLABORATION TYPE ---
            if ($collaboration_type === 'volunteering') {
                $sql = "INSERT INTO volunteers (email_volunteer_ID, full_name, phone_number, preferred_contact_method, city, type_of_collaboration, desired_role, how_often_can_you_volunteer, uploaded_file, message) 
                        VALUES (:email, :name, :phone, :contact, :city, :collab_type, :role, :availability, :file, :msg)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':role', $_POST['desired_role']);
                $stmt->bindParam(':availability', $_POST['availability']);

            } elseif ($collaboration_type === 'partnership') {
                $sql = "INSERT INTO partners (email_partner_ID, full_name, phone_number, preferred_contact_method, city, type_of_collaboration, company_name, field_of_activity, uploaded_file, message) 
                        VALUES (:email, :name, :phone, :contact, :city, :collab_type, :company, :activity, :file, :msg)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':company', $_POST['company_name']);
                $stmt->bindParam(':activity', $_POST['field_of_activity']);
            }

            // --- 4. BIND COMMON FIELDS AND EXECUTE ---
            if (isset($stmt)) {
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':name', $full_name);
                $stmt->bindParam(':phone', $phone_number);
                $stmt->bindParam(':contact', $contact_method);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':collab_type', $collaboration_type);
                $stmt->bindParam(':file', $uploaded_file_path);
                $stmt->bindParam(':msg', $user_message);
                
                $stmt->execute();
                
                // Set the SUCCESS flash message
                $_SESSION['flash_message'] = "Thank you! Your submission has been received. We'll make sure to contact you as soon as possible!";
                $_SESSION['flash_type'] = "success";
            } else {
                 // Set an ERROR flash message if type is invalid
                 $_SESSION['flash_message'] = "An invalid collaboration type was selected.";
                 $_SESSION['flash_type'] = "error";
            }

        } catch (PDOException $e) {
            // Set the DATABASE ERROR flash message (e.g., duplicate email)
            $_SESSION['flash_message'] = "A submission with this email address already exists.";
            $_SESSION['flash_type'] = "error";
            // For debugging: error_log($e->getMessage());
        }
    }
    
    // --- 5. REDIRECT BACK TO THE FORM TO SHOW THE MESSAGE ---
    // This runs after every form submission, success or error.
    header('Location: ' . $_SERVER['PHP_SELF'] . '#form');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Collaborate with us</title>
    <link rel="icon" href="logo/bookcycle.png" type="image/x-icon" />
    <link
      href="https://fonts.googleapis.com/css2?family=Lexend&display=swap"
      rel="stylesheet"
    />
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
        background-image: url(Photos/collaborate_with_us/background.jpg);
        background-size: cover;
        background-position: center;
      }
      
      /************************************************************/
      .heroSection {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
        padding: 80px 0px 0px 85px;
        position: relative;
        overflow: hidden;
      }
      .heroSection h1 {
        font-size: 65px;
        font-weight: 900;
        color: black;
        text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.30);
        margin-bottom: 38px;
        width: 100%;
      }
      .heroSection p {
        font-size: 35px;
        font-weight: 300;
        color: black;
        text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.30);
        margin-bottom: 40px;
        width: 880px;
      }
      .heroSection img {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 730px;
      height: auto;
      pointer-events: none;
      }
      .heroSection a button {
        background-color: #32eb2a;
        color: white;
        padding: 16px 77px;
        margin-bottom: 150px;
        font-family: 'Lexend', sans-serif;
        font-size: 25px;
        font-weight: 500;
        border: none;
        border-radius: 30px 30px 30px 2px;
        position: relative;
        box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.25);
      }
      .heroSection a button:hover {
        background-color: #238649;
        cursor: pointer;
      }
      /************************************************************/
      .whoCanJoin {
        background-color: #238649;
        padding: 50px 110px;
        font-family: 'Lexend', sans-serif;
        text-align: center;
      }
      .whoCanJoin > h1 {
          color: white;
          font-size: 64px;
          font-weight: 900;
          margin-bottom: 40px;
          margin-top: 0;
      }
      .who-can-join-section {
          display: flex;
          justify-content: center;
          align-items: stretch;
          gap: 50px;
      }
      .stcard, .ndcard {
          flex: 1;
          max-width: 520px;
          min-width: 400;
          border: 3px solid white;
          border-radius: 10px;
          padding: 35px 5px;
          color: white;
          font-family: 'Lexend', sans-serif;
          text-align: center;
          position: relative;
          overflow: hidden;
          display: flex;
          flex-direction: column;
          justify-content: center;
          background-size: cover;
          background-position: center;
      }
      .stcard {
          background-image: url('Photos/collaborate_with_us/sponsors\ and\ partners.jpg');
      }
      .ndcard {
          background-image: url('Photos/collaborate_with_us/volunteers.jpg');
      }
      .stcard::before, .ndcard::before {
          content: '';
          position: absolute;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          background-color: rgba(0, 0, 0, 0.35);
          z-index: 1;
      }
      .stcard > *, .ndcard > * {
          position: relative;
          z-index: 2;
      }
      .whoCanJoin h2 {
          font-size: 30px;
          font-weight: 700;
          margin-top: 0;
          margin-bottom: 8px;
          text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.35);
      }
      .whoCanJoin h3 {
          font-size: 25px;
          font-weight: 300;
          margin-bottom: 25px;
          text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.35);
      }
      .whoCanJoin li {
          font-size: 23px;
          font-weight: 300;
          line-height: 1.4;
          margin-bottom: 5px;
          text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.35);
      }
    /************************************************************/
    .whyJoinUs {
        background-image: url('Photos/collaborate_with_us/background.jpg');
        background-size: cover;
        background-position: center;
        padding: 80px 20px;
        position: relative;
        font-family: 'Lexend', sans-serif;
        overflow: hidden;
    }
    .why-join-bg-image {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: auto;
        z-index: 1;
    }
.whyJoinUs h1 {
    text-align: center;
    font-size: 65px;
    font-weight: 900;
    color: black;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    margin-bottom: 50px;
    position: relative;
    z-index: 2;
}
.why-join-container {
    display: flex;
    justify-content: center;
    gap: 70px;
    position: relative;
    z-index: 2;
}
.benefit-column {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex: 1;
    max-width: 450px;
}
.benefit-column h2 {
    font-size: 40px;
    font-weight: 750;
    color: black;
    margin: 0 0 15px 0;
}
.benefit-card {
    width: 100%;
    max-width: 450px;
    font-family: 'Lexend', sans-serif;
    border: 4px solid #000;
    border-radius: 8px;
    padding: 40px 30px;
    box-shadow: 0px 4px 4px 0px rgba(0, 0, 0, 0.50);
    background: rgba(217, 217, 217, 0.30);
}
.benefit-item {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 30px;
}
.benefit-item:last-child {
    margin-bottom: 0;
}
.benefit-item img {
    width: 45px;
    height: 45px;
    flex-shrink: 0; /* Prevents icon from shrinking */
}
.benefit-item p {
    font-size: 22px;
    font-weight: 400;
    color: black;
    text-shadow: 0px 4px 4px rgba(0, 0, 0, 0.50);
    margin: 0;
    line-height: 1.5;
}
/************************************************************/
    .teamUpForm {
    background-color: #238649;
    padding: 50px 60px 30px 10px;
    font-family: 'Lexend', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 100px;
    }
    #teamUpForm h1 {
      width: 100%;
      text-align: center;
      margin-top: 40px;
      font-size: 70px;
      font-weight: 900;
      background: url(Photos/collaborate_with_us/background.jpg);
      background-size: cover;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    .teamUpForm img {
        text-align: center;
        min-width: 380px;
    }
    .teamUpForm form {
        display: grid;
        grid-template-columns: 321px 321px;
        justify-content: center;
        gap: 15px;
    }
    .teamUpForm label, .teamUpForm br {
        display: none;
    }
    .teamUpForm input,
    .teamUpForm select,
    .teamUpForm textarea {
        padding: 15px 30px;
        border: 1px solid transparent;
        border-radius: 5px;
        background-color: white;
        font-size: 17px;
        font-family: 'Lexend', sans-serif;
        color: rgba(0, 0, 0, 0.70);
        box-sizing: border-box;
        font-weight: 350;
    }
    .teamUpForm input::placeholder,
    .teamUpForm select::placeholder,
    .teamUpForm textarea::placeholder{
      color: rgba(0, 0, 0, 0.70);
    }
    .teamUpForm input:focus,
    .teamUpForm select:focus,
    .teamUpForm textarea:focus {
        outline: none;
        border-color: black;
    }
    .teamUpForm select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23555' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
    }
    .teamUpForm #uploadedFile,
    .teamUpForm #message {
        grid-column: 1 / -1;
    }
    .teamUpForm #message {
        min-height: 140px;
        resize: vertical;
    }
    .teamUpForm #uploadedFile::file-selector-button {
        display: none;
    }
    .teamUpForm button{
      grid-column: 1 / -1;
        justify-self: center;
        background-color: #32eb2a;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 33px;
        font-family: 'Lexend', sans-serif ;
        font-size: 20px;
        font-weight: 550;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .teamUpForm button:hover {
        background-color: #2dbb2d;
    } 
    
    .hidden {
    display: none !important;
}
#partner-fields,
#volunteer-fields {
    grid-column: 1 / -1;
    display: grid;
    grid-template-columns: 321px 321px;
    gap: 15px;
    border-radius: 5px; 
}
    #partner-fields input:focus,
    #volunteer-fields select:focus{
        outline: none;
        border-color: black;
    }
/************************************************************/ 
.ourPartners {
    background-image: url('Photos/collaborate_with_us/our\ partners\ bg.jpeg');
    background-size: cover;
    background-position: center;
    padding: 60px 40px;
    text-align: center;
    font-family: 'Lexend', sans-serif;
}
.ourPartners h1 {
    font-size: 66px;
    font-weight: 900;
    color: #000;
    margin-bottom:  40px;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
}
.logos-container {
    display: flex;
    justify-content: center; 
    align-items: center;
    gap: 50px;
}
.logos-container img {
    max-height: 150px; 
    max-width: 250px;
    width: auto;
    cursor: pointer;
}
/************************************************************/
#faq {
    display: grid;
    grid-template-columns: 580px 580px;
    grid-template-rows: auto auto auto auto;
    grid-template-areas:
        "title title"
        "col1 col2"
        "contact contact"
        "button-area button-area";
    gap: 40px 20px;
    padding: 30px 60px;
    color: white;
    font-family: 'Lexend', sans-serif;
}
#faq h2 {
    grid-area: title;
    text-align: center;
    font-size: 65px;
    font-weight: 800;
    color: white;
}
.stCol {
    grid-area: col1;
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.ndCol {
    grid-area: col2;
    display: flex;
    flex-direction: column;
    gap: 15px;
}
#faq details {
    background-color: #FFFFFF;
    border-radius: 8px;
    width: 100%;
    overflow: hidden;
    display: grid;
    grid-template-rows: auto 0fr;
    transition: grid-template-rows 0.3s ease-in-out;
}
#faq details[open] {
    grid-template-rows: auto 1fr;
}
#faq summary {
    padding: 22px 20px 22px 40px;
    color: black;
    font-size: 19px;
    font-weight: 400;
    cursor: pointer;
    list-style: none;
    display: flex;
    justify-content: space-between;
    align-items: center; 
}
#faq summary::-webkit-details-marker {
    display: none;
}
#faq summary::after {
    content: '';
    display: inline-block;
    width: 8px;
    height: 8px;
    border-style: solid;
    border-color: #555555; 
    border-width: 0 2px 2px 0; 
    transform: rotate(45deg);
}
#faq details[open] summary::after {
    transform: rotate(225deg);
}
#faq details p {
    background-color: black;
    color: white;
    padding: 30px 40px;
    margin: 0;
    font-size: 19px;
    overflow: hidden;
}
.stillHave {
    grid-area: contact;
    text-align: center;
    font-family: "Caveat", cursive;
    font-size: 35px;
    color: white;
}
#faq > a {
    grid-area: button-area;
    justify-self: center;
    text-decoration: none;
}
#faq button {
    background-color: #32eb2a;
    color: white;
    padding: 15px 40px;
    border: none;
    border-radius: 12px;
    font-size: 25px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-family: 'Lexend', sans-serif;
}
#faq button:hover {
    background-color: #2dbb2d;
}

/************************************************************/
        footer {
            background-image: url('Photos/collaborate_with_us/background.jpg');
            background-size: cover;
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

        .message { 
          grid-column: 1 / -1; 
          padding: 15px; 
          margin-bottom: 15px; 
          border-radius: 4px; 
          text-align: center; 
        }
        .success { 
          background-color: #d4edda; 
          color: #155724; 
        }
        .error { 
          background-color: #f8d7da; 
          color: #721c24; 
        }
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
      <section class="heroSection">
        <h1>Let’s Make an Impact Together!</h1>
        <p>
          We believe in collective action. Whether you're a company, bookstore,
          or passionate individual, there’s a place for you in our mission
        </p>
        <img src="Photos/collaborate_with_us/Hero section.png" alt="chejra" />
        <a href="#teamUpForm"
          ><button type="button">Support the Mission</button></a
        >
      </section>
    </header>
    <main>
      <section class="whoCanJoin">
        <h1>Who can join</h1>
        <div class="who-can-join-section">
        <div class="stcard">
          <h2>Partners / Sponsors</h2>
          <h3>Bookstores, businesses, NGOs</h3>
          <h2>What they can help us with:</h2>
          <ul>
            <li>Provide funding</li>
            <li>Offer physical space</li>
            <li>Logistics or transport</li>
          </ul>
        </div>
        <div class="ndcard">
          <h2>Volunteers</h2>
          <h3>Students or individuals</h3>
          <h2>What they can help us with:</h2>
          <ul>
            <li>Book collection</li>
            <li>Book sorting</li>
            <li>Community outreach</li>
          </ul>
        </div>
        </div>
      </section>
      <section class="whyJoinUs">
         <img class="why-join-bg-image" src="Photos/collaborate_with_us/why join us bg.png" alt="Decorative vine and hand illustration" />
        <h1>Why join Us?</h1>
      <div class="why-join-container">
        <div class="benefit-column">
        <h2>Partners / Sponsors</h2>
        <div class="benefit-card">
          <div class="benefit-item">
          <img
            src="Icons/UI/collaborate_with_us/icons8-haut-parleur-1-100.png"
            alt=""
          />
          <p>Exposure and branding opportunities</p>
          </div>
          <div class="benefit-item">
          <img
            src="Icons/UI/collaborate_with_us/icons8-durabilité-100.png"
            alt=""
          />
          <p>Sustainability contribution</p>
          </div>
          <div class="benefit-item">
          <img
            src="Icons/UI/collaborate_with_us/icons8-script-de-rapport-de-graphique-100.png"
            alt=""
          />
          <p>Community impact reports</p>
          </div>
          </div>
        </div>
        <div class="benefit-column">
        <h2>Volunteers</h2>
          <div class="benefit-card">
            <div class="benefit-item">
          <img
            src="Icons/UI/collaborate_with_us/icons8-compétences-de-développement-100.png"
            alt=""
          />
          <p>Gaining practical experience: logistics, communication…</p>
          </div>
          <div class="benefit-item">
          <img
            src="Icons/UI/collaborate_with_us/icons8-diplôme-1-100.png"
            alt=""
          />
          <p>Certificates</p>
          </div>
          <div class="benefit-item">
          <img
            src="Icons/UI/collaborate_with_us/icons8-nourriture-naturelle-100.png"
            alt=""
          />
          <p>Social, environmental impact</p>
          </div>
        </div>
        </div>
      </div>
      </section>
      <section id="teamUpForm">
        <h1>Ready to Team Up?</h1>
        <div class="teamUpForm">
        <div>
          <img src="Photos/collaborate_with_us/team up form.png" alt="" />
        </div>
        <div id="form" class="theForm">
          <form action="#form" method="post" enctype="multipart/form-data">

          <?php
            // Check if a flash message exists in the session
            if (isset($_SESSION['flash_message'])) {
                // Display the message with the correct style
                echo '<div class="message ' . $_SESSION['flash_type'] . '">';
                echo htmlspecialchars($_SESSION['flash_message']);
                echo '</div>';
                
                // CRUCIAL: Delete the message so it doesn't show again
                unset($_SESSION['flash_message']);
                unset($_SESSION['flash_type']);
            }
        ?>

            <label for="fName"></label>
            <input type="text" name="full_name" id="fName" placeholder="Full name" required/>
            <label for="telNum"></label>
            <input
              type="tel"
              name="phone_number"
              id="telNum"
              placeholder="Phone Number" required
            /><br />
            <label for="email"></label>
            <input
              type="email"
              name="email"
              id="email"
              placeholder="Email Address" required
            />
            <label for="preConMethod"></label>
            <select name="contact_method" id="preConMethod" required>
              <option value="" disabled selected>Preferred Contact Method</option>
              <option value="calls">Calls</option>
              <option value="whatsapp">Whatsapp</option>
              <option value="emails">Emails</option></select
            ><br />
            <label for="city"></label>
            <input type="text" id="city" name="city" placeholder="City" required/>
            <label for="collaType"></label>
            <select name="collaboration_type" id="collaType" required>
              <option value="" disabled selected>Type of Collaboration</option>
              <option value="partnership">Partnership / Sponsorship</option>
              <option value="volunteering">Volunteering</option></select
            >


            <div id="partner-fields" class="hidden">
            <label for="nameCompany"></label>
            <input
              type="text"
              name="company_name"
              id="nameCompany"
              placeholder="Company name"
            />
            <label for="fieldActivity"></label>
            <input
              type="text"
              name="field_of_activity"
              id="fieldActivity"
              placeholder="Field of activity"
            />
            </div>

            <div id="volunteer-fields" class="hidden">
            <label for="desiredRole"></label>
            <select name="desired_role" id="desiredRole" >
              <option value=""disabled selected>Desired Role</option>
              <option value="logistics">Logistics</option>
              <option value="sorting">Sorting</option>
              <option value="communication">Communication & Digital Marketing</option>
              <option value="admin_assistance">Administrative Assistance</option>
            </select>
            <label for="availability" ></label>
            <select name="availability" id="availability">
              <option value="" disabled selected>Availability</option>
              <option value="occasionally">Occasionally</option>
              <option value="once a week">Once a week</option>
              <option value="weekends only">Weekends only</option>
              <option value="several times a week">Several times a week</option>
              <option value="flexible">Flexible</option></select
            >
            </div>


            <label for="uploadedFile"></label>
            <input
              type="file"
              name="uploaded_file"
              id="uploadedFile"
              placeholder="Upload file (CV/ proposal)"
            /><br />
            <label for="message"></label>
            <textarea
              name="message"
              id="message"
              placeholder="Tell us a bit about how you'd like to collaborate with us" required
            ></textarea
            ><br />
            <button type="submit">Submit</button>
          </form>
        </div>
        </div>
      </section>
      <section class="ourPartners">
        <h1>Our Partners</h1>
         <div class="logos-container">
        <a target="_blank" href="https://fsc.org/en"><img src="Photos/collaborate_with_us/partner 1.png" alt="" /></a>
        <a target="_blank" href="https://www.paper-mountain.net/commercial-recycling/"><img src="Photos/collaborate_with_us/partner5.png" alt=""></a>
        <a target="_blank" href="https://www.paperresource.com.au"><img src="Photos/collaborate_with_us/partner 2.png" alt=""/></a>
        <a target="_blank" href="https://www.suez.com/fr/afrique"><img src="Photos/collaborate_with_us/partner 3.png" alt="" /></a>
        <a target="_blank" href="https://www.terracycle.com/fr-FR/?srsltid=AfmBOoq8eRHJcmOPCKIhEqVfkQ0RLawEdG6MFC8H5V57thUuBPAv3Ju7"><img src="Photos/collaborate_with_us/partner 4.png" alt=""/></a>
        </div>
      </section>
      <section id="faq">
        <h2>FAQ</h2>
        <div class="stCol">
          <details>
            <summary>Can my small bookstore partner with you?</summary>
            <p>
              Absolutely! We welcome partnerships with bookstores of all sizes.
            </p>
          </details>
          <details>
            <summary>
              Will our brand be visible if we sponsor BookCycle?
            </summary>
            <p>
              Yes, we offer brand exposure on our website, social media, events,
              and community reports.
            </p>
          </details>
          <details>
            <summary>Is there a minimum sponsorship requirement?</summary>
            <p>
              We’re flexible; both small and large contributions are valuable
              and acknowledged.
            </p>
          </details>
        </div>
        <div class="ndCol">
          <details>
            <summary>
              Do I need to commit for a long time as a volunteer?
            </summary>
            <p>
              No long-term commitment is required, join us when you can, every
              little bit helps!
            </p>
          </details>
          <details>
            <summary>Do I need previous experience to volunteer?</summary>
            <p>
              Not at all! We'll guide you based on your interests and skills.
            </p>
          </details>
          <details>
            <summary>Can I volunteer remotely?</summary>
            <p>
              Some roles like content creation administrative assistance can be
              done remotely. The other roles are local.
            </p>
          </details>
        </div>
        <p class="stillHave">
          Still have questions?<br />Don’t hesitate to reach out through our
          contact form!
        </p>
        <a href="contact_us.php" target="_self"
          ><button type="button">Ask Us here</button></a
        >
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
<script>
    const collaTypeSelect = document.getElementById('collaType');
    const partnerFields = document.getElementById('partner-fields');
    const volunteerFields = document.getElementById('volunteer-fields');
    
    // Get all the inputs/selects within the conditional sections
    const partnerInputs = partnerFields.querySelectorAll('input');
    const volunteerInputs = volunteerFields.querySelectorAll('select');

    collaTypeSelect.addEventListener('change', function() {
        // First, hide both sections and make all their fields NOT required
        partnerFields.classList.add('hidden');
        volunteerFields.classList.add('hidden');
        partnerInputs.forEach(input => input.required = false);
        volunteerInputs.forEach(input => input.required = false);

        // Now, show the correct section and make ITS fields required
        if (this.value === 'partnership') {
            partnerFields.classList.remove('hidden');
            partnerInputs.forEach(input => input.required = true);
        } else if (this.value === 'volunteering') {
            volunteerFields.classList.remove('hidden');
            volunteerInputs.forEach(input => input.required = true);
        }
    });

    // Optional: Trigger the change event on page load in case a value is pre-selected
    // This is good practice for forms that might remember old values.
    collaTypeSelect.dispatchEvent(new Event('change'));
</script>
  </body>
</html>
