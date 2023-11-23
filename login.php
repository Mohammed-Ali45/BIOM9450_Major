<?php
include_once 'header.php'
    ?>

<body>
    <!--setting up the nav bar-->
    <header>
        <div class="container1">
            <img src="images/snail.jpg" alt="logo" class="logo" width="70" height="70">
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="database.php">Database</a></li>
                    <li>
                        <div class="dropdown">
                            <a class="dropbtn" href="login.php">Login</a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">

        <div class="card-single">
            <div class="card1">
                <div class="card-header">Patient Login</div>
                <div class="card-body">
                    <form id="form" onsubmit="return validateForm()" action="includes/login-inc-test.php" method="post">
                        <div class="input-control">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="text" placeholder="example@gmail.com">
                            <div class="error"></div>
                        </div>
                        <div class="input-control">
                            <label for="password">Password</label>
                            <input id="password" name="password" type="password" placeholder="Password...">
                            <div class="error"></div>
                        </div>
                        <div class="card-footer">
                            <input type="reset" button class="btn btn-outline" value="Clear">
                            <!--clears all input fields-->
                            <input type="submit" button class="btn" value="Login" name="submit"> <!--submit button-->
                        </div>
                        <p>Don't have an account? <a href="signup.php">Sign up here!</a></p>
                    </form>
                </div>
            </div>
        </div>

        <?php
        include_once 'footer.php'
            ?>