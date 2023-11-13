<?php 

session_start();
//check if the user is logged in
if (isset($_SESSION['email'])) {
    ?>

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
                        <li><a href="patient.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="database.php">Database</a></li>
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="includes/logout-inc.php" class="dropbtn">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <div class="container">
            <h1>Hello, <?php echo $_SESSION['user_name']; ?></h1>

    <?php
        include_once 'footer.php'
    ?>
    <?php

}else{

    header("Location: index.php");

    exit();

}
?>
    