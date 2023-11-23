<!DOCTYPE html>
<html>

<body>

    <?php
    // $conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=D:\dev\Mutation.accdb", '', '', SQL_CUR_USE_ODBC);
    //$conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC);
    $conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=C:\Users\User\Downloads\UNSW\Current\BIOM9450\Mutation.accdb", "", "", SQL_CUR_USE_DRIVER);
    $sql = "SELECT * FROM RawData";
    $rs = odbc_exec($conn, $sql);

    if (!$conn) {
        exit("Connection Failed: " . $conn);
    } else {
        echo ("Connection Successful!");
    }
    ?>

    <?php
    $conn = odbc_connect("Driver= {Microsoft Access Driver (*.mdb, *.accdb)};DBQ=C:\Users\User\Downloads\UNSW\Current\BIOM9450\Mutation.accdb", "", "", SQL_CUR_USE_DRIVER);
    $userExists = false;
    $email = 'tiffany.ramirez@gmail.com';
    $password = 'W8VM8gT6';
    echo $email;
    //Looks for and retrieves rowdata in db that matches inputted email & password
    $user_data_query = "SELECT * FROM Users WHERE Email = '$email' AND Password = '$password' ";

    //Executes above query
    $user_data = odbc_exec($conn, $user_data_query);
    $user_email = odbc_result($user_data, "Email");
    
    //Retrieves PatientID and StaffID fields from row containing user data
    $patientID = odbc_result($user_data, 'PatientID');
    $staffID = odbc_result($user_data, 'StaffID');

    //checks if above query managed to find match
    if (odbc_fetch_row($user_data,1)) {
        $userExists = 'true';
        
    }
     
    
    $statement = "SELECT Patient.icgc_specimen_id, Patient.Email, Specimens.[Cancer type]
                    FROM Specimens INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]";
    $cancer = odbc_exec($conn, $statement);

    // Check if the query was successful
    if (!$cancer) {
        die("Query failed: " . odbc_errormsg($conn));
    }

    // Loop through the rows and display data
    while ($row = odbc_fetch_array($cancer)) {
        echo $row['Cancer type'] . "<br>";
    }


    $sql = "SELECT
            Mutation.mutationID,
            Mutation.gene_affected,
            Mutation.chromosome,
            MutationConsequences.consequence_type,
            SpecimenMutations.icgc_specimen_id,
            Patient.PatientID
        FROM
            (
                Mutation
                INNER JOIN (
                    (
                        Specimens
                        INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]
                    )
                    INNER JOIN SpecimenMutations ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id]
                ) ON Mutation.[mutationID] = SpecimenMutations.[mutationID]
            )
            INNER JOIN MutationConsequences ON Mutation.[mutationID] = MutationConsequences.[mutationID]";
    include_once 'header.php';
    // Execute the query
    $result = odbc_exec($conn, $sql);
    echo '<form>
    <!-- search bar -->
    <input type="text" id="searchbar" placeholder="Search Here..." style="width:100%">
    <!-- category filter -->
    <select id="category" style="width:100%" >
        <option value="0" selected hidden>Select Category</option>
        <option value="1">Mutation ID</option>
        <option value="2">Gene Involved</option>
        <option value="3">Location</option>
        <option value ="4">Potential Impact</option>
        <option value ="5">Patient ID</option>
    </select>
</form>';
    if ($result) {
        // Start building the HTML table
        echo '<table class="tablestyle" id="tbl1">
                <thead>
                    <tr>
                        <th>Mutation ID</th>
                        <th>Gene Affected</th>
                        <th>Chromosome</th>
                        <th>Consequence Type</th>
                        <th>ICGC Specimen ID</th>
                        <th>Patient ID</th>
                    </tr>
                </thead>';
    
        // Fetch each row from the result set
        while ($row = odbc_fetch_array($result)) {
            // Output each row as a table row
            echo '<tr id="tbody1">
                    <td>' . $row['mutationID'] . '</td>
                    <td>' . $row['gene_affected'] . '</td>
                    <td>' . $row['chromosome'] . '</td>
                    <td>' . $row['consequence_type'] . '</td>
                    <td>' . $row['icgc_specimen_id'] . '</td>
                    <td>' . $row['PatientID'] . '</td>
                </tr>';
        }
    
        // Close the HTML table
        echo '</table>';
    } else {
        // Handle the case where the query failed
        echo 'Error executing query';
    }
    

    
?>
    ?>

    

<?php //session_start();

// if (isset($_SESSION['email'])) {
//     $email = $_SESSION['email'];
//     $conn = odbc_connect('z5259813', '', '', SQL_CUR_USE_ODBC);

//     if (!$conn) {
//         echo "ODBC connection failed: " . odbc_errormsg();
//         exit;
//     }

//     $sql = "SELECT * FROM Patient WHERE Email = '$email'";
//     $exists = odbc_exec($conn, $sql);

//     if (!$exists) {
//         echo "Query execution failed: " . odbc_errormsg($conn);
//         exit;
//     }

//     $row = odbc_fetch_array($exists);

//     if (!$row) {
//         echo "No data found for email: $email";
//         exit;
//     }

//     // Now you can echo both $email and data from $row
//     echo "Email from session: $email";
//     echo "Email from database row: " . $row['Email'];
// } else {
//     echo "Email not set in session.";
// }
// echo $row['Photo'];
// ?>


</body>

</html>

<!-- echo '<table class ="tablestyle" id="tbl1">
                <thead>
                    <tr>
                        <th>Mutation ID</th>
                        <th>Gene Affected</th>
                        <th>Chromosome</th>
                        <th>Consequence Type</th>
                        <th>ICGC Specimen ID</th>
                        <th>Patient ID</th>
                    </tr>
                </thead>';

        // Fetch each row from the result set
        while ($row = odbc_fetch_array($result)) {
            // Output each row as a table row
                echo '<tbody id="tbody">
                        <tr>
                            <td>' . $row['mutationID'] . '</td>
                            <td>' . $row['gene_affected'] . '</td>
                            <td>' . $row['chromosome'] . '</td>
                            <td>' . $row['consequence_type'] . '</td>
                            <td>' . $row['icgc_specimen_id'] . '</td>
                            <td>' . $row['PatientID'] . '</td>
                        </tr>
                    </tbody>';
        } -->