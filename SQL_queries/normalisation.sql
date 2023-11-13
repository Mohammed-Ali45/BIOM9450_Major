/* 
BIOM9450 Major Project (Selection 2)
Cancerictive
Made by: Mohammed Mohammed Ali
Last updated: 12/11/2023

This file documents all queries used to process the given raw data into
normalised tables and establish the necessary relationships to underly
an intuitive user experience for researchers, oncologists, general
practitioners, and patients.

With all queries, the RawData can be normalised and used to rebuild the raw
data.



*/
/* Retrieves unique specimens and associated cancer type;
makes Specimens table

{icgc_specimen_id} -> {Cancer type} */
SELECT DISTINCT
    RawData.icgc_specimen_id,
    RawData.[Cancer type]
INTO
    Specimens
FROM
    RawData;



/* Retrieves unique mutations from raw data;
forms basis of Mutation table

{mutationID} -> {chromosome, chromosome_start, chromosome_end,
mutated_from_allele, mutated_to_allele, gene_affected} */
SELECT distinct
    chromosome,
    chromosome_start,
    chromosome_end,
    mutated_from_allele,
    mutated_to_allele,
    gene_affected
FROM
    RawData;



/* Adds primary key of Mutation (mutationID) as foreign key in RawData table */
UPDATE RawData
INNER JOIN Mutation ON (RawData.chromosome = Mutation.chromosome)
AND (
    RawData.chromosome_start = Mutation.chromosome_start
)
AND (RawData.chromosome_end = Mutation.chromosome_end)
AND (
    RawData.mutated_from_allele = Mutation.mutated_from_allele
)
AND (
    RawData.mutated_to_allele = Mutation.mutated_to_allele
)
AND (
    NZ (RawData.gene_affected) = NZ (Mutation.gene_affected)
)
SET
    RawData.mutationID = Mutation.mutationID;



/* Adds mutated_from_allele and mutated_to_allele as foreign keys in the
Mutation table

Since mutation_type is transitively dependent on mutationID, it cannot be
included in the mutation table*/
ALTER TABLE Mutation
ADD CONSTRAINT FK_toANDfromAllele FOREIGN KEY (mutated_from_allele, mutated_to_allele) REFERENCES Mutation (mutated_from_allele, mutated_to_allele);



/* Updates consequence type column to replace null-values with "-"
Primary Keys cannot contain null values */
UPDATE RawData
SET
    consequence_type = '-'
WHERE
    ISNULL(consequence_type);



/* Makes a table of unique consequence_types from RawData */
SELECT DISTINCT
    RawData.[consequence_type]
INTO
    Consequence
FROM
    RawData;



/* Makes first association table containing specimenID and mutationID */
SELECT distinct
    icgc_specimen_id,
    mutationID
INTO
    SpecimenMutations
FROM
    RawData;



/* addition of constraints or foreign keys */
ALTER TABLE SpecimenMutations
ADD CONSTRAINT FK_specimenID FOREIGN KEY (icgc_specimen_id) REFERENCES Specimens (icgc_specimen_id);



ALTER TABLE SpecimenMutations
ADD CONSTRAINT FK_mutationID FOREIGN KEY (mutationID) REFERENCES Mutation (mutationID);



/*Makes second association table containing consequence_type and mutationID */
SELECT DISTINCT
    mutationID,
    consequence_type
INTO
    MutationConsequences
FROM
    RawData;



/* addition of constraints or foreign keys */
ALTER TABLE MutationConsequences
ADD CONSTRAINT FK_Consequences FOREIGN KEY (consequence_type) REFERENCES Consequence (consequence_type);



ALTER TABLE MutationConsequences
ADD CONSTRAINT FK_mutationID_conseq FOREIGN KEY (mutationID) REFERENCES Mutation (mutationID);



/* Built by query wizard on MS Access; rebuilds Raw data from normalised tables
Has 303,028 rows, all matching the given Raw Data */
SELECT
    SpecimenMutations.icgc_specimen_id,
    Mutation.mutationID,
    Mutation.chromosome,
    Mutation.chromosome_start,
    Mutation.chromosome_end,
    MutationType.mutation_type,
    Mutation.mutated_from_allele,
    Mutation.mutated_to_allele,
    MutationConsequences.consequence_type,
    Mutation.gene_affected,
    Specimens.[Cancer type]
FROM
    (
        (
            MutationType
            INNER JOIN Mutation ON (
                MutationType.[mutated_to_allele] = Mutation.[mutated_to_allele]
            )
            AND (
                MutationType.[mutated_from_allele] = Mutation.[mutated_from_allele]
            )
        )
        INNER JOIN (
            Specimens
            INNER JOIN SpecimenMutations ON Specimens.[icgc_specimen_id] = SpecimenMutations.[icgc_specimen_id]
        ) ON Mutation.[mutationID] = SpecimenMutations.[mutationID]
    )
    INNER JOIN MutationConsequences ON Mutation.[mutationID] = MutationConsequences.[mutationID];
