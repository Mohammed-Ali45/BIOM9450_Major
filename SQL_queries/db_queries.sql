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
    Patient.PatientID,
    Specimens.[Cancer type]
FROM
    Specimens
    INNER JOIN Patient ON Specimens.[icgc_specimen_id] = Patient.[icgc_specimen_id];



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