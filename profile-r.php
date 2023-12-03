<?php

session_start();
//check if the user is logged in
if (isset($_SESSION['Researcher_email'])) {
    $email = $_SESSION['Researcher_email'];


    //Connection string for allowing workflow to switch between Victoria and Moey's db filepath
    include 'conn_string.php';
    $conn = conn_string();

    //grabbing data from the staff table
    $staff_data_query = "SELECT * FROM Staff WHERE Email = '$email'";
    $staff_data = odbc_exec($conn, $staff_data_query);
    include_once 'header.php'

        ?>

    <body>
        <!--setting up the nav bar-->
        <header>
            <div class="container1">
                <div>
                    <img src="images/snail.jpg" alt="logo" class="logo">
                    <div id="logo-text">
                        <span id="cancerictive-text" class="DM-Serif">Cancerictive</span>
                        <br />
                        <span id="slogan-text" class="Lato">Innovation & Compassion</span>
                    </div>
                </div>
                <nav>
                    <ul>
                        <li><a href="researcher.php">Database</li>
                        <li><a href="profile-r.php">Profile</a></li>
                        <li><a href="includes/logout-inc.php" class="dropbtn">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!--the body section-->
        <div class="container">
            <div class="card-single">
                <div class="card">
                <table class="tablestyle normal-table">
                                <thead>
                                    <tr>
                                        <th colspan="2"><span class="table-header">Personal Information</span></th>
                                    </tr>
                                </thead>
                                <tbody class="deets-table">
                                    <tr>
                                        <td class="label-cells">First Name:</td>
                                        <td>
                                            <?php echo odbc_result($staff_data, 'FirstName'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-cells">Last Name:</td>
                                        <td>
                                            <?php echo odbc_result($staff_data, 'LastName'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-cells">Email:</td>
                                        <td>
                                            <?php echo odbc_result($staff_data, 'Email'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-cells">Phone No.:</td>
                                        <td>
                                            <?php echo '0' . odbc_result($staff_data, 'PhoneNo'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label-cells">Occupation:</td>
                                        <td>
                                            <?php echo odbc_result($staff_data, 'Occupation'); ?>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                </div>
            </div>
            

            <?php
            include_once 'footer.php'
                ?>
            <?php

} else {

    header("Location: index.php");

    exit();

}
?>