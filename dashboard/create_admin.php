<?php
// Your database connection code here
$host = 'localhost'; $dbname = 'bookcycle'; $user = 'root'; $password = '';
$conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

// --- CONFIGURE YOUR NEW ADMIN ---
$admin_email = 'tasnim@bookcycle.com';
$admin_plain_password = '12345book'; 
$admin_name = 'Tasnim'

// --- HASH THE PASSWORD ---
$hashed_password = password_hash($admin_plain_password, PASSWORD_DEFAULT);

// --- INSERT INTO DATABASE ---
try {
    $sql = "INSERT INTO admin (email_admin_ID, password, admin_name) VALUES (:email, :password, :name)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $admin_email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':name', $admin_name);
    $stmt->execute();
    echo "Admin user created successfully with a hashed password!";
} catch (PDOException $e) {
    die("Error creating admin: " . $e->getMessage());
}
?>