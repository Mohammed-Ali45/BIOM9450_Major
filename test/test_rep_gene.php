<?php

session_start();

// Victoria's db connection
//$conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC); 
//$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=C:\Users\User\Downloads\UNSW\Current\BIOM9450\Mutation.accdb", "", "", SQL_CUR_USE_ODBC);

//Moey's db connection
$conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);


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
    $queryone = "SELECT DISTINCT
    Patient.PatientID,
    Patient.FirstName,
    Patient.LastName,
    Mutation.gene_affected
INTO
    TT_pat_affgenes
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
    ISNULL(gene_affected) = FALSE
ORDER BY
    Mutation.gene_affected";

    //Just in case, execute them one at a time
    $patients_affected_genes = odbc_exec($conn, $queryone);


    // Here's the second query
    $querytwo = "SELECT
    TT_pat_affgenes.gene_affected
INTO
    TT_rep_genes
FROM
    TT_pat_affgenes
GROUP BY
    TT_pat_affgenes.gene_affected
HAVING
    COUNT(gene_affected) > 1";



    //gonna try executing the two queries first, then referencing those in the join statement
    
    $repeating_genes = odbc_exec($conn, $querytwo);





    // The big one, the 3rd query
    $querythree = "SELECT
    TT_pat_affgenes.PatientID,
    TT_pat_affgenes.FirstName,
    TT_pat_affgenes.LastName,
    TT_rep_genes.gene_affected
FROM
    TT_pat_affgenes
    INNER JOIN TT_rep_genes ON TT_pat_affgenes.gene_affected = TT_rep_genes.gene_affected";





    //Execute the last query
    $only_repeating_genes = odbc_exec($conn, $querythree);


    //Let's count the rows
    //$gene_count_query = "SELECT COUNT(*) AS gene_count FROM ($querythree)";
    //$gene_count = odbc_result(odbc_exec($conn, $gene_count_query), 'gene_count');
    

    //Okay let's try printing out the results of this array and see if they stick around
    ?>

    <table class="tablestyle" id="tbl1">
        <thead>
            <tr>
                <th style="width:15%">Mutation ID</th>
                <th>Gene Involved</th>
                <th>Location</th>
                <th>Potential Impact</th>
            </tr>
        </thead>
        <tbody id="tbody1">
            <?php
            $gene_row = odbc_fetch_array($only_repeating_genes);
            $gene_counter = 1;
            while ($gene_row != false) {

                echo '<tr id="gene_row' . $gene_counter . '">';
                echo '<td>' . $gene_row['gene_affected'] . '</td>';
                echo ' ';
                echo '<td>' . $gene_row['PatientID'] . '</td>';
                echo '<td>' . $gene_row['FirstName'] . '</td>';
                echo '<td>' . $gene_row['LastName'] . '</td>';
                echo '</tr>';

                $gene_row = odbc_fetch_array($only_repeating_genes);
                $gene_counter++;

            }

            ?>
        </tbody>
    </table>








    <?php

    // This releases the lock on the database for some reason, no querying beyond this point.
    $free_result3 = odbc_free_result($only_repeating_genes);

    //Deletes the temporary tables before moving on
    $delete_table1 = odbc_exec($conn, "DROP TABLE TT_pat_affgenes;");
    $delete_table2 = odbc_exec($conn, "DROP TABLE TT_rep_genes;");

    ?>


    <?php

    ?>