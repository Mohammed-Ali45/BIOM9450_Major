/*
This document is used for validation of any input fields in the several pages
of the Cancerictive website that utilise it.

To avoid issues, all validation functions are compartmentalised per page, since
JS will halt the script if an attempt is made to add an event listener to an
element whose ID does not appear on the given page.


Validation functions for each field set up a function equal to value of input 
element in field of choice field is checked for no input, then correct format.
If successful, will show success class. If failed, will show error class.

The structure of each validation function:
- Checks if the page with the relevant form is active
- Retrieves all input fields from IDs
- sets functions for validating all fields
- adds event listeners which triggers above functions on change
- prevents form from being submitted if any validation functions throw errors.


potential issues:
- the "l" used in the event listener for the submit button may
not be working
- be careful using any input type other than text. the event listener will not
trigger the validation function if input type is number for eg. Best to have
all input types be text and validate them solely through js.
- cancer type should be a dropdown, otherwise join operations might not work
for matching cancers (eg "Breast cancer" cannot join ON "Breast" or "breast" or "breast.")
- treatment is not really necessary here, that should be handled in a separate form
*/
/*














*/
/* Universal functions for writing and removing error messages */

//setting error message
// based on the error provided from the input control and save a reference for the input display which is inside inputControl as a div
const setError = (element, message) => {
  //function taking two parameters, the element input for which is validated and the error message it will display
  const inputControl = element.parentElement; //retrieving parent element
  const errorDisplay = inputControl.querySelector(".error"); //locating element 'error' in inputControl

  errorDisplay.innerText = message; //message to be provided in the parameter
  inputControl.classList.add("error"); //adding error class this will show the red border
  inputControl.classList.remove("success"); //this will remove success class
};

// this is for successful input message similar setup to error message
const setSuccess = (element) => {
  //no message needed
  const inputControl = element.parentElement;
  const errorDisplay = inputControl.querySelector(".error");

  errorDisplay.innerText = ""; //removed the error message
  inputControl.classList.add("success"); //add success class will show the green border
  inputControl.classList.remove("error"); //remove error class
};
/*














*/
/* All regular expressions for every input field here.
Regex that appear in more than one page listed first */

//valid email format
const isValidEmail = (email) => {
  const re =
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,4}))$/;
  return re.test(String(email).toLowerCase());
};

//valid password format
var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

