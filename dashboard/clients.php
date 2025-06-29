<?php

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

// delete client
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_client_id'])) {
    $client_id_to_delete = $_POST['delete_client_id'];

    try {
        $sql = "DELETE FROM client WHERE email_client_ID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $client_id_to_delete, PDO::PARAM_STR);
        $stmt->execute();

        //redirect to the same page
        header("Location: clients.php");
        exit();
    } catch (PDOException $e) {
        // error 404
        die("Error deleting record: " . $e->getMessage());
    }
}


// fetch client data
try {
    // select all client data 
    $stmt = $conn->prepare("SELECT * FROM client ORDER BY first_name, last_name ASC");
    $stmt->execute();
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not fetch clients: " . $e->getMessage());
}

// Correct CSS style class
function get_contact_pill_info($method) {
    switch (strtolower($method)) {
        case 'whatsapp':
            return ['class' => 'pill-whatsapp', 'text' => 'Whatsapp'];
        case 'emails':
            return ['class' => 'pill-email', 'text' => 'Email'];
        case 'calls':
            return ['class' => 'pill-calls', 'text' => 'Calls'];
        default:
            return ['class' => '', 'text' => $method];
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients</title>
    <link rel="icon" href="../logo/bookcycle.png" type="image/x-icon" />
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&family=Lexend:wght@100..900&display=swap');
    :root {
                --primary-green: #32eb2a;
                --light-green-bg: rgba(50, 235, 42, 0.30);
                --text-primary: black;
                --text-secondary: #414142;
                --border-color: #e5e7eb;
                --background-main: #ffffff;
            }
    body { margin: 0; font-family: "Lexend", sans-serif; background-color: #F9F9F9; color: var(--text-primary); }
    .dashboard { 
        min-height: 100vh; 
    }
/*******************SideBar****************************** */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        overflow-y: auto;
        width: 263px;
        z-index: 100;
        flex: 0 0 208px;
        background: var(--background-main, #FFF);
        border: 1px solid var(--Stroke-Color, #EFF0F6);
        display: flex;
        flex-direction: column;
        padding: 25px 35px 38px 18px;
        border-radius: 20px;
        box-sizing: border-box;
    }        
    .logo { 
        margin-top: 10px; 
        margin-bottom: 15px; 
        margin-left: 18px; 
        height: 45px; 
    }        
    .sidebar-nav { 
        flex-grow: 1; 
    }
    .sidebar ul { 
        list-style: none; 
        padding: 0; 
        margin: 0; 
    }
    .sidebar-nav li a, .sidebar-footer li a { 
        display: flex; 
        align-items: center; 
        gap: 12px; 
        padding: 12px 16px; 
        border-radius: 5px; 
        text-decoration: none; 
        color: var(--text-secondary); 
        font-size: 16px; 
        font-weight: 500; 
        transition: background-color 0.2s ease; 
    }
    .sidebar-nav li a:hover, .sidebar-footer li a:hover { 
        background-color: #F9F9F9; 
        color: var(--text-primary); 
    }
    .sidebar-nav li.active a { 
        background-color: var(--light-green-bg); 
        color: var(--primary-green); 
    }
    .sidebar-nav img, .sidebar-footer img { 
        width: 30px; 
        height: 30px; 
    }
/**********************Mian content******************* */
    .main-content {
        margin-left: 263px;
        flex-grow: 1;
        padding: 40px 32px;
        background-color: #F9F9F9;
    }        
    .content-header h1 { 
        font-size: 28px; 
        font-weight: 700; 
        margin: 0 0 15px 0; 
    }
    hr { 
        margin-bottom: 20px; 
        border: 0; 
        border-top: 1px solid #EFF0F6; 
    }

/***********************clients table************************ */
    .clients-table {
        width: 100%;
    }
    .table-header,
    .table-row {
        display: grid;
        align-items: center;
        grid-template-columns: 1.2fr 1.8fr 1.2fr 1fr 1.5fr 0.3fr;
    }

    .table-header {
        padding: 0 20px;
        margin-bottom: 15px;
    }
    .header-cell {
        color: var(--text-secondary, #414142);
        font-size: 14px;
        font-weight: 500;
        text-align: left;
        padding: 10px 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .header-cell.actions {
        justify-content: flex-end;
    }
    .table-body {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .table-row {
        background-color: var(--background-main, #ffffff);
        border-radius: 12px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.05);
        padding: 12px 20px;
        transition: box-shadow 0.2s ease-in-out;
    }
    .table-row:hover {
        box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.07);
    }
    .table-cell {
        padding: 10px 8px;
        font-size: 15px;
        color: var(--text-primary, black);
        font-weight: 500;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .contact-pill {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
        text-align: center;
    }
    .pill-whatsapp {
        background-color: #E2F8E9;
        color: #25D366;
    }
    .pill-email {
        background-color: #F1E4FF;
        color: #9116F9;
    }
    .pill-calls {
        background-color: #E6EEFF;
        color: #5B93FF;
    }

    .row-actions {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }
    .icon.bin {
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .bin:hover {
        transform: scale(1.1);
    }
    .bin{
        width: 18px;
        height: 18px;
    }
    .delete-form { 
        display: inline-block; 
        line-height: 0; 
    }
    .delete-button { 
        background: none; 
        border: none; 
        padding: 0; 
        cursor: pointer; 
    }

    </style>
</head>
<body>
    <div class="dashboard">
        <!-- sidebar  -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="../logo/Logo black shadow.png"class="logo">
        </div>
        <nav class="sidebar-nav">
            <ul>
                <li><a href="statistics.php"><img src="../Icons/Dashboard/increaseBlack.png"><span>Statistics</span></a></li>
                <li><a href="requests.php"><img src="../Icons/Dashboard/icons8-liste-de-tâches-100.png" alt=""><span>Requests</span></a></li>
                <li class="active"><a href="clients.php"><img src="../Icons/Dashboard/users.png" alt=""><span>Clients</span></a></li>
                <li><a href="volunteers.php"><img src="../Icons/Dashboard/icons8-bénévolat-100.png" alt=""><span>Volunteers</span></a></li>
                <li><a href="partners.php"><img src="../Icons/Dashboard/icons8-collaborating-in-circle-100.png" alt=""><span>Partners</span></a></li>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <ul>
                <li><a href="settings.php"><img src="../Icons/Dashboard/icons8-settings-100.png" alt=""><span>Settings</span></a></li>
                <li><a href="admin_logOut.php"><img src="../Icons/Dashboard/icons8-sortie-100.png" alt=""><span>Logout</span></a></li>
            </ul>
        </div>
    </aside>

         <main class="main-content">
            <header class="content-header">
                <h1>Clients list</h1>
                <hr>
            </header>

            <!-- Clients table  -->
            <div class="clients-table">
                <div class="table-header">
                    <div class="header-cell">Name </div>
                    <div class="header-cell">Email  </div>
                    <div class="header-cell">Phone number  </div>
                    <div class="header-cell">City  </div>
                    <div class="header-cell">Preferred contact method  </div>
                    <div class="header-cell actions"></div>
                </div>

                <div class="table-body">
                    <?php if (empty($clients)): ?>
                        <div class="table-row">
                            <p style="grid-column: 1 / -1; text-align: center; padding: 20px;">No clients found.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($clients as $client): ?>
                            <?php $pill_info = get_contact_pill_info($client['preferred_contact_method']); ?>
                            <div class="table-row">
                                <div class="table-cell"><?php echo htmlspecialchars($client['first_name'] . ' ' . $client['last_name']); ?></div>
                                <div class="table-cell"><?php echo htmlspecialchars($client['email_client_ID']); ?></div>
                                <div class="table-cell"><?php echo htmlspecialchars($client['phone_number']); ?></div>
                                <div class="table-cell"><?php echo htmlspecialchars($client['city']); ?></div>
                                <div class="table-cell">
                                    <span class="contact-pill <?php echo $pill_info['class']; ?>">
                                        <?php echo $pill_info['text']; ?>
                                    </span>
                                </div>
                                <div class="table-cell row-actions">
                                    <form method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this client?');">
                                        <input type="hidden" name="delete_client_id" value="<?php echo htmlspecialchars($client['email_client_ID']); ?>">
                                        <button type="submit" class="delete-button">
                                            <img src="../Icons/Dashboard/icons8-delete-100.png" alt="Delete" class="bin icon">
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    
</body>
</html>