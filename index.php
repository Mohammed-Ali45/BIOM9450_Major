<?php
include_once 'header.php'
  ?>

<body>
  <!--setting up nav bar-->
  <header>
    <div class="container1">
      <div>
        <img src="images/snail.jpg" alt="logo" class="logo">
        <div id="logo-text">
          <span id="cancerictive-text" class="DM-Serif">Cancerictive</span>
          <br />
          <span id="slogan-text" class="Lato">Innovation & Compassion</span>
        </div>
      </div>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="database.php">Database</a></li>
          <li>
            <a class="dropbtn" href="login.php">Login</a>
          </li>
        </ul>
      </nav>
    </div>
  </header>



  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      font-family: "Raleway", sans-serif
    }

    body,
    html {
      height: 100%;
      line-height: 1.8;
    }

    /* Full height image header */
    .bgimg-1 {
      background-position: center;
      background-size: cover;
      background-image: url("images/research.jpg");
      min-height: 100%;
    }

    .w3-bar .w3-button {
      padding: 16px;
    }
  </style>
  </head>

  <body>






    <!-- Header with full-height image -->
    <header class="bgimg-1 w3-display-container w3-grayscale-min" id="home">
      <div class="w3-display-left w3-text-white" style="padding:48px">
        <span class="w3-jumbo w3-hide-small">CANCERICTIVE</span><br>
        <span class="w3-xxlarge w3-hide-large w3-hide-medium">CANCERICTIVE</span><br>
        <span class="w3-large">Empowering researchers, oncologists, and genetic counselors in understanding and
          visualizing mutation variants in cancer patients.</span>
        <p><a href="about.php"
            class="w3-button w3-white w3-padding-large w3-large w3-margin-top w3-opacity w3-hover-opacity-off">Learn
            more and start today</a></p>
      </div>
      <div class="w3-display-bottomleft w3-text-grey w3-large" style="padding:24px 48px">
        <i class="fa fa-facebook-official w3-hover-opacity"></i>
        <i class="fa fa-instagram w3-hover-opacity"></i>
        <i class="fa fa-twitter w3-hover-opacity"></i>
        <i class="fa fa-linkedin w3-hover-opacity"></i>
      </div>
    </header>



    <!-- Promo Section - "We know " -->
    <div class="w3-container w3-light-grey" style="padding:128px 16px">
      <div class="w3-row-padding">
        <div class="w3-col m6">
          <h3>We know</h3>
          <p>"Welcome to CANCERICTIVE, where innovation meets compassion in our collective pursuit of understanding and
            visualizing mutation variants in cancer patients. Our platform is tailored for researchers, oncologists, and
            genetic counselors, providing a secure and intuitive space for advancing cancer research."</p>
          <p><a href="#work" class="w3-button w3-black"><i class="fa fa-th"> </i> View Our Works</a></p>
        </div>
        <div class="w3-col m6">
          <img class="w3-image w3-round-large" src="images/microscope.jpg" alt="microscope" width="700" height="394">
        </div>
      </div>
    </div>



    <!-- Promo Section "Statistics" -->
    <div class="w3-container w3-row w3-center w3-dark-grey w3-padding-64">
      <div class="w3-quarter">
        <span class="w3-xxlarge">50+</span>
        <br>Researchers
      </div>
      <div class="w3-quarter">
        <span class="w3-xxlarge">55+</span>
        <br>Oncologists
      </div>
      <div class="w3-quarter">
        <span class="w3-xxlarge">20+</span>
        <br>Patients
      </div>
      <div class="w3-quarter">
        <span class="w3-xxlarge">15+</span>
        <br>Genetic counselors
      </div>
    </div>

    <!-- Work Section -->
    <div class="w3-container" style="padding:128px 16px" id="work">
      <h3 class="w3-center">OUR WORK</h3>
      <p class="w3-center w3-large">What we've done </p>

      <div class="w3-row-padding" style="margin-top:64px">
        <div class="w3-col l3 m6">
          <img src="images/Work (1).jpg" style="width:100%" onclick="onClick(this)" class="w3-hover-opacity" alt="moey">
        </div>
        <div class="w3-col l3 m6">
          <img src="images/Work (2).jpg" style="width:100%" onclick="onClick(this)" class="w3-hover-opacity" alt="moey">
        </div>
        <div class="w3-col l3 m6">
          <img src="images/Work (3).jpg" style="width:100%" onclick="onClick(this)" class="w3-hover-opacity" alt="moey">
        </div>
        <div class="w3-col l3 m6">
          <img src="images/Work (4).jpg" style="width:100%" onclick="onClick(this)" class="w3-hover-opacity" alt="moey">
        </div>
      </div>

      <!-- Modal for full size images on click-->
      <div id="modal01" class="w3-modal w3-black" onclick="this.style.display='none'">
        <span class="w3-button w3-xxlarge w3-black w3-padding-large w3-display-topright"
          title="Close Modal Image">×</span>
        <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
          <img id="img01" class="w3-image">
          <p id="caption" class="w3-opacity w3-large"></p>
        </div>
      </div>

      <!-- Skills Section -->
      <div class="w3-container w3-light-grey w3-padding-64">
        <div class="w3-row-padding">
          <div class="w3-col m6">
            <h3>User Role</h3>
            <p>Join a diverse community of professionals! Explore CANCERICTIVE where researchers, oncologists, and
              genetic counselors collaborate seamlessly.</p>

          </div>
          <div class="w3-col m6">
            <p class="w3-wide"><i class="fa fa-camera w3-margin-right"></i>Researchers</p>
            <div class="w3-grey">
              <div class="w3-container w3-dark-grey w3-center" style="width:90%">48%</div>
            </div>
            <p class="w3-wide"><i class="fa fa-desktop w3-margin-right"></i>Oncologists</p>
            <div class="w3-grey">
              <div class="w3-container w3-dark-grey w3-center" style="width:85%">35%</div>
            </div>
            <p class="w3-wide"><i class="fa fa-photo w3-margin-right"></i>Users</p>
            <div class="w3-grey">
              <div class="w3-container w3-dark-grey w3-center" style="width:75%">17%</div>
            </div>
          </div>
        </div>
      </div>


      <script>
        // Modal Image Gallery
        function onClick(element) {
          document.getElementById("img01").src = element.src;
          document.getElementById("modal01").style.display = "block";
          var captionText = document.getElementById("caption");
          captionText.innerHTML = element.alt;
        }


        // Toggle between showing and hiding the sidebar when clicking the menu icon
        var mySidebar = document.getElementById("mySidebar");

        function w3_open() {
          if (mySidebar.style.display === 'block') {
            mySidebar.style.display = 'none';
          } else {
            mySidebar.style.display = 'block';
          }
        }

        // Close the sidebar with the close button
        function w3_close() {
          mySidebar.style.display = "none";
        }
      </script>



    </div>
    </div>
    <?php
    include_once 'footer.php'
      ?>