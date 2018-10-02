<!-- Includes the header file and all of it's settings on this page, at this point -->
<?php include("includes/header.php");

//Setting the meassgae avariable to show empty, so it only displays if
//it holds a populated string.
$message = "";

//GETS THE INFORMATION FROM THE URL
$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

//finds the first time the substring is used within the whole string.
//If it's not false, message variable is populated with a string.
if(strpos($url, 'error=username')!== false){
    $message = "Username already exists!";
}

//Code only runs if 'submit' appears in the URL.
if (isset($_POST['submit'])) {

    //Gain the contents of the input box from the URL and store it
    //in this variable.
    $username = $_POST['username'];

    // ------ VALIDATION -------

    // Checks to confirm the string entered into $username is the correct length.
    if (strlen($username) == 5) {

            // Uses substr function to find the first character of the string entered
            // into the URL when the submit button is pressed.
            $id = substr("{$username}", -5, 1);

            // If the first character is a 2 then send the user to the student sign up page.
            if ($id == 2) {

                //Checking if the id entered allready exists in the Students table
                $sql = "SELECT id FROM students WHERE id='$username'";
                $result = mysqli_query($conn, $sql);
                //Gives a value of how many rows there is in $result.
                $uidcheck = mysqli_num_rows($result);

                if ($uidcheck > 0) {

                    redirect("signup.php?error=username");
                    exit();

                } else {

                    redirect("stud_signup.php?id={$username}");

                }


            // If the first character is a 3 then send the user to the coach sign up page.
            } elseif ($id == 3) {

                $sql = "SELECT id FROM coaches WHERE id='$username'";
                $result = mysqli_query($conn, $sql);
                $uidcheck = mysqli_num_rows($result);

                if ($uidcheck > 0) {

                    redirect("signup.php?error=username");
                    exit();

                } else {

                    redirect("ch_signup.php?id={$username}");

                }

                // otherwise assume the ID entered is not valid so display a warning message.
            } else {

                $message = "Please enter a valid ID";

            }



    } else {

        // If the string doesn't match the required length then display a warning message.
        $message = "Please enter a valid ID";
    }

}


?>

<body>
    <div class="container">
        <br>
        <br>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <form action="#" method="post">

                    <h4 class="bg-danger"><?php echo $message; ?></h4>

                    <div class="form-group">
                        <label for="username">Enter your ID number</label>
                        <input type="text" class="form-control" name="username"">

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

