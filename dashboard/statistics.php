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

// --- Function to get row count from a table ---
// Using a WHERE clause is optional but useful for tables like partners/volunteers
function get_table_count($pdo, $table_name, $where_clause = '') {
    try {
        $sql = "SELECT COUNT(*) FROM " . $table_name;
        if (!empty($where_clause)) {
            $sql .= " WHERE " . $where_clause;
        }
        $stmt = $pdo->query($sql);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        // In a real application, you should log this error instead of dying
        // For now, we'll return 0 to prevent breaking the page.
        error_log("Count failed for table $table_name: " . $e->getMessage());
        return 0;
    }
}

// --- Calculate all statistics ---
$total_users = get_table_count($conn, 'client');
$total_requests = get_table_count($conn, 'request_form');

// For partners and volunteers, we need to count based on the 'type_of_collaboration' column
// This assumes 'partners' and 'volunteers' might be in the same table in the future,
// but based on your schema, they are in separate tables with a discriminator column.
// We will query the correct table with the correct condition.
$total_partners = get_table_count($conn, 'partners', "type_of_collaboration = 'partnership'");
$total_volunteers = get_table_count($conn, 'volunteers', "type_of_collaboration = 'volunteering'");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
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
body {
    margin: 0;
    font-family: "Lexend", sans-serif;
    background-color: #F9F9F9;
    color: var(--text-primary);
}
.dashboard {
    min-height: 100vh;
}
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    overflow-y: auto;
    width: 263px;
    z-index: 100;
    background: var(--background-main, #FFF);
    border-right: 1px solid var(--border-color, #EFF0F6);
    display: flex;
    flex-direction: column;
    padding: 25px 35px 38px 18px;
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
.sidebar-nav li a:hover , .sidebar-footer li a:hover {
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
.main-content {
    margin-left: 263px;
    flex-grow: 1;
    padding: 40px 32px;
    background-color: #F9F9F9;
}
.content-header h1 { font-size: 28px; font-weight: 700; margin: 0 0 15px 0; }
hr { margin-bottom: 20px; border: 0; border-top: 1px solid #EFF0F6; }
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 24px;
    margin-top: 20px;
}
.stat-card {
    background-color: var(--background-main, #ffffff);
    border-radius: 16px;
    padding: 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid var(--border-color, #EFF0F6);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
}
.stat-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.stat-label {
    font-size: 15px;
    color: var(--text-secondary, #414142);
    font-weight: 500;
}
.stat-value {
    font-size: 36px;
    font-weight: 700;
    color: var(--text-primary, black);
}
.stat-icon-wrapper {
    background-color: rgba(50, 235, 42, 0.20);
    width: 64px;
    height: 64px;
    border-radius: 14px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.stat-icon-wrapper img {
    width: 32px;
    height: 32px;
}
    </style>
</head>
<body>

    <div class="dashboard">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../logo/Logo black shadow.png"class="logo">
            </div>
            <nav class="sidebar-nav">
                <ul>
                    <li class="active"><a href="statistics.php"><img src="../Icons/Dashboard/increaseGreen (1).png" alt=""><span>Statistics</span></a></li>
                    <li><a href="requests.php"><img src="../Icons/Dashboard/icons8-liste-de-tâches-100.png" alt=""><span>Requests</span></a></li>
                    <li><a href="clients.php"><img src="../Icons/Dashboard/utilisateur.png" alt=""><span>Clients</span></a></li>
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
                <h1>Statistiques</h1>
                <hr>
            </header>

            <div class="stats-container">
                <!-- Stat Card 1: Total Users (Clients) -->
                <div class="stat-card">
                    <div class="stat-info">
                        <span class="stat-label">Total Users</span>
                        <span class="stat-value"><?php echo $total_users; ?></span>
                    </div>
                    <div class="stat-icon-wrapper">
                        <img src="../Icons/Dashboard/utilisateur.png" alt="Users Icon">
                    </div>
                </div>

                <!-- Stat Card 2: Total Requests -->
                <div class="stat-card">
                    <div class="stat-info">
                        <span class="stat-label">Total Requests</span>
                        <span class="stat-value"><?php echo $total_requests; ?></span>
                    </div>
                    <div class="stat-icon-wrapper">
                        <img src="../Icons/Dashboard/icons8-liste-de-tâches-100.png" alt="Requests Icon">
                    </div>
                </div>

                <!-- Stat Card 3: Total Partners -->
                <div class="stat-card">
                    <div class="stat-info">
                        <span class="stat-label">Total Partners</span>
                        <span class="stat-value"><?php echo $total_partners; ?></span>
                    </div>
                    <div class="stat-icon-wrapper">
                        <img src="../Icons/Dashboard/icons8-collaborating-in-circle-100.png" alt="Partners Icon">
                    </div>
                </div>

                <!-- Stat Card 4: Total Volunteers -->
                <div class="stat-card">
                    <div class="stat-info">
                        <span class="stat-label">Total Volunteers</span>
                        <span class="stat-value"><?php echo $total_volunteers; ?></span>
                    </div>
                    <div class="stat-icon-wrapper">
                        <img src="../Icons/Dashboard/icons8-bénévolat-100.png" alt="Volunteers Icon">
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>