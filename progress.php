<?php
// --- DATABASE CONNECTION AND SESSION START ---
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

session_start();

// --- SECURITY CHECK ---
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: logIn.php');
    exit;
}

// --- LOGIC TO FETCH THE LATEST REQUEST STATUS ---
$requestStatus = null; // Default value

// Check for the session variable from your logIn.php (it's 'email')
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    $email = $_SESSION['email'];

    $stmt = $conn->prepare(
        "SELECT status FROM request_form 
         WHERE email_client_ID = :email 
         ORDER BY submission_date DESC 
         LIMIT 1"
    );
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $requestStatus = $result['status'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress</title>
    <link rel="icon" href="logo/bookcycle.png" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/css2?family=Lexend&display=swap" rel="stylesheet">
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
          font-family: 'Lexend', sans-serif;
          background-image: url(Photos/progress/background.jpg);
          background-size: contain;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-position: bottom center;
        }
        

        /************************************************************/
        .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 40px;
      }
      nav ul {
        display: flex;
        gap: 30px;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
      }
      .navItems {
        color: #238649;
        font-size: 22px;
        font-weight: 900;
      }

      .navItems:hover {
        color: #32eb2a;
        cursor: pointer;
      }
      a {
        text-decoration: none;
        color: inherit;
      }
      .img{
        height: 55px;
        width: 55px;
      }
      /************************************************************/
      .book-pickup-status {
    font-family: 'Lexend', sans-serif;
    text-align: center;
    padding: 10px 20px;
    max-width: 1200px;
    margin: 0 auto;
    overflow: hidden;
}
.book-pickup-status h1 {
    font-size: 40px;
    color: black;
    margin-bottom: 43px;
    font-weight: 900;
}
.progress-container {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 30px;
            margin-left: auto;
            margin-right: auto;
            width: 85%; /* Adjust width to control line length */
        }
.progress-line-bg, .progress-line-fill {
            position: absolute;
            top: 115px;
            left: 0;
            height: 3px;
            width: 100%;
            z-index: 1;
        }
.progress-line-bg {
    background-color: #e0e0e0;
}
.progress-line-fill {
    background-color: #277448;
    width: 0;
    transition: width 0.6s ease-in-out, background-color 0.6s ease-in-out;
}
.step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            text-align: center;
        }
.step-icon-main {
    width: 65px;
    height: 65px;
    margin-bottom: 10px;
    transition: filter 0.4s ease;
    filter: grayscale(100%) opacity(0.7); /* Grayscale by default */
}
.icon-circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background-color: white;
    border: 2px solid #238649;
    color: #238649;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    font-weight: 600;
    transition: all 0.4s ease;
}
.checkmark-icon, .cancel-icon {
    display: none;
}
.step .step-title,
.step .step-description {
    opacity: 0; /* Hide text by default */
    visibility: hidden;
    transition: opacity 0.4s ease-in-out, visibility 0.4s;
    min-height: 35px; /* Reserve space to prevent layout jumps */
}
.step.active .step-title,
.step.active .step-description {
    opacity: 1; /* Show text for active step */
    visibility: visible;
}
.step h3 {
    margin-top: 20px;
    margin-bottom: 8px;
    font-size: 24px;
    color: black;
    font-weight: 600;
    text-shadow: 0px 3px 3px rgba(255, 255, 255, 0.4);
}
.step p {
    font-size: 18px;
    font-weight: 200;
    color: black;
    max-width: 200px;
    line-height: 1.4;
    text-shadow: 0px 3px 3px rgba(255, 255, 255, 0.4);
}
.step.active .icon-circle {
    background-color: #277448;
    border-color: #277448;
    color: #fff;
}
.step.active .step-icon-main {
    filter: none; /* Removes grayscale to show full color */
}
.step.completed .icon-circle {
            border-color: #277448;
            background-color: #fff;
            color: #238649;
        }
.step.completed .step-icon-main {
    filter: none;
}
.step.completed .step-number {
    display: none;
}
.step.completed .checkmark-icon {
    display: block;
}
.step.canceled .icon-circle {
    border-color: #d9534f; /* Red color for canceled */
    background-color: #fff;
}
.step.canceled .step-number { display: none; }
.step.canceled .checkmark-icon { display: none; }
.step.canceled .cancel-icon { display: block; }

#no-request-message {
    text-align: center;
    font-size: 20px;
    color: #333;
    margin-top: 50px;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.7);
    border-radius: 8px;
}
#no-request-message a {
    color: #238649;
    font-weight: 600;
    text-decoration: underline;
}
    </style>
</head>
<body>
    <header>
       <div class="navbar">
        <a href="index.php"><img src="logo/Logo black shadow.png" alt="Logo"/></a>
        <nav>
          <ul>
            <li><a href="progress.php" target="_self" class="navItems">Progress</a></li>
            <li><a href="colaborate_with_us.php" target="_self" class="navItems">Collaborate with us</a></li>
            <li><a href="about_us.php" target="_self" class="navItems">About us</a></li>
            <li><a href="contact_us.php" target="_self" class="navItems">Contact us</a></li>
            <li><a href="profile.php"><img src="Icons/UI/Progress/icons8-utilisateur-100.png" class="img"></a></li>
          </ul>
        </nav>
      </div>  
