<!-- header.php -->
<header>
  <style>
    header {
      background-color: #007bff;
      color: white;
      padding: 15px 20px;
      font-family: Arial, sans-serif;
    }

    .header-container {
      max-width: 1100px;
      margin: auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .logo {
      font-size: 20px;
      font-weight: bold;
    }

    nav {
      display: flex;
      align-items: center;
    }

    nav a {
      color: white;
      text-decoration: none;
      margin-left: 20px;
      font-size: 14px;
      transition: color 0.3s;
    }

    nav a:hover {
      color: #ffc107;
    }

    /* Buttons for Login and Register */
    .btn {
      background-color: white;
      color: #007bff;
      border: none;
      padding: 7px 15px;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
      margin-left: 15px;
      text-decoration: none;
      font-size: 14px;
      transition: background-color 0.3s, color 0.3s;
    }

    .btn:hover {
      background-color: #ffc107;
      color: #007bff;
    }

    @media (max-width: 600px) {
      .header-container {
        flex-direction: column;
        align-items: flex-start;
      }

      nav {
        margin-top: 10px;
        flex-direction: column;
        width: 100%;
      }

      nav a, .btn {
        margin: 5px 0 0 0;
        width: 100%;
        text-align: center;
      }
    }
  </style>

  <div class="header-container">
    <div class="logo">🎓 MWENGE CATHOLICT UNIVERSITY EVENT MANAGER</div>
    <nav>
      
      <a href="login.php" class="btn">log in</a>
      <a href="register.php" class="btn">register</a>
    </nav>
  </div>
</header>
