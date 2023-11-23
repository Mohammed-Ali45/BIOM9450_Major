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