</header>
    <main class="book-pickup-status">
        <h1>Your Book Pickup Progress</h1>

        <!-- Container for the "No Request" message -->
        <div id="no-request-message" style="display: none;">
            <p>You haven't made a request yet. <br> Please <a href="index.php">fill the request form</a> to track your request.</p>
        </div>

        <div class="progress-container" id="progressBar">
            <div class="progress-line-bg"></div>
            <div class="progress-line-fill" id="progressFill"></div>
        
            <!-- Step 1 -->
            <div class="step">
                <img class="step-icon-main" src="Icons/UI/Progress/icons8-double-coche-100.png">
              <div class="icon-circle"> <span class="step-number">1</span><img class="checkmark-icon"  src="Icons/UI/Progress/Path.png"></div>
              <h3 class="step-title"></h3>
            <p class="step-description"></p>
            </div>
        
            <!-- Step 2 -->
            <div class="step">
                <img class="step-icon-main" src="Icons/UI/Progress/icons8-scheduled-delivery-100.png" alt="">
              <div class="icon-circle"> <span class="step-number">2</span><img class="checkmark-icon"  src="Icons/UI/Progress/Path.png"></div>
              <h3 class="step-title"></h3>
            <p class="step-description"></p>
            </div>

         <!-- Step 3 -->
            <div class="step">
                <img class="step-icon-main" src="Icons/UI/Progress/icons8-in-transit-100.png" alt="">
              <div class="icon-circle"> <span class="step-number">3</span><img class="checkmark-icon"  src="Icons/UI/Progress/Path.png"></div>
              <h3 class="step-title"></h3>
            <p class="step-description"></p>
            </div>

        <!-- Step 4 -->
            <div class="step">
                <img class="step-icon-main" src="Icons/UI/Progress/icons8-pass-100.png" alt="">
              <div class="icon-circle"> <span class="step-number">4</span><img class="checkmark-icon"  src="Icons/UI/Progress/Path.png"><img class="cancel-icon" src="Icons/UI/Progress/cancel.png" alt="Canceled"></div>
              <h3 class="step-title"></h3>
            <p class="step-description"></p>
            </div>
          </div>
    </main>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const allSteps = document.querySelectorAll('.step');
        const progressFill = document.getElementById('progressFill');
        const stepData = [
            { title: "Request Received", description: "We're reviewing your information and will confirm soon." },
            { title: "Pickup Scheduled", description: "Please check your email for more details regarding the pickup." },
            { title: "On the Way", description: "Our team is heading to your location now, please keep your books ready." },
            { 
                finalStates: {
                    collected: { title: "Books Collected", description: "Thank you for contributing to a cleaner planet!" },
                    canceled: { title: "Pickup Canceled", description: "There was an issue with your request." }
                }
            }
        ];

        function updateProgress(currentStep, finalStatus = null) {
            const totalSteps = allSteps.length;
            if (currentStep < 1 || currentStep > totalSteps) return;

            allSteps.forEach((step, index) => {
                const stepNumber = index + 1;
                const titleEl = step.querySelector('.step-title');
                const descriptionEl = step.querySelector('.step-description');

                step.classList.remove('active', 'completed', 'canceled');
                titleEl.textContent = ''; 
                descriptionEl.textContent = ''; 

                // Set visual state
                if (stepNumber < currentStep) {
                    step.classList.add('completed');
                } else if (stepNumber === currentStep) {
                    // CHANGE 5: The final step (collected or canceled) is 'completed', not 'active'
                    if (finalStatus) {
                        step.classList.add('completed');
                        if (finalStatus === 'canceled') {
                            step.classList.add('canceled');
                        }
                    } else {
                        step.classList.add('active');
                    }
                }
                
                // Show text ONLY for the currently active/final step
                if (stepNumber === currentStep) {
                    // Make the text visible by adding the .active class, which controls opacity
                    step.classList.add('active'); 
                    if (finalStatus) {
                        const state = stepData[index].finalStates[finalStatus];
                        if (state) {
                            titleEl.textContent = state.title;
                            descriptionEl.textContent = state.description;
                        }
                    } else {
                        titleEl.textContent = stepData[index].title;
                        descriptionEl.textContent = stepData[index].description;
                    }
                }
            });
            
            // CHANGE 6: Adjust the width calculation for the line
            const progressPercentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
            progressFill.style.width = `${progressPercentage}%`;
            progressFill.style.backgroundColor = (finalStatus === 'canceled') ? '#d9534f' : '#277448';
        }

        const requestStatus = <?php echo json_encode($requestStatus); ?>;
        const progressBar = document.getElementById('progressBar');
        const noRequestMessage = document.getElementById('no-request-message');

        if (requestStatus === null) {
            progressBar.style.display = 'none';
            noRequestMessage.style.display = 'block';
        } else {
            progressBar.style.display = 'flex';
            noRequestMessage.style.display = 'none';
            let stepToActivate = 0;
            let finalState = null;
            switch (requestStatus) {
                case 'processing': stepToActivate = 1; break;
                case 'scheduled': stepToActivate = 2; break;
                case 'in transit': stepToActivate = 3; break;
                case 'collected': stepToActivate = 4; finalState = 'collected'; break;
                case 'canceled': stepToActivate = 4; finalState = 'canceled'; break;
                default: stepToActivate = 1;
            }
            updateProgress(stepToActivate, finalState);
        }
    });
    </script>
</body>
</html>
