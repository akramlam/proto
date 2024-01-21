<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YALLAH</title>
    <link rel="stylesheet" href="style.css">
    <img src="bg-img.png" alt="">
</head>
<body>
        <!--start nav -->
        <div class="container">
        <div class="nav">
            <div class="logo">
                <img src="img/logo.png" alt="">
            </div>
            <div class="menu">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact us</a></li>
                </ul>
            </div>
            <div class="login">
                <a href="#">Login</a>
            </div>
        </div>
    
    <!-- end nav -->
    <!-- start body -->
    <div class="container">
        <form action="print.php" id="cityForm" method="post">
        <fieldset>
            <legend>Discover </legend>
            <label for="name">select a city : </label>
            <select name="city" id="city">
                <option value="Casablanca">Casablanca</option>
                <option value="Rabat">Rabat</option>
                <option value="Marrakech">Marrakech</option>
            </select>
            <!-- submit -->
            <input type="submit" value="Submit">
        </fieldset>
        </form>
    </div>
    <!-- end body -->
      <!-- start footer -->
      <div class="footer">
            <div class="footer-left">
                <h1>YALLAH</h1>
                <p>YALLAH is a platform that helps you to find the best places to visit in Morroco.</p>
            </div>
            <div class="footer-right">
                <div class="footer-right1">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About us</a></li>
                        <li><a href="#">Services</a></li>
                        <li><a href="#">Contact us</a></li>
                    </ul>
                </div>
                <div class="footer-right2">
                    <h3>Follow us</h3>
                    <ul>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Instagram</a></li>
                    </ul>
                </div>
            </div>
        </div>
    <!-- end footer -->
        </div>
</body>
</html>