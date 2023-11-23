//search and filter function
//getting the references
var searchbar = document.getElementById('searchbar');
var category = document.getElementById('category');
var tbody = document.getElementById('tbody1');
var orignaltabledata = tbody.innerHTML;

//search function
function Search() {
    tbody.innerHTML = orignaltabledata;
    let rows = tbody.children; //all of the table tows tags

    if(searchbar.value.length < 1 || category.value == '0') {
        return; //do not filter if you have no inputs
    }

    let filteredrows = ''; //initialize filtered rows as empty
    let catno = Number(category.value) -1; //index of array starts from 0
    let searchtext = searchbar.value.toLowerCase();

    for (let i = 0; i < rows.length; i++) {
        const currentrowtext = rows[i].children[catno].innerText.toLowerCase(); //assigning tr's table cell according to the category selected
        if(currentrowtext.indexOf(searchtext) > -1){ //if text is found will return index and will return filtered row
            filteredrows += rows[i].outerHTML //current row
        }
    }
    tbody.innerHTML = filteredrows; //filtered data will go into the tbody
}
searchbar.addEventListener('input', Search);

//register button
// JavaScript code to handle the button click event
document.getElementById('newpatient').addEventListener('click', function() {
    // Redirect to a new page (replace 'new-page.html' with the desired URL)
    window.location.href = 'patient.php';
});

