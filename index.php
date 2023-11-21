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

    <div class="container">
        <div class="card-single">
            <div class = "card">
                <h1>hellohi</h1>
            </div>
        </div>
<?php
    include_once 'footer.php'
?>