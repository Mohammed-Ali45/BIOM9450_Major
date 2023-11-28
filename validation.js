//save a reference for each form element retireved by id from html file
const formLogin = document.getElementById("formLogin");
const email = document.getElementById("email");
const password = document.getElementById("password");
//const rid = document.getElementById("rid");

//valid email format
const isValidEmail = (email) => {
  const re =
    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,4}))$/;
  return re.test(String(email).toLowerCase());
};

//valid password format
var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

//valid researcher id format
var ridchar = /^[a-zA-Z0-9]*$/;
/*














*/
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
//validation functions for each field are set up similarly whereby the
// set up a function that is the value of the input element in the field of choice
// field is checked if its empty checked for correct format
// if successful will show success class if failed will show error class

// validating email function
const validateEmail = () => {
  const emailValue = email.value.trim(); //trim is used to get rid of the white space
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
//rid.addEventListener("change", validateRid);

//Add event listener for when submit button is clicked
if (formLogin !== null) {
  formLogin.addEventListener("submit", (l) => {
    l.preventDefault(); //prevent the form submitting before validating the input, will show error message

    // validate inputs functions
    validateEmail();
    validatePassword();

    if (document.querySelectorAll(".success").length === 2) {
      //ensuring 3 sucessful fields are met
      // submit the form
      const whatisthis = formLogin.submit;

      formLogin.submit();
    }
  });
}
/*














*/
//getting the references
var searchbar = document.getElementById("searchbar");
var category = document.getElementById("category");
//var tbody = document.getElementById("tbody1");
//var orignaltabledata = tbody.innerHTML;
/*














*/
//Patient Registration
//save a reference for each form element retireved by id from html file
const fname = document.getElementById("Fname");
const lname = document.getElementById("Lname");
const formNewpat = document.getElementById("");

// valid name characters
var namechar = /^[a-zA-Z-,]+(\s{0,1}[ '.\a-zA-Z-, ])*$/;

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
formNewpat.addEventListener("submit", (l) => {
  l.preventDefault(); //prevent the form submitting before validating the input, will show error message

  // validate inputs functions
  validateFname();
  validateLname();

  if (document.querySelectorAll(".success").length === 3) {
    //ensuring 3 sucessful fields are met
    // submit the form
    formNewpat.submit();
  }
});
