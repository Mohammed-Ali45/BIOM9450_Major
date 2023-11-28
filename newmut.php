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
                    <div class="card-header">Mutation Form</div>
                    <div class="card-body">
                        <form id="form" onsubmit="return validateForm()" action="includes/newmut-inc.php" method="post">
                            <div class="input-control">
                                <label for="chromosome">Chromosome</label>
                                <input class="input-type-text" id="chromosome" name="chromosome" type="text"
                                    placeholder="Chromosome no. e.g 3...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="chromosome_start">Chromosome Start</label>
                                <input class="input-type-text" id="chromosome_start" name="chromosome_start" type="number"
                                    placeholder="Chromosome no. e.g 3...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="chromosome_end">Chromosome End</label>
                                <input class="input-type-text" id="chromosome_end" name="chromosome_end" type="number"
                                    placeholder="Chromosome no. e.g 3...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="mutated_from">Mutated from Allele</label>
                                <input class="input-type-text" id="mutated_from" name="mutated_from" type="text"
                                    placeholder="ACCCTTTGG...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="mutated_to">Mutated to Allele</label>
                                <input class="input-type-text" id="mutated_to" name="mutated_to" type="text"
                                    placeholder="ACCCTTTGG...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="gene_affected">Gene Affected</label>
                                <input class="input-type-text" id="gene_affected" name="gene_affected" type="text"
                                    placeholder="ENSG00000160049...">
                                <div class="error"></div>
                            </div>
                            <div class="input-control">
                                <label for="consequence">Consequence/s</label>
                                <select id="consequnce" style="width:95%">


                                    <?php
                                    //Consequence query
                                    $consequence = "SELECT distinct consequence_type FROM Consequence;";
                                    $consequence_data = odbc_exec($conn, $consequence);
                                    $consequence_type = odbc_fetch_array($consequence_data);
                                    while ($consequence_type != false) {
                                        echo '<option value="' . $consequence_type['consequence_type'] . '">' . $consequence_type['consequence_type'] . '</option>';
                                        $consequence_type = odbc_fetch_array($consequence_data);
                                    }


                                    ?>

                                </select>
                            </div>




                            <div class="card-footer">
                                <input type="reset" button class="btn btn-outline" value="Clear">
                                <!--clears all input fields-->
                                <input type="submit" button class="btn" value="Add Mutation"> <!--submit button-->
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