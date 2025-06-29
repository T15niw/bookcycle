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

// dlete a request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_request_id'])) {
    try {
        $stmt = $conn->prepare("DELETE FROM request_form WHERE request_ID = :id");
        $stmt->bindParam(':id', $_POST['delete_request_id'], PDO::PARAM_INT);
        $stmt->execute();
        header("Location: requests.php");
        exit();
    } catch (PDOException $e) {
        die("Error deleting request: " . $e->getMessage());
    }
}

// fetcha requests data for display
try {
    // get client details along with each request 
    $sql = "SELECT r.*, c.first_name, c.last_name, c.phone_number, c.city, c.preferred_contact_method 
            FROM request_form r
            LEFT JOIN client c ON r.email_client_ID = c.email_client_ID
            ORDER BY r.request_ID DESC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not fetch requests: " . $e->getMessage());
}

// appropriate Css style for pills
function get_status_class($status) {
    $status = strtolower(str_replace(' ', '-', $status));
    if ($status === 'canceled') $status = 'cancelled';
    
    $classes = [
        'collected' => 'status-collected',
        'processing' => 'status-processing',
        'cancelled' => 'status-cancelled',
        'in-transit' => 'status-in-transit',
        'scheduled' => 'status-scheduled'
    ];
    return $classes[$status] ?? '';
}

