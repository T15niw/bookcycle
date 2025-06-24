<?php
 
session_start();

// --- DATABASE CONNECTION ---
// This is the connection code you provided
$host = 'localhost';
$dbname = 'bookcycle';
$user = 'root';
$password = ''; // Your DB password, often empty in a default XAMPP/WAMP setup

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// --- FORM PROCESSING ---
$passwordError = "";
$generalError = "";

// Check if the form was submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Sanitize and retrieve form data
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone_number']);
    $contactMethod = $_POST['contact_method'];
    $city = trim($_POST['city']);
    $pass = $_POST['password'];
    $confirmPass = $_POST['confirm_password'];

    // 2. Validate Passwords
    if ($pass !== $confirmPass) {
        $passwordError = "Passwords do not match.";
    } else {
        // 3. Hash the password for security
        // The PASSWORD_DEFAULT algorithm is strong and updates automatically with new PHP versions
        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

        // 4. Prepare and execute the SQL statement to insert data
        try {
            // Check if the email (primary key) already exists
            $checkSql = "SELECT email_client_ID FROM client WHERE email_client_ID = :email";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bindParam(':email', $email);
            $checkStmt->execute();

            if ($checkStmt->rowCount() > 0) {
                $generalError = "An account with this email address already exists.";
            } else {
                // Email is unique, proceed with insertion
                $sql = "INSERT INTO client (email_client_ID, first_name, last_name, phone_number, preferred_contact_method, city, password) 
                        VALUES (:email, :first_name, :last_name, :phone_number, :contact_method, :city, :password)";

                $stmt = $conn->prepare($sql);

                // Bind parameters to prevent SQL injection
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':first_name', $firstName);
                $stmt->bindParam(':last_name', $lastName);
                $stmt->bindParam(':phone_number', $phone);
                $stmt->bindParam(':contact_method', $contactMethod);
                $stmt->bindParam(':city', $city);
                $stmt->bindParam(':password', $hashedPassword);

                // Execute the statement
                $stmt->execute();

                // Redirect to a success page or login page after successful registration
                header("Location: signup-success.html"); // Create a simple success page
                exit();
            }
        } catch (PDOException $e) {
            // Display a generic error message for other database issues
            $generalError = "Error: Could not register the account. Please try again later.";
            // For debugging, you might want to log the actual error: error_log($e->getMessage());
        }
    }
}
?>