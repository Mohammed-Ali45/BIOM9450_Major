<!--header file that can be referenced to in every page without having to redo write the block of code-->

<!DOCTYPE html>
<html>
<head>
    <!--setting up file-->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!--linking css files-->
    <link rel="resetsheet" type="text/css" href="css/reset.css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
    <!--linking js file-->
    <script defer src="validation.js"></script>
    
    <!--inputting fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <title>Cancerictive</title>

</head>

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
