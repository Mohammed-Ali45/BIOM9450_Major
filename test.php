<?php

session_start();
//check if the user is logged in
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    // Victoria's db connection
    //$conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC); 
    $conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=C:\Users\User\Downloads\UNSW\Current\BIOM9450\Mutation.accdb", "", "", SQL_CUR_USE_DRIVER);

    //Moey's db connection
    //$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);





    //grabbing patient table
    $patient_data_query = "SELECT Patient.[PatientID], Patient.[FirstName], Patient.[LastName], Patient.[icgc_specimen_id] FROM Patient";
    $patient_data_table = odbc_exec($conn, $patient_data_query);
    $patient_data = odbc_fetch_array($patient_data_table);

    $patient_count_query = "SELECT COUNT(*) AS patient_count FROM ($patient_data_query);";
    $patient_count = odbc_result(odbc_exec($conn, $patient_count_query), 'patient_count');

    include_once 'header.php'

        ?>

    <body>
        <!--setting up the nav bar-->
        <header>
            <div class="container1">
                <img src="images/snail.jpg" alt="logo" class="logo" width="70" height="70">
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
        <?php 
        //grabbing patient table
        $patient_data_query = "SELECT Patient.[PatientID], Patient.[FirstName], Patient.[LastName], Patient.[icgc_specimen_id] FROM Patient";
        $patient_data_table = odbc_exec($conn, $patient_data_query);
        $patient_data = odbc_fetch_array($patient_data_table);

        $patient_count_query = "SELECT COUNT(*) AS patient_count FROM ($patient_data_query);";
        $patient_count = odbc_result(odbc_exec($conn, $patient_count_query), 'patient_count');

        $patient_mutations = "SELECT
                                Mutation.mutationID,
                                Patient.PatientID,
                                Patient.FirstName,
                                Patient.LastName,
                                Mutation.chromosome,
                                Mutation.chromosome_start,
                                Mutation.chromosome_end,
                                Mutation.mutated_from_allele,
                                Mutation.mutated_to_allele
                            FROM
                                (
                                    Specimens
                                    INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]
                                )
                                INNER JOIN (
                                    Mutation
                                    INNER JOIN SpecimenMutations ON Mutation.[mutationID] = SpecimenMutations.[mutationID]
                                ) ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id]
                            WHERE
                                Mutation.mutationID IN (
                                    SELECT
                                        Mutation.mutationID
                                    FROM
                                        (
                                            Specimens
                                            INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]
                                        )
                                        INNER JOIN (
                                            Mutation
                                            INNER JOIN SpecimenMutations ON Mutation.[mutationID] = SpecimenMutations.[mutationID]
                                        ) ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id]
                                    GROUP BY
                                        Mutation.mutationID
                                    HAVING
                                        COUNT(Mutation.mutationID) > 1
                                )";
        $patient_mutations_table = odbc_exec($conn, $patient_mutations);
        $patient_mutations_data = odbc_fetch_array($patient_mutations_table);

        // $patient_mutations_count_row = "SELECT COUNT(*) AS patient_mutations_count FROM ($patient_mutations)";
        // $patient_mutations_count = odbc_result(odbc_exec($conn, $patient_mutations_count_row), 'patient_mutations_count');
        
        
        ?>
            
            <?php
            include_once 'footer.php'
                ?>
            <?php

} else {

    header("Location: index.php");

    exit();

}
?>