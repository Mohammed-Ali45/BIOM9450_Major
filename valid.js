//save a reference for each form element retireved by id from html file
const form = document.getElementById("form");
const fname = document.getElementById("fname");
const lname = document.getElementById("lname");

// valid name characters
var namechar = /^[a-zA-Z-,]+(\s{0,1}[ '.\a-zA-Z-, ])*$/;

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

//validation functions for each field are set up similarly whereby the
// set up a function that is the value of the input element in the field of choice
// field is checked if its empty checked for correct format
// if successful will show success class if failed will show error class

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

//Add event listeners to each field using validation function to immediately validate field
fname.addEventListener("change", validateFname); //using change to check upon inputting something
lname.addEventListener("change", validateLname);

//Add event listener for when submit button is clicked
form.addEventListener("submit", (l) => {
  l.preventDefault(); //prevent the form submitting before validating the input, will show error message

  // validate inputs functions
  validateFname();
  validateLname();

  if (document.querySelectorAll(".success").length === 3) {
    //ensuring 3 sucessful fields are met
    // submit the form
    form.submit();
  }
});
