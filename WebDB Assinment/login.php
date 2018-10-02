<?php include("includes/header.php");?>

<?php

$message = "";
$username = "";
$password = "";
$bad_message = "";

//GETS THE INFORMATION FROM THE URL
$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if(strpos($url, 'success')!== false){
    $message = "Your account has been created, please login.";
} elseif(strpos($url, 'error=empty')!== false){
    $bad_message = "Please enter both Username and Password to login.";
} elseif(strpos($url, 'error=invalid_pwd')!== false){
    $bad_message = "Username or Password does not match our records.";
} elseif(strpos($url, 'error=no_match')!== false){
    $bad_message = "You do not have an account, please sign up to login.";
}

?>
<div class="container">
    <br>
    <br>
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <form id="login-id" action="includes/login.inc.php" method="post">

                <div class="form-group">
                    <h4 class="bg-success"><?php echo $message; ?></h4>
                    <h4 class="bg-danger"><?php echo $bad_message; ?></h4>
                    <br>
                    <label for="username">Username</label>                              <!-- If the user enters the wrong info their entry will
                                                                                         be stored within a variable-->
                    <input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" >

                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">

                </div>

                <div class="form-group">
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">

                </div>

                <div class="form-group">
                    <a href="signup.php">Don't have an account?</a>

                </div>

            </form>
        </div>
        <div class="col-sm-4"></div>
    </div>
    <!-- .row -->
</div>
<!-- .container -->