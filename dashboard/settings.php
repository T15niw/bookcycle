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
    display: flex;
    min-height: 100vh;
}
.sidebar {
    flex: 0 0 208px;
    border: 1px solid var(--Stroke-Color, #EFF0F6);
    background: var(--Base-White-100, #FFF);
    display: flex;
    flex-direction: column;
    padding: 25px 35px 38px 18px;
    border-radius: 20px;
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
    flex-grow: 1;
    padding: 40px 32px;
    background-color: #F9F9F9;
}
.content-header h1 {
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 15px 0;
}
.filter-controls {
    display: flex;
    gap: 55px;
    margin-bottom: 24px;
}
.filter-group {
    position: relative;
}
.filter-group label {
    font-size: 12px;
    font-weight: 300;
    color: var(--text-secondary);
    position: absolute;
    top: -10px;
    left: 8px;
    padding: 32px 4px;
}
.filter-group select {
    padding: 8px 32px 8px 12px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    margin-top: 15px;
    width: 100px;
    font-family: 'Inter', sans-serif;
    font-size: 0.9rem;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%236b7280' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
}

/* --- Table --- */
.table-container {
    background-color: var(--background-main);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    overflow: hidden;
}
table {
    width: 100%;
    border-collapse: collapse;
}
th, td {
    padding: 16px 24px;
    text-align: left;
    font-size: 0.9rem;
}
th {
    color: var(--text-secondary);
    font-weight: 500;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.5px;
}
tbody tr.data-row {
    border-bottom: 1px solid var(--border-color);
    transition: background-color 0.2s ease;
    cursor: pointer;
}
tbody tr.data-row:last-child {
    border-bottom: none;
}
tbody tr.data-row:hover {
    background-color: var(--background-light);
}
tbody tr.active-row {
    background-color: #9dfd9a; /* Light blue to indicate active */
}

/* --- Tags/Pills --- */
.tag {
    display: inline-block;
    padding: 6px 18px;
    border-radius: 20px;
    font-weight: 400;
    font-size: 14px;
}
.tag-whatsapp { background-color: #e8f5e9; color: #25D366; }
.tag-email { background-color: #e3f2fd; color: #5B93FF; }
.tag-calls { background-color: #f3e5f5; color: #9116F9; }

/* --- Action Buttons --- */
.action-cell {
    display: flex;
    gap: 8px;
}
.icon-button {
    background: none;
    border: none;
    cursor: pointer;
    padding: 4px;
}
.icon-button img {
    width: 18px;
    height: 18px;
}

/* --- Expandable Detail View --- */
.detail-row.hidden {
    display: none;
}
.detail-row td {
    padding: 0;
    background-color: #b0ffaf2c;
}
.detail-content {
    padding: 24px;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 12px;
}
.detail-item {
    background-color: #fff;
    padding: 16px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
}
.detail-item.full-width {
    grid-column: 1 / -1;
}
.detail-item label {
    display: block;
    font-size: 0.8rem;
    font-weight: 400;
    color: #747474;
    margin-bottom: 8px;
}
.detail-item p {
    margin: 0;
    font-size: 0.9rem;
    color: var(--text-primary);
}
hr{
    margin-bottom: 10px;
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
                    <li><a href="statistics.php"><img src="../Icons/Dashboard/" alt=""><span>Statistics</span></a></li>
                    <li><a href="requests.php"><img src="../Icons/Dashboard/icons8-liste-de-tâches-100.png" alt=""><span>Requests</span></a></li>
                    <li><a href="clients.php"><img src="../Icons/Dashboard/utilisateur.png" alt=""><span>Clients</span></a></li>
                    <li class="active"><a href="volunteers.php"><img src="../Icons/Dashboard/volunteer.png" alt=""><span>Volunteers</span></a></li>
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
                <h1>Profile</h1>
                <hr>
            </header>

        </main>
    </div>

    <!-- Link to your JavaScript file -->
    <script>document.addEventListener('DOMContentLoaded', function() {
    // Select all the main data rows in the table
    const dataRows = document.querySelectorAll('.data-row');

    // Add a click event listener to each data row
    dataRows.forEach(row => {
        row.addEventListener('click', () => {
            // Find the detail row that immediately follows the clicked data row
            const detailRow = row.nextElementSibling;
            
            // Check if the clicked row is already active
            const isAlreadyActive = row.classList.contains('active-row');

            // First, close all other open rows
            document.querySelectorAll('.data-row').forEach(r => r.classList.remove('active-row'));
            document.querySelectorAll('.detail-row').forEach(d => d.classList.add('hidden'));

            // If the clicked row was NOT already active, open its details
            if (!isAlreadyActive) {
                row.classList.add('active-row');
                if (detailRow && detailRow.classList.contains('detail-row')) {
                    detailRow.classList.remove('hidden');
                }
            }
        });
    });
});</script>
</body>
</html>