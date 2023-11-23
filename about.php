<?php
    include_once 'header.php'
?>
<body>
    <!--setting up the nav bar-->
    <header>
        <div class="container1">
            <img src = "images/snail.jpg" alt="logo" class="logo" width="70" height="70">
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="database.php">Database</a></li>
                    <li><div class="dropdown">
                        <a class="dropbtn">Login</a>
                        <div class="dropdown-content">
                            <a href="login-p.php">Patient</a>
                            <a href="login-r.php">Staff</a>
                        </div>
                    </div></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="card-single">
            <div class = "card">
                <h1><!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
}

html {
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: inherit;
}

.column {
  float: left;
  width: 33.3%;
  margin-bottom: 16px;
  padding: 0 8px;
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  margin: 8px;
}

.about-section {
  padding: 50px;
  text-align: center;
  background-color: #71B1C5;
  color: white;
}

.container {
  padding: 0 16px;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}

.title {
  color: grey;
}

.button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
}

.button:hover {
  background-color: #555;
}

@media screen and (max-width: 650px) {
  .column {
    width: 100%;
    display: block;
  }
}
</style>
</head>
<body>

<div class="about-section">
  <h1>About Us</h1>
  <p>Empowering researchers, oncologists, and genetic counselors in understanding and visualizing mutation variants in cancer patients.</p>
  <p>Welcome to CANCERICTIVE, a cutting-edge web-based platform dedicated to revolutionizing the management and visualization of mutation variants in diverse cancer patients. Tailored for researchers, oncologists, and genetic counselors, CANCERICTIVE offers a secure and intuitive interface to explore, analyze, and contribute to the understanding of cancer mutations.
    <h2 style="text-align:center">Mission Statement:</h2>
    <p>At CANCERICTIVE, our mission is to provide a robust, confidential, and user-friendly environment for professionals and researchers engaged in the study of cancer mutations. By seamlessly integrating advanced data management and visualization tools, we aim to accelerate breakthroughs in cancer research and improve patient outcomes.</p>
</div>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>

<div class="w3-container">
  <h2>Key Features:</h2>

  <div class="w3-panel w3-card w3-blue"><p>Secure Authentication</p></div>
  <div class="w3-panel w3-card-2 w3"><p>Personalized Dashboards</p></div>
  <div class="w3-panel w3-card-4 w3-blue"><p>Patient View</p></div>
  <div class="w3-panel w3-card-2 w3"><p>Oncologist View</p></div>
  <div class="w3-panel w3-card-4 w3-blue"><p>Researcher View</p></div>
  <div class="w3-panel w3-card-2 w3"><p>Patient Selection</p></div>
  <div class="w3-panel w3-card-4 w3-blue"><p>Mutation Overview</p></div>
  <div class="w3-panel w3-card-2 w3"><p>Treatment and Historical Data</p></div>
  <div class="w3-panel w3-card-4 w3-blue"><p>Reporting & Documentation</p></div>
  <div class="w3-panel w3-card-2 w3"><p>Security & Data Integrity</p></div>

</div>


<h2 style="text-align:center">Our Team</h2>
<div class="row">
  <div class="column">
    <div class="card">
      <img src="images/victoria.jpg" alt="Victoria" style="width:100%">
      <div class="container">
        <h2>Victoria Lee</h2>
        <p class="title">CEO</p>
        <p>Some text that describes me lorem ipsum ipsum lorem.</p>
        <p>Victoria@example.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>

  <div class="column">
    <div class="card">
      <img src="images/moey.jpeg" alt="moey" style="width:100%">
      <div class="container">
        <h2>Mohammed Ali</h2>
        <p class="title">COO</p>
        <p>Some text that describes me lorem ipsum ipsum lorem.</p>
        <p>mohammed@example.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>
  
  <div class="column">
    <div class="card">
      <img src="images/Ruchal.jpg" alt="ruchal" style="width:100%">
      <div class="container">
        <h2>Ruchal Kale</h2>
        <p class="title">Designer</p>
        <p>Some text that describes me lorem ipsum ipsum lorem.</p>
        <p>ruchal@example.com</p>
        <p><button class="button">Contact</button></p>
      </div>
    </div>
  </div>
</div>
<div>

    
</div>
</body>
</html>
</h1>
            </div>
        </div>
<?php
    include_once 'footer.php'
?>