/* Regex for newpatient.php */
// valid name characters
var namechar = /^[a-zA-Z-,]+(\s{0,1}[ '.\a-zA-Z-, ])*$/;

var DOBchar =
  /^(?:0[1-9]|[12]\d|3[01])([\/.-])(?:0[1-9]|1[012])\1(?:19|20)\d\d$/;

var phoneNochar = /^[0-9]{10}$/;

var streetNochar = /^[0-9]+(\/[0-9]+)*$/;

var postcodechar = /^[0-9]{4,}$/;

var countrychar = /^[a-zA-Z\s]{4,28}$/;

//Regex for newmut.php
var chromosomechar = /^(?:[1-9]|1[0-9]|2[0-2]|X|Y|MT)$/;

var chromosomelocation = /^[0-9]+$/;

var allelechar = /^[ATCG]+$/;

var genechar = /^[0-9]{1,11}$/;

/* End of regex for newpatient.php */

/* End regular expressions */

/* End universal functions */
/*














*/
/* Begin validation for login.php */

//Are we on login page?
const formLogin = document.getElementById("formLogin");

/* Only try to add event listeners if we're on login page, depends on above */
if (formLogin !== null) {
  //save a reference for each form element retrieved by id from html file
  const email = document.getElementById("email");
  const password = document.getElementById("password");

  // validating email function
  const validateEmail = () => {
    const emailValue = email.value.trim(); //trim gets rid of white space
    if (emailValue === "") {
      setError(email, "Email is required"); //error message
    } else if (!isValidEmail(emailValue)) {
      //checking for valid email format
      setError(email, "Provide a valid email address"); //error message
    } else {
      setSuccess(email); //success message
    }
  };

  // validating password function
  const validatePassword = () => {
    const passwordValue = password.value.trim();
    if (passwordValue === "") {
      setError(password, "Password is required");
    } else if (password.value.match(passw)) {
      //checking for matching format
      setSuccess(password);
    } else {
      setError(
        password,
        "Password must contain 8 characters, and include number, upper case, and lower case letter."
      );
    }
  };

  //Add event listeners to each field using validation function to immediately validate field
  email.addEventListener("change", validateEmail); //using change to check upon inputting something
  password.addEventListener("change", validatePassword);

  //Add event listener for when submit button is clicked

  formLogin.addEventListener("submit", (l) => {
    l.preventDefault(); //prevent the form submitting before validating the input, will show error message

    // validate inputs functions
    validateEmail();
    validatePassword();

    if (document.querySelectorAll(".success").length === 2) {
      //ensuring 3 sucessful fields are met
      // submit the form

      formLogin.submit();
    }
  });
}
/* End validation for login.php */
/*














*/
/* Begin validation for newpatient.php */
//Are we on newpatient.php?
const formNewpat = document.getElementById("form-newpat");

//Runs all validation, adds event listeners only if we're on newpatient.php */
if (formNewpat !== null) {
  //save a reference for each form element retrieved by id from html file
  const fname = document.getElementById("Fname");
  const lname = document.getElementById("Lname");
  const age = document.getElementById("Age");
  const DOB = document.getElementById("dob");
  const phoneNo = document.getElementById("phone-no");
  const streetNo = document.getElementById("street-no");
  const streetName = document.getElementById("street-name");
  const city = document.getElementById("city");
  const postcode = document.getElementById("postcode");
  const country = document.getElementById("country");
  // const icgc_specimen_id = document.getElementById("icgc-specimen-id");
  // const cancer_type = document.getElementById("cancer");
  // const treatment = document.getElementById("treatment");
  const email = document.getElementById("email");
  const password = document.getElementById("password");

  //validating first name function
  const validateFname = () => {
    const fnameValue = fname.value.trim();
    if (fnameValue === "") {
      setError(fname, "First name is required");
    } else if (fname.value.match(namechar)) {
      setSuccess(fname);
    } else {
      setError(
        fname,
        "First name should only include letters, apostrophes, spaces, and hypens"
      );
    }
  };

  //validation last name function
  const validateLname = () => {
    const lnameValue = lname.value.trim();
    if (lnameValue === "") {
      setError(lname, "Last name is required");
    } else if (lname.value.match(namechar)) {
      setSuccess(lname);
    } else {
      setError(
        lname,
        "Last name should only include letters, apostrophes, spaces, and hyphens"
      );
    }
  };

  //validation age
  const validateAge = () => {
    const ageValue = age.value.trim();
    if (ageValue === "") {
      setError(age, "This field is required");
    } else if (ageValue >= 0 && ageValue <= 116) {
      setSuccess(age);
    } else {
      setError(age, "Please enter a real age");
    }
  };

  //validation DOB
  const validateDOB = () => {
    const DOBValue = DOB.value.trim();
    if (DOBValue === "") {
      setError(DOB, "This field is required");
    } else if (DOB.value.match(DOBchar)) {
      //checking for matching format
      setSuccess(DOB);
    } else {
      setError(DOB, "Please enter a valid DOB (dd/mm/yyyy)");
    }
  };

  //validation phoneNo
  const validatePhoneNo = () => {
    const phoneNoValue = phoneNo.value.trim();
    if (phoneNoValue === "") {
      setError(phoneNo, "This field is required");
    } else if (phoneNo.value.match(phoneNochar)) {
      //checking for matching format
      setSuccess(phoneNo);
    } else {
      setError(phoneNo, "Please enter a valid Phone Number");
    }
  };

  //validation street number
  const validateStreetNo = () => {
    const StreetNoValue = streetNo.value.trim();
    if (StreetNoValue === "") {
      setError(streetNo, "This field is required");
    } else if (streetNo.value.match(streetNochar)) {
      //checking for matching format
      setSuccess(streetNo);
    } else {
      setError(streetNo, "Please enter a valid Street Number");
    }
  };

  //validating street name function
  const validateStreetName = () => {
    const StreetNameValue = streetName.value.trim();
    if (StreetNameValue === "") {
      setError(streetName, "This field is required");
    } else if (streetName.value.match(namechar)) {
      setSuccess(streetName);
    } else {
      setError(
        streetName,
        "Street name should only include letters, apostrophes, spaces, and hypens"
      );
    }
  };

  //validation city name function (same as Fname and Lname)
  const validateCity = () => {
    const CityValue = city.value.trim();
    if (CityValue === "") {
      setError(city, "This field is required");
    } else if (city.value.match(namechar)) {
      setSuccess(city);
    } else {
      setError(
        city,
        "City name should only include letters, apostrophes, spaces, and hypens"
      );
    }
  };

  //validation postcode function
  const validatePostcode = () => {
    const PostcodeValue = postcode.value.trim();
    if (PostcodeValue === "") {
      setError(postcode, "This field is required");
    } else if (postcode.value.match(postcodechar)) {
      setSuccess(postcode);
    } else {
      setError(postcode, "Please enter a valid postcode");
    }
  };

  //validation country name function
  const validateCountry = () => {
    const CountryValue = country.value.trim();
    if (CountryValue === "") {
      setError(country, "This field is required");
    } else if (country.value.match(countrychar)) {
      setSuccess(country);
    } else {
      setError(country, "Please enter a valid country");
    }
  };

  // validating email function
  const validateEmail = () => {
    const emailValue = email.value.trim(); //trim gets rid of white space
    if (emailValue === "") {
      setError(email, "Email is required"); //error message
    } else if (!isValidEmail(emailValue)) {
      //checking for valid email format
      setError(email, "Provide a valid email address"); //error message
    } else {
      setSuccess(email); //success message
    }
  };

  // validating password function
  const validatePassword = () => {
    const passwordValue = password.value.trim();
    if (passwordValue === "") {
      setError(password, "Password is required");
    } else if (password.value.match(passw)) {
      //checking for matching format
      setSuccess(password);
    } else {
      setError(
        password,
        "Password must contain 8 characters, and include number, upper case, and lower case letter."
      );
    }
  };

  //Add event listeners to each field using validation function to immediately validate field
  fname.addEventListener("change", validateFname);
  lname.addEventListener("change", validateLname);
  age.addEventListener("change", validateAge);
  DOB.addEventListener("change", validateDOB);
  phoneNo.addEventListener("change", validatePhoneNo);
  streetNo.addEventListener("change", validateStreetNo);
  streetName.addEventListener("change", validateStreetName);
  city.addEventListener("change", validateCity);
  postcode.addEventListener("change", validatePostcode);
  country.addEventListener("change", validateCountry);
  // cancer_type.addEventListener("change", validateCancerType);
  // treatment.addEventListener("change", validateTreatment);
  email.addEventListener("change", validateEmail);
  password.addEventListener("change", validatePassword);

  //Add event listener for when submit button is clicked
  formNewpat.addEventListener("submit", (l) => {
    l.preventDefault(); //prevent the form submitting before validating the input, will show error message

    // validate inputs functions
    validateFname();
    validateLname();
    validateAge();
    validateDOB();
    validatePhoneNo();
    validateStreetNo();
    validateStreetName();
    validateCity();
    validatePostcode();
    validateCountry();
    // validateCancerType();
    // validateTreatment();
    validateEmail();
    validatePassword();

    if (document.querySelectorAll(".success").length === 12) {
      //ensuring 12 sucessful fields are met
      // submit the form
      formNewpat.submit();
    }
  });
}




//Begin validation for newmut.php

//Are we on login page?
const formNewmut = document.getElementById("form_newmut");

//Runs all validation and adds event listerns only if we're in the form on newmut.php
if (formNewmut !==null) {
  //grabbing references from the html file
  const chromosome = document.getElementById("chromosome");
  const chromosome_start = document.getElementById("chromosome_start");
  const chromosome_end = document.getElementById("chromosome_end");
  const mutated_from = document.getElementById("mutated_from");
  const mutated_to = document.getElementById("mutated_to");
  const gene = document.getElementById("gene_affected");

  //validating chromosome function
  const validateChromosome = () => {
    const chromosomeValue = chromosome.value.trim();
    if (chromosomeValue === "") {
      setError(chromosome, "Chromosome is required");
    } else if (chromosome.value.match(chromosomechar)) {
      setSuccess(chromosome);
    } else {
      setError(chromosome, "Chromosome should be between 1-22 or X, Y, or MT");
    }
  };

  //validating the chromostome start function
  const validateChromoStart = () => {
    const chromoStartValue = chromosome_start.value.trim();
    if (chromoStartValue === "") {
      setError(chromosome_start, "Starting chromosome is required");
    } else if (chromosome_start.value.match(chromosomelocation)) {
      setSuccess(chromosome_start);
    } else {
      setError(chromosome_start, "Chromosome start location should be values 0 to 9");
    }
  };

  //validating the chromosme end function
  const validateChromoEnd = () => {
    const chromoEndValue = chromosome_end.value.trim();
    if (chromoEndValue === "") {
      setError(chromosome_end, "Ending chromosome is required");
    } else if (chromosome_end.value.match(chromosomelocation)) {
      setSuccess(chromosome_end);
    } else {
      setError(chromosome_end, "Chromosome end location should be values 0 to 9");
    }
  };

  //validating the mutated from allele function
  const validateMutatedFrom = () => {
    const mutatedfromValue = mutated_from.value.trim();
    if (mutatedfromValue === "") {
      setError(mutated_from, "Starting mutation is required");
    } else if (mutated_from.value.match(allelechar)) {
      setSuccess(mutated_from);
    } else {
      setError(mutated_from, "Starting mutation should only include DNA bases A, T, C, G");
    }
  };

  //validating the mutated to allele function
  const validateMutatedTo = () => {
    const mutatedtoValue = mutated_to.value.trim();
    if (mutatedtoValue === "") {
      setError(mutated_to, "Ending mutation is required");
    } else if (mutated_to.value.match(allelechar)) {
      setSuccess(mutated_to);
    } else {
      setError(mutated_to, "Ending mutation should only include DNA bases A, T, C, G");
    }
  };

  //validating the mutated from allele function
  const validateGene = () => {
    const geneValue = gene.value.trim();
    if (geneValue === "") {
      setSuccess(gene);
    } else if (gene.value.match(genechar)) {
      setSuccess(gene);
    } else {
      setError(gene, "Gene affected should be numbers (ESNG0xxx will be appended)");
    }
  };

  //add event listeners using validation function to immediately validate field
  chromosome.addEventListener("change", validateChromosome);
  chromosome_start.addEventListener("change",validateChromoStart);
  chromosome_end.addEventListener("change", validateChromoEnd);
  mutated_from.addEventListener("change",validateMutatedFrom);
  mutated_to.addEventListener("change",validateMutatedTo);
  gene.addEventListener("change",validateGene);

  //Add event listerns for when submit button is clicked
  formNewmut.addEventListener("submit", (l) => {
    l.preventDefault(); //prevent the form submitting before validating the input, will show error message

    //validate input functions
    validateChromosome();
    validateChromoStart();
    validateChromoEnd();
    validateMutatedTo();
    validateMutatedFrom();
    validateGene;

    if (document.querySelectorAll(".success").length === 6) {
      //ensuring all fields are successful
      //submit the form
      formNewmut.submit();
    }
  }
  )

}