$status_options = ['processing', 'scheduled', 'in transit', 'collected', 'canceled'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Received Requests</title>
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
            margin: 0; font-family: "Lexend", sans-serif; 
            background-color: #F9F9F9; 
            color: var(--text-primary); }
        .dashboard { 
            min-height: 100vh; 
        }
        /****sidebar*********************** */
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
        /*********main content************ */
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
        /*********requests table******************** */
        .requests-table { 
            width: 100%; 
        }
        .table-header, .row-main { 
            display: grid; 
            grid-template-columns: 0.5fr 1.5fr 1.2fr 1.2fr 1.2fr 1.2fr 1fr 0.5fr; 
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
        .status-select { 
            -webkit-appearance: none; 
            -moz-appearance: none; 
            appearance: none; 
            border: none; 
            background-color: transparent; 
            padding: 6px 16px; 
            border-radius: 20px; 
            font-size: 13px; 
            font-weight: 500; 
            text-align: center; 
            cursor: pointer; 
            transition: background-color 0.2s, color 0.2s; 
        }
        .status-select:focus { 
            outline: none; 
            box-shadow: 0 0 0 2px rgba(0,0,0,0.1); 
        }
        .status-collected { 
            background-color: rgba(50, 235, 42, 0.15); 
            color: #238649; 
        }
        .status-processing { 
            background-color: rgba(91, 147, 255, 0.15); 
            color: #5B93FF; 
        }
        .status-cancelled { 
            background-color: rgba(255, 0, 0, 0.1); 
            color: #FF0000; 
        }
        .status-in-transit { 
            background-color: rgba(98, 38, 239, 0.15); 
            color: #6226EF; 
        }
        .status-scheduled { 
            background-color: rgba(255, 165, 0, 0.15); 
            color: #FFA500; 
        }
        .price-input { 
            border: 1px solid var(--border-color); 
            border-radius: 6px; 
            padding: 6px 10px; 
            width: 90px; 
            text-align: right; 
            font-family: "Lexend", sans-serif; 
            font-size: 14px; 
        }
        .price-input:focus { 
            border-color: #238649; 
            outline: none; 
        }
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
        .row-details { 
            max-height: 0; 
            opacity: 0; 
            overflow: hidden; 
            transition: max-height 0.5s ease-in-out, opacity 0.5s ease-in-out, padding 0.5s ease-in-out; 
            background-color: #FAFAFA; 
            padding: 0 24px; 
            border-top: 1px solid #EFF0F6; 
        }
        .table-row-wrapper.expanded .row-details { 
            max-height: 500px; 
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
        .detail-textarea { 
            width: 100%; 
            padding: 14px 16px; 
            font-family: "Lexend", sans-serif; 
            font-size: 14px; 
            line-height: 1.6; 
            color: var(--text-secondary, #414142); 
            background-color: #F9F9F9; 
            border: 1px solid var(--border-color, #e5e7eb); 
            border-radius: 8px; 
            box-sizing: border-box; 
            resize: vertical; 
            cursor: default; 
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
            background-color: #F9F9F9;
            cursor: default;
        }
        /*****************clients details modal**************** */
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
        .modal-form-value { 
            background-color: #F9F9F9; 
            border: 1px solid var(--border-color,rgb(229, 231, 235)); 
            padding: 12px 16px; 
            border-radius: 8px; 
            font-size: 15px; 
            font-weight: 500; 
            width: 100%; 
            box-sizing: border-box; 
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
        .bin.icon { 
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
                <li class="active"><a href="requests.php"><img src="../Icons/Dashboard/requests.png" alt=""><span>Requests</span></a></li>
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
            <h1>Received requests</h1>
            <hr>
        </header>

        <div class="requests-table">
            <div class="table-header">
                <div class="header-cell">ID</div>
                <div class="header-cell">Name</div>
                <div class="header-cell">Category</div>
                <div class="header-cell">Quantity</div>
                <div class="header-cell">Pickup date</div>
                <div class="header-cell">Status</div>
                <div class="header-cell">Books price</div>
                <div class="header-cell actions-header"></div>
            </div>

            <div class="table-body">
                <?php if (empty($requests)): ?>
                    <p style="text-align: center; padding: 20px;">No requests found.</p>
                <?php else: ?>
                    <?php foreach ($requests as $request): ?>
                        <div class="table-row-wrapper" id="request-row-<?php echo $request['request_ID']; ?>">
                            <div class="row-main">
                                <div class="table-cell"><?php echo str_pad($request['request_ID'], 4, '0', STR_PAD_LEFT); ?></div>
                                <div class="table-cell">
                                    <a href="#" class="client-name-link" 
                                       data-client-name="<?php echo htmlspecialchars($request['first_name'] . ' ' . $request['last_name']); ?>"
                                       data-client-phone="<?php echo htmlspecialchars($request['phone_number']); ?>"
                                       data-client-email="<?php echo htmlspecialchars($request['email_client_ID']); ?>"
                                       data-client-city="<?php echo htmlspecialchars($request['city']); ?>"
                                       data-client-contact="<?php echo htmlspecialchars(ucfirst($request['preferred_contact_method'])); ?>">
                                        <?php echo htmlspecialchars($request['first_name'] . ' ' . $request['last_name']); ?>
                                    </a>
                                </div>
                                <div class="table-cell"><?php echo htmlspecialchars(ucfirst($request['category'])); ?></div>
                                <div class="table-cell"><?php echo htmlspecialchars($request['quantity']); ?></div>
                                <div class="table-cell"><?php echo date("d M Y", strtotime($request['pickup_date'])); ?></div>
                                <div class="table-cell">
                                    <select class="status-select <?php echo get_status_class($request['status']); ?>" data-request-id="<?php echo $request['request_ID']; ?>">
                                        <?php foreach ($status_options as $option): ?>
                                            <option value="<?php echo $option; ?>" <?php echo ($request['status'] == $option) ? 'selected' : ''; ?>>
                                                <?php echo ucfirst($option); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="table-cell">
                                    <input type="number" step="0.01" class="price-input" 
                                           data-request-id="<?php echo $request['request_ID']; ?>"
                                           value="<?php echo htmlspecialchars($request['books_price']); ?>" 
                                           placeholder="0.00">
                                </div>
                                <div class="table-cell row-actions">
                                    <form method="POST" class="delete-form" onsubmit="return confirm('Are you sure you want to delete this request?');">
                                        <input type="hidden" name="delete_request_id" value="<?php echo $request['request_ID']; ?>">
                                        <button type="submit" class="delete-button">
                                            <img src="../Icons/Dashboard/icons8-delete-100.png" alt="Delete" class="bin icon">
                                        </button>
                                    </form>
                                    <svg class="icon chevron-icon expand-trigger" width="24" height="24" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6" stroke="#4A4A4A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/></svg>
                                </div>
                            </div>
                            <div class="row-details">
                                <div class="detail-group">
                                    <label>Pickup address</label>
                                    <input class="detail-input" readonly rows="2" value="<?php echo htmlspecialchars($request['pickup_address']); ?>">
                                </div>
                                <div class="detail-group">
                                    <label>Additional notes</label>
                                    <textarea class="detail-textarea" readonly rows="4"><?php echo htmlspecialchars($request['additional_remarks']); ?></textarea>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<div class="modal-overlay" id="client-details-modal">
    <div class="modal-content">
        <button class="modal-close" id="modal-close-button">×</button>
        <h2>Client details</h2>
        <div class="modal-form-display">
            <div class="modal-form-group"><label>Full name</label><div id="modal-client-name" class="modal-form-value"></div></div>
            <div class="modal-form-group"><label>Phone number</label><div id="modal-client-phone" class="modal-form-value"></div></div>
            <div class="modal-form-group"><label>Email</label><div id="modal-client-email" class="modal-form-value"></div></div>
            <div class="modal-form-group"><label>City</label><div id="modal-client-city" class="modal-form-value"></div></div>
            <div class="modal-form-group"><label>Preferred contact method</label><div id="modal-client-contact" class="modal-form-value"></div></div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.querySelector('.table-body');
    const modal = document.getElementById('client-details-modal');
    const statusClasses = ['status-collected', 'status-processing', 'status-cancelled', 'status-in-transit', 'status-scheduled'];

    // table body event
    tableBody.addEventListener('click', function(event) {
        // row expansion operation
        if (event.target.closest('.expand-trigger')) {
            const rowWrapper = event.target.closest('.table-row-wrapper');
            if (rowWrapper) {
                rowWrapper.classList.toggle('expanded');
            }
        }
        
        // client modal
        if (event.target.classList.contains('client-name-link')) {
            event.preventDefault();
            const link = event.target;
            document.getElementById('modal-client-name').textContent = link.dataset.clientName;
            document.getElementById('modal-client-phone').textContent = link.dataset.clientPhone;
            document.getElementById('modal-client-email').textContent = link.dataset.clientEmail;
            document.getElementById('modal-client-city').textContent = link.dataset.clientCity;
            document.getElementById('modal-client-contact').textContent = link.dataset.clientContact;
            modal.classList.add('active');
        }
    });
    
    // status and price update
    tableBody.addEventListener('change', function(event) {
        // update status
        if (event.target.classList.contains('status-select')) {
            const selectElement = event.target;
            const requestId = selectElement.dataset.requestId;
            const newStatus = selectElement.value;
            
            selectElement.className = 'status-select'; // Reset classes
            statusClasses.forEach(c => selectElement.classList.remove(c));
            selectElement.classList.add('status-' + newStatus.replace(' ', '-'));

            updateRequestData('update_status', requestId, newStatus, 'status');
        }
    });

    tableBody.addEventListener('blur', function(event) {
        // update price
        if (event.target.classList.contains('price-input')) {
            const inputElement = event.target;
            const requestId = inputElement.dataset.requestId;
            const newPrice = inputElement.value;
            updateRequestData('update_price', requestId, newPrice, 'price');
        }
    }, true); // blur background modal

    // client modal closing
    const closeModal = () => modal.classList.remove('active');
    modal.querySelector('.modal-close').addEventListener('click', closeModal);
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    // AJAX Update function
    function updateRequestData(action, requestId, value, fieldType) {
        const formData = new FormData();
        formData.append('action', action);
        formData.append('request_id', requestId);
        formData.append(fieldType, value);

        fetch('update_request.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Update failed: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        });
    }
});
</script>

</body>
</html>