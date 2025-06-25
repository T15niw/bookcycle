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
        font-family: "Lexend", sans-serif;
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

      .navItems button {
        background-color: #32eb2a;
        color: white;
        padding: 6px 35px;
        border-radius: 20px;
        font-size: 18px;
        font-weight: bold;
        display: flex;
        align-items: center;
        gap: 7px;
        border: 1px solid white;
      }
      .navItems button:hover {
        background-color: #238649;
        cursor: pointer;
      }
      a {
        text-decoration: none;
        color: inherit;
      }</style>
</head>
<body>
     <div class="navbar">
        <a href="index.php"
          ><img src="../logo/Logo black shadow.png" alt="Logo"
        /></a>
        <nav>
          <ul>
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
            <li>
              <a href="logIn.php" target="_self" class="navItems"
                ><button type="button">
                  Log In <img src="../Icons/UI/Right Arrow.png" alt="" />
                </button>
              </a>
            </li>
          </ul>
        </nav>
      </div>  
</body>
</html>