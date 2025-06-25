<?php include 'include/db_connect.php';
session_start();
// SECURITY CHECK: If the user is NOT logged in, redirect them to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: logIn.php');
    exit; // Stop the script from running further
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
    transition: width 0.6s ease-in-out;
}
.step {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-basis: 25%;
    position: relative;
    z-index: 2;
    text-align: center;
}
.step-icon-main {
    width: 65px;
    height: 65px;
    margin-bottom: 10px;
    transition: filter 0.4s ease;
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
}
.step.active .step-title,
.step.active .step-description,
.step.completed .step-title,
.step.completed .step-description {
    opacity: 1; /* Show text for active and completed steps */
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

/* Style for a COMPLETED step */
.step.completed .icon-circle {
    border-color: #277448;
}

.step.completed .step-icon-main {
    filter: none;
    color: #277448;
}

/* When a step is completed, hide the number and show the checkmark */
.step.completed .step-number {
    display: none;
}
.step.completed .checkmark-icon {
    display: block;
}


/* --- NEW 'CANCELED' STATE --- */
.step.canceled .icon-circle {
    border-color: #d9534f; /* Red color for canceled */
    background-color: #fff;
}
.step.canceled .step-icon-main {
    filter: grayscale(100%) opacity(0.5); /* Keep main icon gray */
}
.step.canceled .step-number { display: none; }
.step.canceled .checkmark-icon { display: none; } /* Hide checkmark */
.step.canceled .cancel-icon { display: block; }




    </style>
</head>
<body>
    <header>
       <div class="navbar">
        <a href="index.php"
          ><img src="logo/Logo black shadow.png" alt="Logo"
        /></a>
        <nav>
          <ul>
            <li><a href="progress.php" target="_self" class="navItems">Progress</a></li>
            <li>
              <a href="colaborate_with_us.php" target="_self" class="navItems"
                >Collaborate with us</a
              >
            </li>
            <li>
              <a href="about_us.php" target="_self" class="navItems"
                >About us</a
              >
            </li>
            <li>
              <a href="contact_us.php" target="_self" class="navItems"
                >Contact us</a
              >
            </li>
            <li><a href="profile.php"><img src="Icons/UI/Progress/icons8-utilisateur-100.png" class="img"></a></li>
          </ul>
        </nav>
      </div>  
</header>
    <main class="book-pickup-status">
        <h1>Your Book Pickup Progress</h1>
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

    // --- NEW: DATA STRUCTURE FOR TEXT CONTENT ---
    const stepData = [
        { // Step 1
            title: "Request Received",
            description: "We’re reviewing your information and will confirm soon."
        },
        { // Step 2
            title: "Pickup Scheduled",
            description: "Please check your email for more details regarding the pickup."
        },
        { // Step 3
            title: "On the Way",
            description: "Our team is heading to your location now, please keep your books ready."
        },
        { // Step 4 - Has multiple final states
            title: "Status", // A generic title
            description: "", // Empty description
            finalStates: {
                collected: {
                    title: "Books collected",
                    description: "Thank you for contributing to a cleaner planet!"
                },
                canceled: {
                    title: "Pickup Canceled",
                    description: "There was an issue with the pickup. Please contact support."
                }
            }
        }
    ];

    /**
     * Updates the progress bar UI.
     * @param {number} currentStep - The current active step (e.g., 1, 2, 3, or 4).
     * @param {string|null} finalStatus - The status for the last step ('collected', 'canceled', etc.).
     */
    function updateProgress(currentStep, finalStatus = null) {
        const totalSteps = allSteps.length;
        if (currentStep < 1) currentStep = 1;
        if (currentStep > totalSteps) currentStep = totalSteps;

        allSteps.forEach((step, index) => {
            const stepNumber = index + 1;
            const titleEl = step.querySelector('.step-title');
            const descriptionEl = step.querySelector('.step-description');

            // --- Reset states and text content ---
            step.classList.remove('active', 'completed', 'canceled');
            titleEl.textContent = '';
            descriptionEl.textContent = '';

            // --- Set visual state (classes) ---
            if (stepNumber < currentStep) {
                step.classList.add('completed');
            } else if (stepNumber === currentStep) {
                step.classList.add('active');
            }
            
            // --- Set text content based on state ---
            if (step.classList.contains('completed') || step.classList.contains('active')) {
                // Handle special case for the last step
                if (stepNumber === totalSteps && finalStatus) {
                    step.classList.remove('active'); // Final step is never 'active', it's a final state.
                    step.classList.add('completed'); // Mark as completed visually
                    
                    if (stepData[index].finalStates[finalStatus]) {
                        titleEl.textContent = stepData[index].finalStates[finalStatus].title;
                        descriptionEl.textContent = stepData[index].finalStates[finalStatus].description;
                        if (finalStatus === 'canceled') {
                             step.classList.add('canceled');
                        }
                    }
                } else {
                    // Standard text for steps 1, 2, 3
                    titleEl.textContent = stepData[index].title;
                    descriptionEl.textContent = stepData[index].description;
                }
            }
        });
        
        // --- Update progress line ---
        // The line should be full if a final status is given, otherwise it goes to the active step.
        const progressTarget = finalStatus ? totalSteps : currentStep;
        const progressPercentage = ((progressTarget - 1) / (totalSteps - 1)) * 100;
        progressFill.style.width = `${progressPercentage}%`;
        // Make the line red if canceled
        progressFill.style.backgroundColor = (finalStatus === 'canceled') ? '#d9534f' : '#277448';
    }

    // --- HOW TO USE IT (EXAMPLES) ---
    // Your backend will provide the status. You call the function accordingly.

    // Example 1: Pickup is scheduled (Step 2 is active)
    // updateProgress(2);

    // Example 2: Team is on the way (Step 3 is active)
    updateProgress(3);

    // Example 3: Books have been successfully collected
    // updateProgress(4, 'collected');
    
    // Example 4: Pickup was canceled
    // updateProgress(4, 'canceled');
    
    // Example 5: Initial state (Step 1 is active, no text shown for other steps)
    // updateProgress(1);
});
</script>
</body>
</html>