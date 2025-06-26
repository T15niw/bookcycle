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

// --- 1. HANDLE DELETE REQUEST ---
// This block must be before any HTML is outputted.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_partner_id'])) {
    $partner_id_to_delete = $_POST['delete_partner_id'];

    try {
        // Use the correct table name and primary key column
        $sql = "DELETE FROM partners WHERE email_partner_ID = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $partner_id_to_delete, PDO::PARAM_STR);
        $stmt->execute();

        // Redirect to the same page to prevent form resubmission on refresh
        header("Location: partners.php");
        exit();
    } catch (PDOException $e) {
        die("Error deleting record: " . $e->getMessage());
    }
}

// --- 2. FETCH PARTNER DATA ---
try {
    // Select records from the 'partners' table where the type is 'partnership'
    $stmt = $conn->prepare("SELECT * FROM partners WHERE type_of_collaboration = 'partnership' ORDER BY full_name ASC");
    $stmt->execute();
    $partners = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not fetch partners: " . $e->getMessage());
}

// Helper function to get the correct CSS class and text for the contact pill
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
    <title>Partners</title>
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
    /* --- The Fix --- */
    position: fixed; /* This is the key: it fixes the element to the viewport */
    top: 0;
    left: 0;
    height: 100vh; /* Make the sidebar always full height */
    overflow-y: auto; /* Add a scrollbar ONLY to the sidebar if its content is too long */
    width: 263px; /* We need to explicitly define the width now */
    z-index: 100; /* Ensures the sidebar stays on top of other content */

    /* --- Your existing styles (kept for consistency) --- */
    flex: 0 0 208px;
    background: var(--background-main, #FFF);
        border: 1px solid var(--Stroke-Color, #EFF0F6);
    display: flex;
    flex-direction: column;
    padding: 25px 35px 38px 18px;
    border-radius: 20px; /* Note: you might want to change this */
    box-sizing: border-box; /* Good practice to include this */
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

/* --- Main Content --- */
.main-content {
    /* --- The Fix --- */
    margin-left: 263px; /* This pushes the content to the right, creating space for the sidebar */
    
    /* --- Your existing styles (kept for consistency) --- */
    flex-grow: 1;
    padding: 40px 32px;
    background-color: #F9F9F9;
}.content-header h1 { font-size: 28px; font-weight: 700; margin: 0 0 15px 0; }
hr { margin-bottom: 20px; border: 0; border-top: 1px solid #EFF0F6; }

.expandable-table {
    width: 100%;
    border-collapse: collapse;
}

.table-header {
    display: grid;
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

.table-body {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.table-row {
    background-color: var(--background-main, #ffffff);
    border-radius: 12px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.05);
    transition: box-shadow 0.3s ease;
    overflow: hidden;
}

.row-main {
    display: grid;
    align-items: center;
    padding: 12px 20px;
    cursor: pointer;
}

/* Specific grid layout for the Partners table */
.partners-table .table-header,
.partners-table .row-main {
    grid-template-columns: 1.2fr 1fr 1.2fr 1.2fr 1.5fr 0.5fr;
}

.table-cell {
    padding: 10px 8px;
    font-size: 15px;
    color: var(--text-primary, black);
    font-weight: 500;
}

.contact-pill {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    text-align: center;
}
.pill-whatsapp { background-color: #E2F8E9; color: #25D366; }
.pill-email { background-color: #F1E4FF; color: #9116F9; }
.pill-calls { background-color: #E6EEFF; color: #5B93FF; }

.row-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 16px;
}

.icon {
    transition: transform 0.2s ease;
}

.icon:hover { transform: scale(1.1); }

.chevron-icon {
    transition: transform 0.3s cubic-bezier(0.25, 0.1, 0.25, 1);
}

.table-row.expanded .chevron-icon {
    transform: rotate(180deg);
}

/* Expansion styles */
.row-details {
    display: none;
    background-color: #F9F9F9;
    padding: 25px;
    border-top: 1px solid #EFF0F6;
    max-height: 0;
    opacity: 0;
    overflow: hidden;
    transition: max-height 0.5s ease-in-out, opacity 0.5s ease-in-out, padding 0.5s ease-in-out;
}

.table-row.expanded .row-details {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 20px 30px;
    max-height: 500px;
    opacity: 1;
    padding: 25px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.detail-item label {
    font-size: 13px;
    color: var(--text-secondary, #414142);
    font-weight: 500;
}

.detail-value {
    background-color: var(--background-main, #ffffff);
    border: 1px solid #EFF0F6;
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 14px;
    color: var(--text-primary, black);
}

.detail-item.message-item {
    grid-column: 1 / -1;
}

.message-box {
    line-height: 1.6;
    min-height: 120px;
}
.bin{
     width: 18px;
    height: 18px;
}
.delete-form { display: inline-block; line-height: 0; }
.delete-button { background: none; border: none; padding: 0; cursor: pointer; }
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
                    <li><a href="statistics.php"><img src="../Icons/Dashboard/increaseBlack.png"><span>Statistics</span></a></li>
                    <li><a href="requests.php"><img src="../Icons/Dashboard/icons8-liste-de-tâches-100.png" alt=""><span>Requests</span></a></li>
                    <li><a href="clients.php"><img src="../Icons/Dashboard/utilisateur.png" alt=""><span>Clients</span></a></li>
                    <li><a href="volunteers.php"><img src="../Icons/Dashboard/icons8-bénévolat-100.png" alt=""><span>Volunteers</span></a></li>
                    <li class="active"><a href="partners.php"><img src="../Icons/Dashboard/icons8-collaborer-en-cercle-100.png" alt=""><span>Partners</span></a></li>
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
                <h1>Partners list</h1>
                <hr>
            </header>

            <div class="partners-table expandable-table">
                <div class="table-header">
                    <div class="header-cell">Name</div>
                    <div class="header-cell">City  </div>
                    <div class="header-cell">Company name  </div>
                    <div class="header-cell">Field of activity  </div>
                    <div class="header-cell">Preferred contact method  </div>
                    <div class="header-cell actions"></div>
                </div>

                <div class="table-body">
                    <?php if (empty($partners)): ?>
                        <p style="text-align: center; padding: 20px;">No partners found.</p>
                    <?php else: ?>
                        <?php foreach ($partners as $partner): ?>
                            <?php $pill_info = get_contact_pill_info($partner['preferred_contact_method']); ?>
                            <div class="table-row">
                                <div class="row-main">
                                    <div class="table-cell"><?php echo htmlspecialchars($partner['full_name']); ?></div>
                                    <div class="table-cell"><?php echo htmlspecialchars($partner['city']); ?></div>
                                    <div class="table-cell"><?php echo htmlspecialchars($partner['company_name']); ?></div>
                                    <div class="table-cell"><?php echo htmlspecialchars($partner['field_of_activity']); ?></div>
                                    <div class="table-cell">
                                        <span class="contact-pill <?php echo $pill_info['class']; ?>">
                                            <?php echo $pill_info['text']; ?>
                                        </span>
                                    </div>
                                    <div class="table-cell row-actions">
                                        <form method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this partner?');">
                                            <input type="hidden" name="delete_partner_id" value="<?php echo htmlspecialchars($partner['email_partner_ID']); ?>">
                                            <button type="submit" class="delete-button">
                                                <img src="../Icons/Dashboard/icons8-delete-100.png" alt="Delete" class="bin icon">
                                            </button>
                                        </form>
                                        <svg class="icon chevron-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6 9L12 15L18 9" stroke="#4A4A4A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                </div>
                                <div class="row-details">
                                    <div class="detail-item">
                                        <label>Email</label>
                                        <div class="detail-value"><?php echo htmlspecialchars($partner['email_partner_ID']); ?></div>
                                    </div>
                                    <div class="detail-item">
                                        <label>Phone number</label>
                                        <div class="detail-value"><?php echo htmlspecialchars($partner['phone_number']); ?></div>
                                    </div>
                                    <div class="detail-item">
                                        <label>Uploaded file</label>
                                        <div class="detail-value">
                                            <?php if (!empty($partner['uploaded_file'])): ?>
                                                <a href="uploads/<?php echo htmlspecialchars($partner['uploaded_file']); ?>" target="_blank">
                                                    <?php echo htmlspecialchars($partner['uploaded_file']); ?>
                                                </a>
                                            <?php else: ?>
                                                No file uploaded
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="detail-item message-item">
                                        <label>Message</label>
                                        <div class="detail-value message-box">
                                            <?php echo nl2br(htmlspecialchars($partner['message'])); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('.table-body');

    tableBody.addEventListener('click', function(event) {
        // We only care about clicks on the chevron icon
        const expandTrigger = event.target.closest('.chevron-icon');
        
        if (expandTrigger) {
            const tableRow = expandTrigger.closest('.table-row');
            if (tableRow) {
                tableRow.classList.toggle('expanded');
            }
        }
    });
});
</script>
</body>
</html>