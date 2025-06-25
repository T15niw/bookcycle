<?php
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

// --- INITIALIZE MESSAGE VARIABLES ---
$message = '';
$message_type = '';

// --- HANDLE FORM SUBMISSION ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- 1. HANDLE FILE UPLOAD ---
    $uploaded_file_path = NULL; 

    if (isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] == 0) {
        $upload_dir = 'uploads/';
        $unique_name = uniqid() . '-' . basename($_FILES['uploaded_file']['name']);
        $target_file = $upload_dir . $unique_name;
        
        if (!move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $target_file)) {
            $message = "Sorry, there was an error uploading your file.";
            $message_type = "error";
        } else {
            $uploaded_file_path = $target_file;
        }
    }

    // --- 2. PROCESS THE REST OF THE FORM (if no file upload error) ---
    if (empty($message)) {
        
        // Get all the data from the form
        $collaboration_type = $_POST['collaboration_type']; // will be 'partnership' or 'volunteering'
        $full_name = trim($_POST['full_name']);
        $phone_number = trim($_POST['phone_number']);
        $email = trim($_POST['email']);
        $contact_method = $_POST['contact_method']; // will be 'calls', 'whatsapp', etc.
        $city = trim($_POST['city']);
        $user_message = trim($_POST['message']);

        try {
            // --- 3. THE CORE LOGIC: CHOOSE THE SQL BASED ON COLLABORATION TYPE ---
            if ($collaboration_type === 'volunteering') {
                // --- PREPARE TO INSERT INTO 'volunteers' TABLE ---
                $sql = "INSERT INTO volunteers (email_volunteer_ID, full_name, phone_number, preferred_contact_method, city, type_of_collaboration, desired_role, how_often_can_you_volunteer, uploaded_file, message) 
                        VALUES (:email, :name, :phone, :contact, :city, :collab_type, :role, :availability, :file, :msg)";
                
                $stmt = $conn->prepare($sql);
                
                // Bind the fields specific to volunteers
                $stmt->bindParam(':role', $_POST['desired_role']);
                $stmt->bindParam(':availability', $_POST['availability']);

            } elseif ($collaboration_type === 'partnership') {
                // --- PREPARE TO INSERT INTO 'partners' TABLE ---
                $sql = "INSERT INTO partners (email_partner_ID, full_name, phone_number, preferred_contact_method, city, type_of_collaboration, company_name, field_of_activity, uploaded_file, message) 
                        VALUES (:email, :name, :phone, :contact, :city, :collab_type, :company, :activity, :file, :msg)";
                
                $stmt = $conn->prepare($sql);
                
                // Bind the fields specific to partners
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
                $stmt->bindParam(':collab_type', $collaboration_type); // This now correctly uses the value from the form
                $stmt->bindParam(':file', $uploaded_file_path);
                $stmt->bindParam(':msg', $user_message);
                
                $stmt->execute();
                
                $message = "Thank you! Your submission has been received.";
                $message_type = "success";
            } else {
                 $message = "An invalid collaboration type was selected.";
                 $message_type = "error";
            }

        } catch (PDOException $e) {
            $message = "A submission with this email address already exists.";
            $message_type = "error";
            // For debugging: error_log($e->getMessage());
        }
    }
}
?>