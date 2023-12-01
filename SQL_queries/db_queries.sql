/* Retrieves data connecting staff from Users table to their occupation in Staff table */
SELECT
    Users.Email,
    Users.PatientID,
    Users.StaffID,
    Users.Password,
    Staff.Occupation
FROM
    Staff
    INNER JOIN Users ON Staff.[StaffID] = Users.[StaffID]
WHERE
    Users.Email = '$email'
    AND Users.Password = '$password';



/* Retrieves the cancer type each patient has */
SELECT
    Patient.icgc_specimen_id,
    Patient.Email,
    Specimens.[Cancer type]
FROM
    Specimens
    INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]
WHERE
    Email = '$email';



/* Retrieves mutation profile for given PatientID */
SELECT
    Mutation.mutationID,
    Mutation.chromosome,
    Mutation.chromosome_start,
    Mutation.chromosome_end,
    Mutation.gene_affected
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
    Patient.PatientID = '$patient_id';



/* Counts the number of mutations for a given patient */
SELECT
    COUNT(*) AS count
FROM
    ('$mutation_profile_query');



/* Displaying repeating mutations for researchers. These queries must be run in
correct order and be named accordingly to function. Two temporary tables are
made and deleted after results are retrieved from the 3rd query.

1st lists every mutation in every patient's mutational profile.

1st query = "all_patient_mutations" or similar */
SELECT
    Patient.PatientID,
    Patient.FirstName,
    Patient.LastName,
    SpecimenMutations.mutationID
INTO
    TT_pat_muts
FROM
    (
        Specimens
        INNER JOIN SpecimenMutations ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id]
    )
    INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id];



/* 2nd forms list of all mutationIDs that repeat in 1st query.
2nd query = "repeating_mutations_index" or similar */
SELECT
    SpecimenMutations.mutationID
INTO
    TT_rep_muts
FROM
    (
        Specimens
        INNER JOIN SpecimenMutations ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id]
    )
    INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id]
GROUP BY
    SpecimenMutations.mutationID
HAVING
    COUNT(SpecimenMutations.mutationID) > 1;



/* 3rd query lists only repeating mutationIDs and respective patient info
3rd query = "repeating_mutations" */
SELECT
    TT_rep_muts.mutationID,
    TT_pat_muts.PatientID,
    TT_pat_muts.FirstName,
    TT_pat_muts.LastName
FROM
    (
        Mutation
        INNER JOIN TT_pat_muts ON Mutation.[mutationID] = TT_pat_muts.[mutationID]
    )
    INNER JOIN TT_rep_muts ON Mutation.[mutationID] = TT_rep_muts.[mutationID]
ORDER BY
    TT_rep_muts.mutationID;



/* Displaying repeating affected genes for researchers. These queries must be run in
correct order and be named accordingly to function.

1st lists every affected gene in every patient's mutational profile.
1st query = "all_affected_genes or simliar */
SELECT DISTINCT
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
    Mutation.gene_affected;



/* 2nd lists every affected gene that repeats 
2nd query = "repeating_genes_index or simliar" */
SELECT
    TT_pat_affgenes.gene_affected
INTO
    TT_rep_genes
FROM
    TT_pat_affgenes
GROUP BY
    TT_pat_affgenes.gene_affected
HAVING
    COUNT(gene_affected) > 1;



/* 3rd lists only genes that have affected more than one patient and the
respective patient info
3rd query = "repeating_affected_genes or similar" */
SELECT
    TT_pat_affgenes.PatientID,
    TT_pat_affgenes.FirstName,
    TT_pat_affgenes.LastName,
    TT_rep_genes.gene_affected
FROM
    TT_pat_affgenes
    INNER JOIN TT_rep_genes ON TT_pat_affgenes.gene_affected = TT_rep_genes.gene_affected;



/* Inserts the details of a new patient into the Patient table of the database */
INSERT INTO
    Patient (
        FirstName,
        LastName,
        age,
        DOB,
        sex,
        PhoneNo,
        Email,
        StreetNumber,
        StreetName,
        City,
        Postcode,
        country
    )
VALUES
    (
        '$Fname',
        '$Lname',
        '$age',
        '$dob',
        '$sex',
        '$phone_no',
        '$email',
        '$street_no',
        '$street_name',
        '$city',
        '$postcode',
        '$country'
    );