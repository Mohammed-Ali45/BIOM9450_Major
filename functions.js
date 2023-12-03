//search and filter function
//getting the references
var searchbar = document.getElementById("searchbar");
var category = document.getElementById("category");
var tbody = document.getElementById("tbody1");
var originaltabledata = tbody.innerHTML; //storing table content

//search function
function Search() {
  tbody.innerHTML = originaltabledata; //all table rows when unfiltered
  let rows = tbody.children; //all of the table rows tags

  if (searchbar.value.length < 1 || category.value == "0") {
    return; //do not filter if you have no inputs
  }

  let filteredrows = ""; //initialize filtered rows as empty
  let catno = Number(category.value) - 1; //index of array starts from 0
  let searchtext = searchbar.value.toLowerCase(); //case insensitive search

  for (let i = 0; i < rows.length; i++) {
    const currentrowtext = rows[i].children[catno].innerText.toLowerCase(); //assigning table row's cell according to the category selected
    if (currentrowtext.indexOf(searchtext) > -1) {
      //if text is found will return index and will return filtered row
      filteredrows += rows[i].outerHTML; //current row
      //if search is performed onthe mutations patient.php table then add the row beneath it (this is hidden until clicked)
      if (tbody.className.includes("mutation-profile")) {
        filteredrows += rows[i + 1].outerHTML;
      }
    }
  }
  tbody.innerHTML = filteredrows; //add filtred table rows to the table
}
//add eventListener for when user inputs something into the search bar. run the search function
searchbar.addEventListener("input", Search);

// Search function for mutation table
// Getting the references
var searchbar_mutation = document.getElementById("searchbar_mutation");
var tbody_mutation = document.getElementById("tbody2");
var originaltabledata_mut = tbody_mutation.innerHTML; //storing table content

// Search function
function Search_mutation() {
  tbody_mutation.innerHTML = originaltabledata_mut; //all table rows when unfiltered
  let rows_mut = tbody_mutation.children; //all of the table rows tags

  if (searchbar_mutation.value.length < 1) {
    return; //do not filter if you have no inputs
  }

  let filteredrows_mut = ""; //initialize filtered rows as empty
  let searchtext_mut = searchbar_mutation.value.toLowerCase(); //case insensitive search

  for (let i = 0; i < rows_mut.length; i++) {
    const mutationID_col = rows_mut[i]
      .querySelector("td:nth-child(1)")
      .innerText.toLowerCase(); //selecting to search only in the first column = mutationID column
    if (mutationID_col === searchtext_mut) { 
      //if mutationID matches exactly then add to filtred rows
      filteredrows_mut += rows_mut[i].outerHTML;
    }
  }
  tbody_mutation.innerHTML = filteredrows_mut; //add filtred table rows to the table
}
//add eventListener for when user inputs something into the search bar. run the search function
searchbar_mutation.addEventListener("input", Search_mutation);

//search function for genes table
//grabbing references
var searchbar_gene = document.getElementById("searchbar_gene");
var tbody_gene = document.getElementById("tbody3");
var originaltabledata_gene = tbody_gene.innerHTML; //storing table content

// Search function
function Search_gene() {
  tbody_gene.innerHTML = originaltabledata_gene; //all table rows when unfiltered
  let rows_gene = tbody_gene.children; //all of the table rows tags

  if (searchbar_gene.value.length < 1) {
    return; //do not filter if you have no inputs
  }

  let filteredrows_gene = ""; //initialize filtered rows as empty
  let searchtext_gene = searchbar_gene.value.toLowerCase(); //case insensitive search

  for (let i = 0; i < rows_gene.length; i++) {
    const gene_affected_col = rows_gene[i]
      .querySelector("td:nth-child(1)")
      .innerText.toLowerCase(); //selecting to check only the gene column
    if (gene_affected_col === searchtext_gene) {
      //if entered text matches exactly then add to filtered row
      filteredrows_gene += rows_gene[i].outerHTML;
    }
  }
  tbody_gene.innerHTML = filteredrows_gene; //add filtred table rows to the table
}
//add eventListener for when user inputs something into the search bar. run the search function
searchbar_gene.addEventListener("input", Search_gene);

//new patient button
// JavaScript code to handle the button click event
document.getElementById("newpatient").addEventListener("click", function () {
  // Redirect to a new page
  window.location.href = "newpatient.php";
});

//new mutation button
// JavaScript code to handle the button click event
document.getElementById("newmut").addEventListener("click", function () {
  // Redirect to a new page
  window.location.href = "newmut.php";
});

// Moey: hiding and showing consequence table
function toggle_conseq_row(objectID) {
  var mut_row = objectID.slice(7);
  var conseq_rowID = "conseq-row" + mut_row;
  var conseq_row = document.getElementById(conseq_rowID);

  var cur_display = conseq_row.style.display;

  if (conseq_row.style.display == "none" || conseq_row.style.display == "") {
    conseq_row.style.display = "table-row";
  } else {
    conseq_row.style.display = "none";
  }
}

//Moey: hiding and showing entire tables
function show_hide_table(object) {
  //Gets the parent element and its styling
  var parentObject = object.parentElement;
  var tableObject = parentObject.getElementsByTagName("table");
  var tableStyle = tableObject[0].style;

  //Gets the search bar
  var searchbarObject = parentObject.getElementsByTagName("input");
  var searchbarStyle = searchbarObject[0].style;

  //Gets the orange arrow for displaying whether table is expanded or not
  var tableArrow = parentObject.getElementsByClassName("table-arrow");

  //Gets the descriptive text above table
  var text = parentObject.getElementsByTagName("p");
  var textStyle = text[0].style;

  //Gets dropdown if applicable
  var dropdown = parentObject.getElementsByTagName("select");
  if (dropdown.length != 0) {
    var dropdownStyle = dropdown[0].style;
  }

  //Gets button if applicable
  var button = parentObject.getElementsByTagName("button");
  if (button.length != 0) {
    var buttonStyle = button[0].style;
  }

  // This if statement will update all elements to show or hide
  if (tableStyle.display == "none" || tableStyle.display == "") {
    tableStyle.display = "table";
    searchbarStyle.display = "inline-block";
    tableArrow[0].src = "../images/down_arrow.png";
    textStyle.display = "block";

    //Only tries to change style if dropdown exists
    if (dropdown.length != 0) {
      dropdownStyle.display = "inline-block";
    }

    //Only tries to change style if button exists
    if (button.length != 0) {
      buttonStyle.display = "inline-block";
    }
  } else {
    tableStyle.display = "none";
    searchbarStyle.display = "none";
    tableArrow[0].src = "../images/right_arrow.png";
    textStyle.display = "none";

    //Only tries to change style if button exists
    if (dropdown.length != 0) {
      dropdownStyle.display = "none";
    }

    //Only tries to change style if button exists
    if (button.length != 0) {
      buttonStyle.display = "none";
    }
  }
}
