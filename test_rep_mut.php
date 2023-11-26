<?php

session_start();

// Victoria's db connection
//$conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC); 
$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=C:\Users\User\Downloads\UNSW\Current\BIOM9450\Mutation.accdb", "", "", SQL_CUR_USE_ODBC);

//Moey's db connection
//$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);


include_once 'header.php'
    ?>

<!-- Some placeholder html to know everything is working-->

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





    // Here's the first query
    $queryone = "SELECT
    Patient.PatientID,
    Patient.FirstName,
    Patient.LastName,

    SpecimenMutations.mutationID
INTO
    Table1
FROM
    (
        Specimens
        INNER JOIN SpecimenMutations ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id]
    )
    INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]";


    // Here's the second query
    $querytwo = "SELECT
    SpecimenMutations.mutationID
INTO
    Table2
FROM
    (
        Specimens
        INNER JOIN SpecimenMutations ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id]
    )
    INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]
GROUP BY
    SpecimenMutations.mutationID
HAVING
    COUNT(SpecimenMutations.mutationID) > 1";



    //gonna try executing the two queries first, then referencing those in the join statement
    $patients_mutations = odbc_exec($conn, $queryone);
    $repeating_mutations = odbc_exec($conn, $querytwo);





    // The big one, the 3rd query
    $querythree = "SELECT
    Table2.mutationID,
    Table1.PatientID,
    Table1.FirstName,
    Table1.LastName
FROM
    (
        Mutation
        INNER JOIN Table1 ON Mutation.[mutationID] = Table1.[mutationID]
    )
    INNER JOIN Table2 ON Mutation.[mutationID] = Table2.[mutationID]
    ORDER BY Table2.mutationID";





    //Execute the last query
    $only_repeating_mutations = odbc_exec($conn, $querythree);


    //Let's count the rows
    $mutation_count_query = "SELECT COUNT(*) AS mutation_count FROM ($querythree)";
    $mutation_count = odbc_result(odbc_exec($conn, $mutation_count_query), 'mutation_count');


    //Okay let's try printing out the results of this array and see if they stick around
    ?>
    <input type="text" id="searchbar_mutation" placeholder="Search Here..." style="width:100%">
    <table class="tablestyle" id="tbl2">
        <thead>
            <tr>
                <th style="width:15%">Mutation ID</th>
                <th>Gene Involved</th>
                <th>Location</th>
                <th>Potential Impact</th>
            </tr>
        </thead>
        <tbody id="tbody2">
            <?php
            for ($mutation_no = 1; $mutation_no <= $mutation_count; $mutation_no++) {
                $mutation_row = odbc_fetch_array($only_repeating_mutations, $mutation_no);
                echo '<tr>';
                echo '<td>' . $mutation_row['mutationID'] . '</td>';
                echo ' ';
                echo '<td>' . $mutation_row['PatientID'] . '</td>';
                echo '<td>' . $mutation_row['FirstName'] . '</td>';
                echo '<td>' . $mutation_row['LastName'] . '</td>';
                echo '</tr>';
            }

            ?>
        </tbody>
    </table>








    <?php

    // This releases the lock on the database for some reason, no querying beyond this point.
    $free_result3 = odbc_free_result($only_repeating_mutations);

    //Deletes the temporary tables before moving on
    $delete_table1 = odbc_exec($conn, "DROP TABLE Table1;");
    $delete_table2 = odbc_exec($conn, "DROP TABLE Table2;");

    ?>

    <?php
    include_once 'footer.php'
        ?>
    <?php

    ?>