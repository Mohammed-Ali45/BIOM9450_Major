<?php

session_start();
//check if the user is logged in
if (isset($_SESSION['Researcher_email']) || isset($_SESSION['Oncologist_email'])) {

    if (isset($_SESSION['Researcher_email'])) {
        $email = $_SESSION['Researcher_email'];
    } elseif (isset($_SESSION['Oncologist_email'])) {
        $email = $_SESSION['Oncologist_email'];
    }



    //Connection string for allowing workflow to switch between Victoria and Moey's db filepath
    include 'conn_string.php';
    $conn = conn_string();



    //grabbing data from the patient table (change the titles when databse is updated)
    $sql = "SELECT * FROM Patient WHERE Email = '$email'";
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
                        <li><a href="researcher.php">Database</a></li>
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="includes/logout-inc.php" class="dropbtn">Logout</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <!--the body section-->
        <div class="container">

            <div class="card-single">
                <div class="card1" style="width:70%">
                    <div class="card-header">New Patient Registration</div>
                    <div class="card-body">
                        <form id="form-newpat" action="includes/newpatient-inc.php" method="post">
                            <div class="input-control">
                                <label for="Fname">First Name</label>
                                <input class="input-type-text" id="Fname" name="Fname" type="text"
                                    placeholder="First Name Here...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="Lname">Last Name</label>
                                <input class="input-type-text" id="Lname" name="Lname" type="text"
                                    placeholder="Last Name Here...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="age">Age</label>
                                <input class="input-type-text" id="Age" name="age" type="text" placeholder="50...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="dob">Date of Birth</label>
                                <input class="input-type-text" id="dob" name="dob" type="text" placeholder="dd/mm/yyyy...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="sex">Sex</label>
                                <select class="select-id-category" id="sex" name="sex" style="width: 20%">
                                    <option value="" selected disabled hidden>Select an option</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="input-control">
                                <label for="phone-no">Phone Number</label>
                                <input class="input-type-text" id="phone-no" name="phone_no" type="text"
                                    placeholder="04 1234 5678">
                                <div class="error"></div>
                            </div>




                            <h2 style="text-align:center">Address</h2>
                            <div class="input-control">
                                <label for="street-no">Street Number</label>
                                <input class="input-type-text" id="street-no" name="street_no" type="text"
                                    placeholder="6...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="street-name">Street Name</label>
                                <input class="input-type-text" id="street-name" name="street_name" type="text"
                                    placeholder="John St...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="city">City</label>
                                <input class="input-type-text" id="city" name="city" type="text" placeholder="Mulberry...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="postcode">Postcode</label>
                                <input class="input-type-text" id="postcode" name="postcode" type="text"
                                    placeholder="2175...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="country">Country</label>
                                <input class="input-type-text" id="country" name="country" type="text"
                                    placeholder="Australia...">
                                <div class="error"></div>
                            </div>





                            <h2 style="text-align:center">Diagnosis</h2>

                    </div>
                    <div class="input-control">
                        <label for="cancer-type">Cancer type</label>
                        <select class="select-id-category" id="cancer-type" name="cancer-type" style="width: 20%">
                            <option value="" selected disabled hidden>Select an option</option>
                            <option value="Blood">Blood</option>
                            <option value="Brain">Brain</option>
                            <option value="Breat">Breast</option>
                            <option value="Liver">Liver</option>
                            <option value="Pancreas">Pancreas</option>
                            <option value="Prostate">Prostate</option>
                        </select>
                    </div>



                    <h2 style="text-align:center">Login Information</h2>
                    <div class="input-control">
                        <label for="email">Email</label>
                        <input class="input-type-text" id="email" name="email" type="text" placeholder="example@gmail.com">
                        <div class="error"></div>
                    </div>
                    <div class="input-control">
                        <label for="password">Password</label>
                        <input class="input-type-text" id="password" name="password" type="password"
                            placeholder="Password...">
                        <div class="error"></div>
                    </div>






                    <div class="card-footer">
                        <input type="reset" button class="btn btn-outline" value="Clear">
                        <!--clears all input fields-->
                        <input type="submit" button class="btn" value="Register"> <!--submit button-->
                    </div>
                    </form>
                </div>
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