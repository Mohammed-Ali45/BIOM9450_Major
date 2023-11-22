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
                <div class = "card">
                <h1>Patient Database</h1>
                    <form>
                        <!-- search bar -->
                        <input type="text" id="searchbar" placeholder="Search Here..." style="width:100%">
                        <!-- category filter -->
                        <select id="category" style="width:100%" >
                            <option value="0" selected hidden>Select Category</option>
                            <option value="1">Mutation ID</option>
                            <option value="2">Chromosome</option>
                            <option value="3">Genes</option>
                            <option value ="4">Location</option>
                            <option value ="5">Patient ID</option>
                        </select>
                    </form>
                    <button id="newpatient">Add a new patient</button>
                    <table class="tablestyle" id="tbl1">
                        <thead>
                            <tr>
                                <th style="width:15%">Patient ID</th>
                                <th style="width:15%">Mutation ID</th>
                                <th>Chromosome</th>
                                <th>Genes</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody id="tbody1">
                            <tr>    
                                <td>Test</td>
                                <td>Test</td>
                                <td>Test</td>
                                <td>Test</td>
                                <td>Test</td>
                            </tr>
                            <tr>
                                <td>Hello</td>
                                <td>Hello</td>
                                <td>Hello</td>
                                <td>Hello</td>
                                <td>Hello</td>
                            </tr>
                        </tbody>
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
    