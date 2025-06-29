<?php
session_start();

// redirect to login if not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: logIn.php');
    exit;
}

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

// form submission and updating information in DB
// when we click on "Save change" and the form gets submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // gets data from the form
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phone = $_POST['phone'];
        $contactMethod = $_POST['contactMethod'];
        $city = $_POST['city'];

        // gets the user's email from the session to know which row to update
        $userEmail = $_SESSION['email'];
        
        // the update SQL statement
        $sql = "UPDATE client SET 
                    first_name = :first_name, 
                    last_name = :last_name, 
                    phone_number = :phone_number, 
                    preferred_contact_method = :contact_method, 
                    city = :city 
                WHERE email_client_ID = :email";

        $stmt = $conn->prepare($sql);

        // linking each field to a variable
        $stmt->bindParam(':first_name', $firstName);
        $stmt->bindParam(':last_name', $lastName);
        $stmt->bindParam(':phone_number', $phone);
        $stmt->bindParam(':contact_method', $contactMethod);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':email', $userEmail);

        $stmt->execute();
        
        // updating the name in the welcome sentence
        $_SESSION['name'] = $firstName;
        
        // success message
        $_SESSION['flash_message'] = "Profile updated successfully!";
        $_SESSION['flash_type'] = "success";

    } catch (PDOException $e) {
        // error message
        $_SESSION['flash_message'] = "Error updating profile: " . $e->getMessage();
        $_SESSION['flash_type'] = "error";
    }

    // redirect to profile again
    header('Location: profile.php');
    exit;
}

