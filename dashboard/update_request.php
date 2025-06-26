<?php
$host = 'localhost';
$dbname = 'bookcycle';
$user = 'root';
$password = ''; 

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: ");
}

// Set the header to indicate a JSON response
header('Content-Type: application/json');

// Check if it's a POST request with an action
if ($_SERVER["REQUEST_METHOD"] != "POST" || empty($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit();
}

$response = ['success' => false, 'message' => 'An unknown error occurred.'];

try {
    $action = $_POST['action'];
    $request_id = $_POST['request_id'];

    if ($action == 'update_status') {
        $status = $_POST['status'];
        $stmt = $conn->prepare("UPDATE request_form SET status = :status WHERE request_ID = :id");
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        $stmt->bindParam(':id', $request_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $response = ['success' => true];
        } else {
            $response['message'] = 'Failed to update status in the database.';
        }

    } elseif ($action == 'update_price') {
        $price = $_POST['price'];
        $stmt = $conn->prepare("UPDATE request_form SET books_price = :price WHERE request_ID = :id");
        $stmt->bindParam(':price', $price, PDO::PARAM_STR);
        $stmt->bindParam(':id', $request_id, PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            $response = ['success' => true];
        } else {
            $response['message'] = 'Failed to update the price in the database.';
        }
    } else {
        $response['message'] = 'Unknown action.';
    }

} catch (PDOException $e) {
    // For debugging, you might want to see the real error
    // error_log($e->getMessage()); 
    $response['message'] = 'A database error occurred.'; 
}

echo json_encode($response);
exit(); ?>