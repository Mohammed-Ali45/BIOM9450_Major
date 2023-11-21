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
                        <li><a href="researcher.php">Mutations</a></li>
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="login/logout-inc.php" class="dropbtn">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!--the body section-->
        <div class="container">
            <div class="card-single">
                <div class = "card">
                    <table class="tablestyle">
                        <tr>
                            <th colspan="2">Diagnosis</th>
                        </tr>
                        <tr>
                            <td>Cancer Type</td>
                            <td>Breast Cancer</td>
                        </tr>
                        <tr>
                            <td>Potential Impact</td>
                            <td>Consequences jojfieowjfeiowjfeoij</td>
                        </tr>
                        <tr>
                            <td>Treatment Plan</td>
                            <td>Antibiotics, Chemotherapy</td>
                        </tr>
                    </table>
                    <h1>Mutational Profile</h1>
                    <table class="tablestyle">
                        <tr>
                            <td>Mutation ID:</td>
                            <td>Cancer type</td>
                        </tr>
                        <tr>    
                            <td>Gene Involved:</td>
                            <td>Cancer type</td>
                        </tr>
                        <tr>
                            <td>Mutation ID:</td>
                            <td>Cancer type</td>
                        </tr>
                        <tr>
                            <td>Mutation ID:</td>
                            <td>Cancer type</td>
                        </tr>
                    </table>
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
    