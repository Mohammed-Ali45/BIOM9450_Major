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