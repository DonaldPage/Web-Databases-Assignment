<?php
session_start();
include("includes/header.php");

//checks to see if the session from the login has been set.
//If no session is in place, send back to login.
if (!isset($_SESSION['name'])) { redirect("login.php");}
?>

<body>
<div class="container">
    <br>
    <br>
    <!-- Page Heading -->
    <div class="row">
        <div class="col-sm-12">

            <div class="col-sm-1"></div>

            <div class="col-sm-10">

                <h1 class="page-header">
                    <small>Welcome <?php echo $_SESSION['name']; ?> to your profile page.</small>
</h1>
</div>
<div class="col-sm-1">
    <a href="includes/logout.inc.php" type="submit" name="submit" value="submit" class="btn btn-primary">Logout</a>
</div>
</div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-sm-3">




    </div>
    <div class="col-sm-7">









    </div>
    <div class="col-sm-2"></div>
</div>
<!-- .row -->
</div>
<!-- .container -->
</body>