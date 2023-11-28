//search and filter function
//getting the references
var searchbar = document.getElementById("searchbar");
var category = document.getElementById("category");
var tbody = document.getElementById("tbody1");
var originaltabledata = tbody.innerHTML; //storing original html content

//search function
function Search() {
  tbody.innerHTML = originaltabledata; //restoring original table when unfiltered
  let rows = tbody.children; //all of the table rows tags

  if (searchbar.value.length < 1 || category.value == "0") {
    return; //do not filter if you have no inputs
  }

  let filteredrows = ""; //initialize filtered rows as empty
  let catno = Number(category.value) - 1; //index of array starts from 0
  let searchtext = searchbar.value.toLowerCase(); //case sensitive search

  for (let i = 0; i < rows.length; i++) {
    const currentrowtext = rows[i].children[catno].innerText.toLowerCase(); //assigning table row's cell according to the category selected
    if (currentrowtext.indexOf(searchtext) > -1) {
      //if text is found will return index and will return filtered row
      filteredrows += rows[i].outerHTML; //current row
    }
  }
  tbody.innerHTML = filteredrows; //filtered data will go into the tbody
}
searchbar.addEventListener("input", Search);

// Search function for mutation table
// Getting the references
var searchbar_mutation = document.getElementById("searchbar_mutation");
var tbody_mutation = document.getElementById("tbody2");
var originaltabledata_mut = tbody_mutation.innerHTML; // Storing original html content

// Search function
function Search_mutation() {
  tbody_mutation.innerHTML = originaltabledata_mut; // Restoring original table when unfiltered
  let rows_mut = tbody_mutation.children; // All of the table rows tags

  if (searchbar_mutation.value.length < 1) {
    return; // Do not filter if you have no inputs
  }

  let filteredrows_mut = ""; // Initialize filtered rows as empty
  let searchtext_mut = searchbar_mutation.value.toLowerCase(); // Case-sensitive search

  for (let i = 0; i < rows_mut.length; i++) {
    const mutationID_col = rows_mut[i]
      .querySelector("td:nth-child(1)")
      .innerText.toLowerCase(); // Mutation ID column text content
    if (mutationID_col === searchtext_mut) {
      // If Mutation ID matches, add the entire row to filtered rows
      filteredrows_mut += rows_mut[i].outerHTML;
    }
  }
  tbody_mutation.innerHTML = filteredrows_mut; // Filtered data will go into the tbody
}

searchbar_mutation.addEventListener("input", Search_mutation);

//search function for genes table
//grabbing references
var searchbar_gene = document.getElementById("searchbar_gene");
var tbody_gene = document.getElementById("tbody3");
var originaltabledata_gene = tbody_gene.innerHTML; // Storing original html content

// Search function
function Search_gene() {
  tbody_gene.innerHTML = originaltabledata_gene; // Restoring original table when unfiltered
  let rows_gene = tbody_gene.children; // All of the table rows tags

  if (searchbar_gene.value.length < 1) {
    return; // Do not filter if you have no inputs
  }

  let filteredrows_gene = ""; // Initialize filtered rows as empty
  let searchtext_gene = searchbar_gene.value.toLowerCase(); // Case-sensitive search

  for (let i = 0; i < rows_gene.length; i++) {
    const gene_affected_col = rows_gene[i]
      .querySelector("td:nth-child(1)")
      .innerText.toLowerCase(); // taking text from gene column
    if (gene_affected_col === searchtext_gene) {
      // If text is found, add the entire row to filtered rows
      filteredrows_gene += rows_gene[i].outerHTML;
    }
  }
  tbody_gene.innerHTML = filteredrows_gene; // Filtered data will go into the tbody
}

searchbar_gene.addEventListener("input", Search_gene);

//register button
// JavaScript code to handle the button click event
document.getElementById("newpatient").addEventListener("click", function () {
  // Redirect to a new page (replace 'new-page.html' with the desired URL)
  window.location.href = "newpatient.php";
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
