<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Requests</title>
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

.requests-table {
    width: 100%;
}

.table-header, .row-main {
    display: grid;
    grid-template-columns: 0.5fr 1.5fr 1.2fr 1.2fr 1.2fr 1fr 0.5fr;
    align-items: center;
    gap: 16px;
    padding: 0 24px;
}

.table-header {
    margin-bottom: 15px;
}

.header-cell {
    color: var(--text-secondary, #414142);
    font-size: 13px;
    font-weight: 500;
    padding: 10px 0;
}
.actions-header {
    grid-column: 7;
}

.table-body {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.table-row-wrapper {
    background-color: var(--background-main, #ffffff);
    border-radius: 12px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.05);
    transition: box-shadow 0.3s ease;
    overflow: hidden;
}

.row-main {
    padding: 16px 24px;
}

.table-cell {
    font-size: 15px;
    color: var(--text-primary, black);
    font-weight: 500;
}
.client-name-link {
    color: #238649;
    text-decoration: underline;
    cursor: pointer;
    font-weight: 600;
}
.client-name-link:hover {
    color: #1a6b39;
}

.status-pill {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 500;
    text-align: center;
}
.status-collected { background-color: rgba(50, 235, 42, 0.15); color: #238649; }
.status-processing { background-color: rgba(91, 147, 255, 0.15); color: #5B93FF; }
.status-cancelled { background-color: rgba(255, 0, 0, 0.1); color: #FF0000; }
.status-in-transit { background-color: rgba(98, 38, 239, 0.15); color: #6226EF; }

.row-actions {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 16px;
}
.icon {
    cursor: pointer;
    transition: transform 0.2s ease;
}
.icon:hover {
    transform: scale(1.1);
}
.chevron-icon {
    transition: transform 0.3s ease-in-out;
}
.table-row-wrapper.expanded .chevron-icon {
    transform: rotate(180deg);
}

/* Expanded Row Details */
.row-details {
    max-height: 0;
    opacity: 0;
    overflow: hidden;
    transition: max-height 0.5s ease-in-out, opacity 0.5s ease-in-out, padding 0.5s ease-in-out;
    background-color: #FAFAFA; /* The light gray tray background */
    padding: 0 24px;
    border-top: 1px solid #EFF0F6;
}
.table-row-wrapper.expanded .row-details {
    max-height: 500px; /* Adjust if content is taller */
    opacity: 1;
    padding: 24px;
}
.detail-group {
    margin-bottom: 20px;
}
.detail-group:last-child {
    margin-bottom: 0;
}
.detail-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 8px;
    color: var(--text-secondary);
}

/* This is the new rule that styles the textarea */
.detail-textarea {
    width: 100%;
    padding: 14px 16px;
    font-family: "Lexend", sans-serif;
    font-size: 14px;
    line-height: 1.6;
    color: var(--text-secondary, #414142);
    background-color: var(--background-main, #ffffff);
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 8px;
    box-sizing: border-box;
    resize: vertical; /* Allows user to resize the height */
}
.detail-input {
    width: 100%;
    padding: 14px 16px;
    font-family: "Lexend", sans-serif;
    font-size: 14px;
    line-height: 1.6;
    color: var(--text-secondary, #414142);
    background-color: var(--background-main, #ffffff);
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 8px;
    box-sizing: border-box;
}

.detail-textarea:read-only .detail-input:read-only {
    background-color: #F9F9F9; /* A slightly off-white to show it's readonly */
    cursor: default;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s ease, visibility 0.3s ease;
    z-index: 1000;
}
.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}
.modal-content {
    background-color: white;
    padding: 30px 40px;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    position: relative;
    transform: translateY(-20px);
    transition: transform 0.3s ease;
}
.modal-overlay.active .modal-content {
    transform: translateY(0);
}
.modal-close {
    position: absolute;
    top: 15px;
    right: 15px;
    background: none;
    border: none;
    font-size: 28px;
    line-height: 1;
    cursor: pointer;
    color: #888;
}
.modal-content h2 {
    margin-top: 0;
    margin-bottom: 25px;
    font-size: 22px;
}
.modal-form-display {
    display: flex;
    flex-direction: column;
    gap: 18px;
}
.modal-form-group label {
    font-size: 13px;
    color: var(--text-secondary);
    margin-bottom: 6px;
    display: block;
}
.modal-form-group input {
    width: 93%;
}
.modal-form-value {
    background-color: #F9F9F9;
    border: 1px solid var(--border-color,rgb(135, 136, 136));
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 15px;
    font-weight: 500;
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
                    <li><a href="requests.php"><img src="../Icons/Dashboard/requests.png" alt=""><span>Requests</span></a></li>
                    <li><a href="clients.php"><img src="../Icons/Dashboard/utilisateur.png" alt=""><span>Clients</span></a></li>
                    <li class="active"><a href="volunteers.php"><img src="../Icons/Dashboard/icons8-bénévolat-100.png" alt=""><span>Volunteers</span></a></li>
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
        <h1>Received requests</h1>
        <hr>
    </header>

    <div class="requests-table">
        <!-- Table Header -->
        <div class="table-header">
            <div class="header-cell">ID</div>
            <div class="header-cell">Name</div>
            <div class="header-cell">Category</div>
            <div class="header-cell">Quantity</div>
            <div class="header-cell">Pickup date</div>
            <div class="header-cell">Status</div>
            <div class="header-cell actions-header"></div>
        </div>

        <!-- Table Body -->
        <div class="table-body">
            
            <!-- Row 1: Collected (Green) -->
            <div class="table-row-wrapper">
                <div class="row-main">
                    <div class="table-cell">0001</div>
                    <div class="table-cell"><a href="#" class="client-name-link">Christine Brooks</a></div>
                    <div class="table-cell">Notebooks</div>
                    <div class="table-cell">10 - 50 book</div>
                    <div class="table-cell">04 Sep 2026</div>
                    <div class="table-cell"><span class="status-pill status-collected">Collected</span></div>
                    <div class="table-cell row-actions">
                        <!-- Add your bin icon here -->
                       <img src="../Icons/Dashboard/icons8-delete-100.png" alt="Delete" class="bin icon">
                        <svg class="icon chevron-icon expand-trigger" width="24" height="24" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6" stroke="#4A4A4A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                    </div>
                </div>
                <div class="row-details">
                    <div class="detail-group">
                        <label for="pickup-address-0001">Pickup address</label>
                        <input id="pickup-address-0001" class="detail-input" readonly rows="2" value="Address for Christine Brooks...">
                    </div>
                    <div class="detail-group">
                        <label for="notes-0001">Additional notes</label>
                        <textarea id="notes-0001" class="detail-textarea" readonly rows="4">Notes for Christine Brooks...</textarea>
                    </div>
                </div>
            </div>

            <!-- Row 2: Processing (Blue) -->
            <div class="table-row-wrapper">
                <div class="row-main">
                    <div class="table-cell">0002</div>
                    <div class="table-cell"><a href="#" class="client-name-link">Rosie Pearson</a></div>
                    <div class="table-cell">Books</div>
                    <div class="table-cell">10 - 50 book</div>
                    <div class="table-cell">28 May 2026</div>
                    <div class="table-cell"><span class="status-pill status-processing">Processing</span></div>
                    <div class="table-cell row-actions">
                        <!-- Add your bin icon here -->
                       <img src="../Icons/Dashboard/icons8-delete-100.png" alt="Delete" class="bin icon">
                        <svg class="icon chevron-icon expand-trigger" width="24" height="24" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6" stroke="#4A4A4A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                    </div>
                </div>
                <div class="row-details">
                    <div class="detail-group">
                        <label for="pickup-address-0002">Pickup address</label>
                        <input id="pickup-address-0002" class="detail-input" readonly rows="2" value="Address for Christine Brooks...">
                    </div>
                    <div class="detail-group">
                        <label for="notes-0002">Additional notes</label>
                        <textarea id="notes-0002" class="detail-textarea" readonly rows="4">Notes for Rosie Pearson...</textarea>
                    </div>
                </div>
            </div>

            <!-- Row 3: Cancelled (Red) -->
            <div class="table-row-wrapper">
                <div class="row-main">
                    <div class="table-cell">0003</div>
                    <div class="table-cell"><a href="#" class="client-name-link">Darrell Caldwell</a></div>
                    <div class="table-cell">books</div>
                    <div class="table-cell">10 - 50 book</div>
                    <div class="table-cell">23 Nov 2026</div>
                    <div class="table-cell"><span class="status-pill status-cancelled">Cancelled</span></div>
                    <div class="table-cell row-actions">
                        <!-- Add your bin icon here -->
                       <img src="../Icons/Dashboard/icons8-delete-100.png" alt="Delete" class="bin icon">
                        <svg class="icon chevron-icon expand-trigger" width="24" height="24" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6" stroke="#4A4A4A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                    </div>
                </div>
                 <div class="row-details">
                    <div class="detail-group">
                        <label for="pickup-address-0003">Pickup address</label>
                        <input id="pickup-address-0003" class="detail-input" readonly rows="2" value="Address for Christine Brooks...">
                    </div>
                    <div class="detail-group">
                        <label for="notes-0003">Additional notes</label>
                        <textarea id="notes-0003" class="detail-textarea" readonly rows="4">Notes for Darrell Caldwell...</textarea>
                    </div>
                </div>
            </div>

            <!-- Row 4: In Transit (Purple) - Expanded by default for demonstration -->
            <div class="table-row-wrapper expanded">
                <div class="row-main">
                    <div class="table-cell">0010</div>
                    <div class="table-cell"><a href="#" class="client-name-link">Dollie Hines</a></div>
                    <div class="table-cell">Books</div>
                    <div class="table-cell">5 - 10 book</div>
                    <div class="table-cell">09 Jan 2026</div>
                    <div class="table-cell"><span class="status-pill status-in-transit">In Transit</span></div>
                    <div class="table-cell row-actions">
                        <!-- Add your bin icon here -->
                       <img src="../Icons/Dashboard/icons8-delete-100.png" alt="Delete" class="bin icon">
                        <svg class="icon chevron-icon expand-trigger" width="24" height="24" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6" stroke="#4A4A4A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                    </div>
                </div>
                <div class="row-details">
                    <div class="detail-group">
                        <label for="pickup-address-0010">Pickup address</label>
                        <input id="pickup-address-00010" class="detail-input" readonly rows="2" value="Address for Christine Brooks...">
                    </div>
                    <div class="detail-group">
                        <label for="notes-0010">Additional notes</label>
                        <textarea id="notes-0010" class="detail-textarea" readonly rows="4">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- Modal for Client Details -->
<div class="modal-overlay" id="client-details-modal">
    <div class="modal-content">
        <button class="modal-close" id="modal-close-button">×</button>
        <h2>Client details</h2>
        <div class="modal-form-display">
            <div class="modal-form-group">
                <label>Full name</label>
                <input class="modal-form-value" value="Dollie Hines" readonly>
            </div>
            <div class="modal-form-group">
                <label>Phone number</label>
                <input class="modal-form-value" value="+212 623-215487" readonly>
            </div>
            <div class="modal-form-group">
                <label>Email</label>
                <input class="modal-form-value" value="dolliehines@gmail.com" readonly>
            </div>
            <div class="modal-form-group">
                <label>City</label>
                <input class="modal-form-value" value="Tanger" readonly>
            </div>
             <div class="modal-form-group">
                <label>Preferred contact method</label>
                <input class="modal-form-value" value="Whatsapp" readonly>
            </div>
        </div>
    </div>
</div>

    </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    
    // --- Expand/Collapse Row Logic ---
    const tableBody = document.querySelector('.table-body');
    if (tableBody) {
        tableBody.addEventListener('click', function(event) {
            // Find the closest expand trigger (chevron icon) that was clicked
            const expandTrigger = event.target.closest('.expand-trigger');
            if (expandTrigger) {
                const rowWrapper = expandTrigger.closest('.table-row-wrapper');
                if (rowWrapper) {
                    rowWrapper.classList.toggle('expanded');
                }
            }
        });
    }

    // --- Modal Logic ---
    const modal = document.getElementById('client-details-modal');
    const closeButton = document.getElementById('modal-close-button');
    const nameLinks = document.querySelectorAll('.client-name-link');

    // Function to open the modal
    const openModal = () => {
        if (modal) {
            modal.classList.add('active');
        }
    };

    // Function to close the modal
    const closeModal = () => {
        if (modal) {
            modal.classList.remove('active');
        }
    };

    // Add click event to all client name links
    nameLinks.forEach(link => {
        link.addEventListener('click', (event) => {
            event.preventDefault(); // Prevent default link behavior
            // In a real app, you would fetch data for this specific client here
            // For now, we just open the modal with static data.
            openModal();
        });
    });

    // Close modal via close button
    if (closeButton) {
        closeButton.addEventListener('click', closeModal);
    }
    
    // Close modal by clicking on the overlay
    if (modal) {
        modal.addEventListener('click', (event) => {
            // If the click is on the overlay itself (and not the content), close it.
            if (event.target === modal) {
                closeModal();
            }
        });
    }
});
</script>
    
</body>
</html>