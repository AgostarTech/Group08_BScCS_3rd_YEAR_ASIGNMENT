<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome to MWECAU Event Management System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('banner.jpg') no-repeat center center fixed;
      background-size: cover;
      color: green;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .overlay {
      background-color: rgba(0, 0, 0, 0.6);
      flex-grow: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.1);
      padding: 40px;
      border-radius: 15px;
      text-align: center;
      max-width: 600px;
      width: 100%;
    }

    .logo {
      width: 100px;
      height: auto;
      margin-bottom: 20px;
    }

    h1 {
      font-size: 30px;
      margin-bottom: 10px;
    }

    p {
      font-size: 16px;
      margin-bottom: 30px;
    }

    .buttons a {
      display: inline-block;
      padding: 12px 25px;
      margin: 10px;
      background-color: #007bff;
      color: green;
      text-decoration: none;
      border-radius: 8px;
      font-weight: bold;
      transition: background-color 0.3s ease;
    }

    .buttons a:hover {
      background-color: #red;
    }

    footer {
      background-color: #001f3f;
      color: #ccc;
      text-align: center;
      padding: 15px;
      font-size: 14px;
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 24px;
      }
      .buttons a {
        width: 100%;
        margin: 8px 0;
        display: block;
      }
    }
  </style>
</head>
<?php include __DIR__ . '/header.php'; ?>
<body>
<div style="text-align: center; margin-bottom: 20px;">
  
  <h2>Welcome to MWECAU Event Management System</h2>
</div>
    <div class="buttons">
      <a href="login.php">🔐 log in</a>
      <a href="register.php">📝 register</a>
    </div>
  </div>
</div>

<?php include __DIR__ . '/footer.php'; ?>

</body>
</html>
