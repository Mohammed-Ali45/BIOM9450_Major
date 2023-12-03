# BIOM9450 Major Project 2023

The following repository demonstrates the development of a cancer mutation database website intended for use by patients, researchers, and oncologists.
This project had been build on the foundation of 4 specific languages, namely php, HTML, css, and javascript.
1. php was used to dynamically connect the database to the website. it was used to retrieve, display, and store information as needed.
2. HTML was used within php files to display information onto the website and for general website structures such as table, forms, body, and header tags.
3. css was used to style the website to be aesthetically pleasing and ensure smooth operability of the website through animations.
4. javascript was used throughout the website to write in the functionality of many aspects such as the search/filter function, validation functions, collapsible function, etc.


## A User Manual
When loading the index.php page, users are greeted with the home page. At the top, users will find a navigation bar to right of the website. There is a login button highlighted in green is
apparent and users will be able to use login via this link to view their information. By implementing login functions and session variables we are able to track which users who are currently logged in and bar specific users from accessing locations of the website that they do not have permission to.

## Patient View
- Users have view of their personal details under the profile tab.
- Users have view of their diagnosis including cancer type, treatment plan, and expected outcome noted by their assigned physician.
- Users have view of their mutational profile through which they are able to filter using the category selection and searchbar. Clicking on a specific mutation will display additional information below the row.

## Researcher/Oncologist View
- Staff have view of their profile in the profile tab
- Users are greeted with three collapsed sections. By hovering over the section title users are able to view information. 
- Users have view of entire patient list including their speciment ID. Within this table users are able to filter based on category selection and searchbar input. Users are also able to access
patient personal information by clicking the PatientID, and mutational information by clicking ICGC Speciment ID. By clicking either of these links users will be redirected to the corresponding
page.
- Users have view of mutations that exist in more than one patient table. Users are able to filter this based on MutationID.
- Users have view of genes affected that exist in more than one patient table. Users are able to fitler this based on Gene_affected.
- Users are able to insert new patient or new mutation information through which when these buttons are clicked users will be redirected to the corresponding page with appropriate forms to fill. 


Once users is finished with viewing their information, they are able to logout using the logout button in the navigation bar where login was previously.
