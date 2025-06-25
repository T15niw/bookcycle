<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style> 
    * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
          font-family: 'Lexend', sans-serif;
        }
        /************************************************************/
        .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 40px;
      }
      nav ul {
        display: flex;
        gap: 30px;
        align-items: center;
        list-style: none;
        margin: 0;
        padding: 0;
      }
      .navItems {
        color: #238649;
        font-size: 22px;
        font-weight: 900;
      }

      .navItems:hover {
        color: #32eb2a;
        cursor: pointer;
      }
      a {
        text-decoration: none;
        color: inherit;
      }
      .img{
        height: 55px;
        width: 55px;
      }</style>
</head>
<body>
       <div class="navbar">
        <a href="index.php"
          ><img src="../logo/Logo black shadow.png" alt="Logo"
        /></a>
        <nav>
          <ul>
            <li><a href="progress.php" target="_self" class="navItems">Progress</a></li>
            <li>
              <a href="colaborate_with_us.php" target="_self" class="navItems"
                >Collaborate with us</a
              >
            </li>
            <li>
              <a href="about_us.php" target="_self" class="navItems"
                >About us</a
              >
            </li>
            <li>
              <a href="contact_us.php" target="_self" class="navItems"
                >Contact us</a
              >
            </li>
            <li><a href="profile.php"><img src="../Icons/UI/Progress/icons8-utilisateur-100.png" class="img"></a></li>
          </ul>
        </nav>
      </div>  
</body>
</html>