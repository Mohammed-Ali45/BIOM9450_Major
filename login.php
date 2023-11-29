<?php
include_once 'header.php'
    ?>

<body>
    <!--setting up the nav bar-->
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
                    <li><a class="dropbtn" href="login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">

        <div class="card-single">
            <div class="card1">
                <div class="card-header">Login</div>
                <?php $current_url = $_SERVER['REQUEST_URI'];
                if ($_SERVER['REQUEST_URI'] == '/BIOM9450_Major/login.php?error=invalidcredentials') {
                    echo '<p class="invalid_creds">Invalid credentials. Please try again.</p>';
                }

                ?>
                <div class="card-body">
                    <form id="formLogin" action="includes/login-inc.php" method="post">
                        <div class="input-control">
                            <label for="email">Email</label>
                            <input class="input-type-text" id="email" name="email" type="text"
                                placeholder="example@gmail.com">
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
                            <input type="submit" button class="btn" value="Login" name="btnsubmit">
                            <!--submit button-->
                        </div>
                        <p>Don't have an account? <a class="hyperlink" href="signup.php">Sign up here!</a></p>
                    </form>
                </div>
            </div>
        </div>

        <?php
        include_once 'footer.php'
            ?>