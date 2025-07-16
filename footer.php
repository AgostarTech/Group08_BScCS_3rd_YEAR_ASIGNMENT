<!-- footer.php -->
<footer style="background-color:green; color:white; padding:30px 20px; margin-top:50px; font-family:Arial, sans-serif;">
  <style>
    .footer-container {
        max-width: 1100px;
        margin: auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        text-align: left;
    }

    .footer-section {
        flex: 1 1 200px;
    }

    .footer-section h4 {
        color: green;
        font-size: 16px;
        margin-bottom: 10px;
        border-bottom: 1px solid #eee;
        padding-bottom: 5px;
    }

    .footer-section p, .footer-section a {
        font-size: 14px;
        color: #e0e0e0;
        text-decoration: none;
        margin: 4px 0;
        display: block;
    }

    .footer-section a:hover {
        color: #ffc107;
    }

    .footer-bottom {
        text-align: center;
        margin-top: 30px;
        border-top: 1px solid #ccc;
        padding-top: 15px;
        font-size: 13px;
        color: #ddd;
    }
  </style>

  <div class="footer-container">
    <div class="footer-section">
      <h4>MWENGE CHATHOLIC UNIVERSITY</h4>
      <p>event management system</p>
      <p>location: Moshi, Kilimanjaro, Tanzania</p>
    </div>

    <div class="footer-section">
      <h4>contacts</h4>
      <p>📧 Email: <a href="mailto:info@suocs.ac.tz">info@mwecau.ac.tz</a></p>
      <p>📞 pnone: <a href="tel:+255712345678">+255 712 345 678</a></p>
      <p>🌐 Website: <a href="#">www.mwecau.ac.tz</a></p>
    </div>

    <div class="footer-section">
      <h4>quicklinks</h4>
      <a href="index.php">🏠 HOME</a>
      <a href="contact_us.php">📬 CONTACT US</a>
      <a href="login.php">🔐 LOG IN</a>
      <a href="register.php">📝 REGISTER</a>
    </div>
  </div>

  <div class="footer-bottom">
    &copy; <span id="year"></span> MWECAU. Alrights reserved.
  </div>

  <script>
    document.getElementById("year").textContent = new Date().getFullYear();
  </script>
</footer>

                                                                                                                                   