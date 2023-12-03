<?php
session_start();

//Connection string for allowing workflow to switch between Victoria and Moey's db filepath
include '../conn_string.php';
$conn = conn_string();




// initializing variables
$chromosome = $_POST["chromosome"];
$chromosome_start = $_POST["chromosome_start"];
$chromosome_end = $_POST["chromosome_end"];
$mutated_from = $_POST["mutated_from"];
$mutated_to = $_POST["mutated_to"];
$gene_affected = $_POST["gene_affected"];
$consequence = $_POST["consequence"];


//insert new mutation query
$insert_new_mut = "INSERT INTO
Mutation (
    chromosome,
    chromosome_start,
    chromosome_end,
    mutated_from_allele,
    mutated_to_allele,
    gene_affected
)
VALUES
(
    '$chromosome',
    '$chromosome_start',
    '$chromosome_end',
    '$mutated_from',
    '$mutated_to',
    '$gene_affected'
);";

$insert_mut = odbc_exec($conn,$insert_new_mut);

$count_mutation_query = "SELECT COUNT(mutationID) AS mutationID_count
FROM Mutation;";
$mutation_count = odbc_exec($conn, $count_mutation_query);
$mutation_num = odbc_result($mutation_count, 'mutationID_count');

//insert consequence
$insert_consequence_query = "INSERT INTO
MutationConsequences (
    mutationID,
    consequence_type
)
VALUES
(
    '$mutation_num',
    '$consequence'
);";

$insert_conseq = odbc_exec($conn, $insert_consequence_query);






header("location: ../researcher.php");