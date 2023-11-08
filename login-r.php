<?php
    include_once 'header.php'
?>

<div class="card-single">
    <div class="card1">
        <div class="card-header">Researcher Login</div>
        <div class="card-body">
            <form id="form" onsubmit="return validateForm()" action="includes/login-inc.php" method="post" >
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
                <div class="input-control">
                    <label for="rid">Researcher ID</label>
                    <input id="rid" name="rid" type="text" placeholder="12345...">
                    <div class="error"></div>
                </div>
                <div class="card-footer">
                    <input type="reset" button class="btn btn-outline" value="Clear"> <!--clears all input fields-->
                    <input type="submit" button class="btn" value="Login"> <!--submit button-->
                </div>
            </form>
        </div>
    </div>
</div>

<?php
    include_once 'footer.php'
?>