// fetching current user data for display 
try {
    $userEmail = $_SESSION['email'];
    $sql = "SELECT * FROM client WHERE email_client_ID = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $userEmail);
    $stmt->execute();
    
    // fetch the user data into the $client variable
    $client = $stmt->fetch(PDO::FETCH_ASSOC);

    // if for some reason the user isn't found log them out
    if (!$client) {
        header('Location: logOut.php');
        exit;
    }
} catch (PDOException $e) {
    die("Error fetching user data: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
          background-color: white;
        }
        /*********************Navbar****************************/
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
      .img{
        height: 55px;
        width: 55px;
      }
      /*********************Main content***************************/

  body {
    background-color: white;
    font-family: 'Lexend', sans-serif;
    color: black;
  }
.profile-card {
    max-width: 1200px;
    margin: 20px auto;
    background-color: #fff;
    border-radius: 14px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.07);
    overflow: hidden;
}
.profile-header {
  height: 80px;
  background: linear-gradient(90deg, rgba(50, 235, 42, 0.60) 0%, #238649 100%);
  padding: 20px 30px;
  color: #3E435D;
}
.profile-header h3 {
  padding-top: 10px;
  padding-left: 40px;
  margin: 0;
  font-weight: 500;
}
.profile-body {
    padding: 30px 40px;
}
.profile-info {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 40px;
}
.profile-info img {
    width: 100px;
    height: 100px;
    box-sizing: border-box;
}
.profile-info p {
    font-size: 25px;
    font-weight: 600;
    margin: 0;
}
.profile-form {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px 30px;
}
.form-group {
    position: relative;
}
.form-group label {
    display: block;
    font-size: 17px;
    font-weight: 500;
    color: black;
    margin-bottom: 8px;
}
.form-group input,
.form-group select {
    width: 100%;
    padding: 12px 28px;
    font-size: 16px;
    font-family: 'Lexend', sans-serif;
    border-radius: 8px;
    box-sizing: border-box;
    transition: all 0.3s ease;
}
.form-group input,
.form-group select {
    background-color: #f3f4f6;
    border: 1px solid #f3f4f6;
    color: #6b7280; 
    pointer-events: none;
}
.form-group select {
    appearance: none;
    -webkit-appearance: none;
    background-image: none;
}
.form-group.editable input,
.form-group.editable select {
    background-color: #fff;
    border: 1px solid #d1d5db;
    color: #111827;
    pointer-events: auto;
}
.form-group.editable select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23555' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
}
.form-group.editable input:focus,
.form-group.editable select:focus {
    outline: none;
    border-color: #238649;
    box-shadow: 0 0 0 2px rgba(35, 134, 73, 0.2);
}
#email {
    background-color: #e5e7eb !important;
    color: #6b7280 !important;
    border-color: #e5e7eb !important;
    cursor: not-allowed;
    pointer-events: none !important;
}
.form-group.full-width {
    grid-column: 1 / -1;
}
.edit-button {
    background-color: #32EB2A;
    opacity: 0.7;
    border: none;
    border-radius: 8px;
    padding: 12px 28px;
    font-family: 'Lexend', sans-serif;
    font-size: 15px;
    font-weight: 500;
    font-size: 18px;
    font-weight: 600;
    color: #000;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
    display: inline-block;
}
.edit-button .save-mode {
    background-color: #238649;
    color: black;
}
span{
    color: #238649;
    font-size: 17px;
    font-weight: 600;
}
.form-group.full-width {
    grid-column: 1 / -1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logout-button {
    background-color: #fee2e2;
    color: #FF0000;
    border: 1px solid #FF0000;
    border-radius: 8px;
    padding: 12px 20px;
    font-family: 'Lexend', sans-serif;
    font-size: 18px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: background-color 0.3s ease, color 0.3s ease;
}
.logout-button:hover {
    background-color: #FF0000;
    color: white;
}
.form-group input, .form-group select {
    pointer-events: none;
    background-color: #f3f4f6;
    color: #6b7280;
}
.form-group.editable input, .form-group.editable select {
    pointer-events: auto; 
    background-color: #fff; 
    color: #111827; 
}
.form-actions {
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    grid-column: 1 / -1; 
}
.message { 
    padding: 1em; 
    margin-bottom: 1em; 
    border-radius: 5px; 
    text-align: center; 
    grid-column: 1 / -1; 
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
   <main>
    <div class="profile-card">
        <div class="profile-header">
         <h3>Welcome back, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h3>
        
        </div>
      <div class="profile-body">
        <div class="profile-info">
            <img src="Icons/UI/Progress/icons8-utilisateur-100.png">
             <p><?php echo htmlspecialchars($client['first_name']); ?> <br><?php echo htmlspecialchars($client['last_name']); ?></p>
        </div>
        <form class="profile-form" action="profile.php" method="post">

        <?php
                    if (isset($_SESSION['flash_message'])) {
                        echo '<div class="message ' . $_SESSION['flash_type'] . '">' . htmlspecialchars($_SESSION['flash_message']) . '</div>';
                        unset($_SESSION['flash_message']);
                        unset($_SESSION['flash_type']);
                    }
                ?>
          
                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($client['first_name']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($client['last_name']); ?>">
                </div>

                <div class="form-group">
                    <label for="telNum">Phone number</label>
                    <input type="tel" id="telNum" name="phone" value="<?php echo htmlspecialchars($client['phone_number']); ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input id="email" name="email" value="<?php echo htmlspecialchars($client['email_client_ID']); ?>">
                </div>

                <div class="form-group">
                    <label for="preConMethod">Preferred contact method</label>
                    <select id="preConMethod" name="contactMethod">
                        <option value="calls" <?php if($client['preferred_contact_method'] == 'calls') echo 'selected'; ?>>Calls</option>
                        <option value="whatsapp" <?php if($client['preferred_contact_method'] == 'whatsapp') echo 'selected'; ?>>Whatsapp</option>
                        <option value="emails"  <?php if($client['preferred_contact_method'] == 'emails') echo 'selected'; ?>>Emails</option>
                    </select>
                  </div>

                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($client['city']); ?>">
                </div>

                <div class="form-group full-width">
                     <button type="submit" class="edit-button"><span>Edit</span></button>
                    <a href="logOut.php" class="logout-button">Log Out</a>
                </div>
            </form>
      </div>
    </div>
   </main>
   <script>
document.addEventListener('DOMContentLoaded', function() {
    const editButton = document.querySelector('.edit-button');
    const form = document.querySelector('.profile-form');
    const editableFields = form.querySelectorAll('input:not(#email), select'); // Select all fields EXCEPT the email input
    const userNameDisplay = document.querySelector('.profile-info p');
    const welcomeMessage = document.querySelector('.profile-header h3');
    const firstNameInput = document.getElementById('firstName');
    const lastNameInput = document.getElementById('lastName');

    // read-only mode
    let isEditMode = false;

    editButton.addEventListener('click', function(event) {
        // prevent the form from submitting when we click Edit
        event.preventDefault(); 
        
        isEditMode = !isEditMode; //switch On/Off

        if (isEditMode) {
            // edit mode

            // make fields editable by adding 'editable' class
            editableFields.forEach(field => {
                field.parentElement.classList.add('editable');
            });

            // Change button text and style
            this.textContent = 'Save change';
            this.classList.add('save-mode');

        } else {
            // save change and exit edit mode

            // submit the new information, form.submi() will triger 'action' and 'method' in <form>, back-en will recieve the new data and updates the old one
            
            form.submit();

            // refresh and turn on read-only again
            editableFields.forEach(field => {
                field.parentElement.classList.remove('editable');
            });

            // change button back to "edit"
            this.textContent = 'Edit';
            this.classList.remove('save-mode');

            // update the name next to the icon
            form.submit();
        }
    });
});
</script> 
</body>
</html>