<?php

session_start();
//check if the user is logged in
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC); 
    //grabbing data from the patient table (change the titles when databse is updated)
    $sql = "SELECT * FROM Patient WHERE Email = '$email'";
    include_once 'header.php'
    
    ?>

    <body>
        <!--setting up the nav bar-->
        <header>
            <div class="container1">
                <img src = "images/snail.jpg" alt="logo" class="logo" width="70" height="70">
                <nav>
                    <ul>
                        <li><a href="researcher.php">Database</a></li>
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="login/logout-inc.php" class="dropbtn">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!--the body section-->
        <div class="container">
           
        <div class="card-single">
            <div class="card1">
                <div class="card-header">New Patient Register</div>
                <div class="card-body">
                    <form id="form" onsubmit="return validateForm()" action="includes/loginr-inc.php" method="post" >
                        <div class="input-control">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="text" placeholder="example@gmail.com">
                            <div class="error"></div>
                        </div>
                        <div class="input-control">
                            <label for="password">Password</label>
                            <input id="password" name="password" type="password" placeholder="Password...">
                            <div class="error"></div>
                        </div>
                        <div class="input-control">
                            <label for="rid">Researcher ID</label>
                            <input id="rid" name="rid" type="text" placeholder="12345...">
                            <div class="error"></div>
                        </div>
                        <div class="card-footer">
                            <input type="reset" button class="btn btn-outline" value="Clear"> <!--clears all input fields-->
                            <input type="submit" button class="btn" value="Login"> <!--submit button-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
    <?php
        include_once 'footer.php'
    ?>
    <?php

}else{

    header("Location: index.php"); 

    exit();

}
?>   