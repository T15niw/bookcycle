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



.profile-container {
    margin-top: 25px;
}

.welcome-banner {
    background: linear-gradient(90deg, rgba(50, 235, 42, 0.60) 0%, #238649 100%);
    color: #3E435D;
    padding: 38px 60px;
    border-radius: 12px;
    font-size: 20px;
    font-weight: 500;
    margin-bottom: 40px;
}

.profile-form {
    display: flex;
    flex-direction: column;
    gap: 22px; /* Space between form groups */
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-size: 14px;
    color: var(--text-secondary, #414142);
    margin-bottom: 8px;
    font-weight: 500;
}

.form-group input {
    font-family: "Lexend", sans-serif;
    padding: 14px 16px;
    border: 1px solid var(--border-color, #e5e7eb);
    border-radius: 8px;
    background-color: #FDFDFD;
    font-size: 15px;
    color: var(--text-secondary, #414142);
    width: 100%;
    box-sizing: border-box; /* Important for grid layout */
}

.form-group input:focus {
    outline: none;
    border-color: #238649;
    box-shadow: 0 0 0 2px rgba(35, 134, 73, 0.2);
}

.form-group input:disabled {
    background-color: #F0F0F0;
    color: #888;
    cursor: not-allowed;
    border-color: #e5e7eb;
}

.form-section-title {
    font-size: 24px;
    font-weight: 700;
    margin: 15px 0 -5px 0;
    color: var(--text-primary, black);
}

.change-btn {
    font-family: "Lexend", sans-serif;
    background-color: #238649;
    color: white;
    border: none;
    padding: 15px 45px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s ease;
    align-self: flex-start; /* Align button to the left */
    margin-top: 10px;
}

.change-btn:hover {
    background-color: #1a6b39; 
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
                    <li><a href="requests.php"><img src="../Icons/Dashboard/icons8-liste-de-tâches-100.png" alt=""><span>Requests</span></a></li>
                    <li><a href="clients.php"><img src="../Icons/Dashboard/utilisateur.png" alt=""><span>Clients</span></a></li>
                    <li class="active"><a href="volunteers.php"><img src="../Icons/Dashboard/icons8-bénévolat-100.png" alt=""><span>Volunteers</span></a></li>
                    <li><a href="partners.php"><img src="../Icons/Dashboard/icons8-collaborating-in-circle-100.png" alt=""><span>Partners</span></a></li>
                </ul>
            </nav>
            <div class="sidebar-footer">
                <ul>
                    <li><a href="settings.php"><img src="../Icons/Dashboard/icons8-paramètres-100.png" alt=""><span>Settings</span></a></li>
                    <li><a href="admin_logOut.php"><img src="../Icons/Dashboard/icons8-sortie-100.png" alt=""><span>Logout</span></a></li>
                </ul>
            </div>
        </aside>

        <main class="main-content">
            <header class="content-header">
                <h1>Profile</h1>
                <hr>
            </header>

            <div class="profile-container">
    <div class="welcome-banner">
        Howdy, Blood Moon !
    </div>

    <form class="profile-form">
        <div class="form-row">
            <div class="form-group">
                <label for="admin-name">Admin name</label>
                <input type="text" id="admin-name" value="Blood Moon">
            </div>
            <div class="form-group">
                <label for="email-address">Email address</label>
                <input type="email" id="email-address" value="abcdefghijklmnopqrst@gmail.com" disabled>
            </div>
        </div>

        <h2 class="form-section-title">Change password</h2>
        
        <div class="form-group">
            <label for="current-password">Current password</label>
            <input type="password" id="current-password" placeholder="">
        </div>
        <div class="form-group">
            <label for="new-password">New password</label>
            <input type="password" id="new-password" placeholder="">
        </div>
        <div class="form-group">
            <label for="confirm-password">Confirm password</label>
            <input type="password" id="confirm-password" placeholder="">
        </div>

        <button type="submit" class="change-btn">Change</button>
    </form>
</div>
       
        </main>
    </div>

</body>
</html>