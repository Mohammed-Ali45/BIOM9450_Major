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
    INNER JOIN MutationConsequences ON Mutation.[mutationID] = MutationConsequences.[mutationID]
WHERE
    Patient.PatientID = '$patientID';



/* Counts the number of mutations for a given patient */
SELECT
    COUNT(*) AS count
FROM
    ('$mutation_profile_query');



/* Displaying repeating mutations for researchers. These queries must be run in
correct order and be named accordingly to function.
1st lists every mutation in every patient's mutational profile.

1st query = "patient_mutations" or similar */
SELECT
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
    ) ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id];



/* 2nd forms list of all mutationIDs that repeat in 1st query.
2nd query = "repeating_mutations" or similar */
SELECT
    Mutation.mutationID
FROM
    '$patient_mutations'
GROUP BY
    Mutation.mutationID
HAVING
    COUNT(Mutation.mutationID) > 1;



/* 3rd query lists only repeating mutationIDs and respective patient info
3rd query = "repeat_patient_mutations" */
SELECT
    '$repeating_mutations'.mutationID,
    '$patient_mutations'.PatientID,
    '$patient_mutations'.FirstName,
    '$patient_mutations'.LastName
FROM
    '$patient_mutations'
    INNER JOIN (
        '$repeating_mutations'
        INNER JOIN Mutation ON '$repeating_mutations'.[mutationID] = Mutation.[mutationID]
    ) ON '$patient_mutations'.[mutationID] = Mutation.[mutationID];