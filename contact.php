<?php
    include_once 'header.php'
?>
<body>
    <!--setting up the nav bar-->
    <header>
        <div class="container1">
            <img src = "images/snail.jpg" alt="logo" class="logo" width="70" height="70">
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="database.php">Database</a></li>
                    <li><div class="dropdown">
                        <a class="dropbtn">Login</a>
                        <div class="dropdown-content">
                            <a href="login-p.php">Patient</a>
                            <a href="login-r.php">Staff</a>
                        </div>
                    </div></li>
                </ul>
            </nav>
        </div>
    </header>

    
                <h1>Contact Information</h1>
                <ul>
            <li>Email: <a href="mailto:info@cancerictive.com">info@cancerictive.com</a></li>
            <li>Phone: <a href="tel:+61468417010">+61 468417010</a></li>
            <li>Address: <a href="https://www.google.com/maps?q=University+of+New+South+Wales">University of New South Wales</a></li>
        </ul>
            </div>
        </div>
<?php
    include_once 'footer.php'
?>