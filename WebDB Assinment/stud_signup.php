<?php include("includes/header.php");

$message = "";
$username = $_GET['id'];

//GETS THE INFORMATION FROM THE URL
$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if(strpos($url, 'error=empty')!== false){
    $message = "Please fill out all fields!";
}
?>

<body>
    <div class="container">
        <br>
        <br>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <form action="includes/stud_signup.inc.php" method="post">

                    <h4 class="bg-danger"><?php echo $message; ?></h4>

                    <h4 class="bg-success">Your Username will be set to <?php echo $username; ?></h4>
                    <br>

                    <div class="form-group">
                        <input type="hidden" class="form-control" name="username" value=" <?php echo $username; ?>">

                    </div>

                    <div class="form-group">
                        <label for="forename">Forename</label>
                        <input type="text" class="form-control" name="forename">

                    </div>

                    <div class="form-group">
                        <label for="surname">Surname</label>
                        <input type="text" class="form-control" name="surname">

                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password">

                    </div>

                    <div class="form-group">
                        <label for="phone_no">Phone Number</label>
                        <input type="text" class="form-control" name="phone_no">

                    </div>

                    <div class="form-group">
                        <input type="submit" name="submit" value="submit" class="btn btn-primary">

                    </div>

                    <div class="form-group">
                        <a href="login.php">Already have an account?</a>

                    </div>

                </form>
            </div>
            <div class="col-sm-4"></div>
        </div>
        <!-- .row -->
    </div>
    <!-- .container -->
</body>