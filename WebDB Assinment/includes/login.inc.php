<?php
session_start();

require_once ("../init.php");

//Variables to hold the values entered in the login input fields.
//Using the super-global $_POST.
$username = $_POST['username'];
$password = $_POST['password'];

//VALIDATION

//If nothing is entered then go back to login page and display error message in URL.
if (empty($password)){
    redirect("../login.php?error=empty");
    exit();
}
//If nothing is entered then go back to login page and display error message in URL.
if (empty($username)){
    redirect("../login.php?error=empty");
    exit();
}

//First I have to check which type of user is trying to login, so I can
//query the relevant table.
$user_type = substr("{$username}", -5, 1);

//If result shows a student
if($user_type == 2){

        //The query is held as a string within the variable $sql.
        $sql = "SELECT id, std_password FROM students WHERE id='$username'";
        //Uses the php function that executes the query by using the data held within
        //the connection and the query variables.
        $result = mysqli_query($conn, $sql);
        //Holds the results of the query within an array.
        $row = mysqli_fetch_assoc($result);
        //Variable that holds the hashed p/w gained from the array.
        $hash_password = $row['std_password'];
        //compares the two hashed results in order to verify password entered at login.
        $hash = password_verify($password, $hash_password);

        //If the result of password_verify is a 0, there is no match
        //If the result is 1 then there is a match.
        if ($hash == 0){
            //If there's no match, go to the home page and display an error in the url.
            redirect ("../login.php?error=invalid_pwd");
        } else {
            //If there is a match then run the SELECT query to search for the username and
            //the matched, hashed password that is contained in $hash_password.
            $sql = "SELECT id, std_password FROM students WHERE id='$username' AND std_password='$hash_password'";

            $result = mysqli_query($conn, $sql);

            //Checks to see if there is a match held within $row.
            if (!$row = mysqli_fetch_assoc($result)){
                //If theres no match send the user back to login with an error in the URL.
                redirect ("../login.php?error=invalid_pwd");
            } else {

                //The query is held as a string within the variable $sql.
                $sql = "SELECT * FROM students WHERE id='$username'";
                //Executes the query and holds the results within $result.
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);

                $_SESSION['name'] = $row['std_forename'];

                redirect ("../stud_page.php");
            }
        } //end of login code

//If result shows a coach
} elseif ($user_type == 3) {

    //The query is held as a string within the variable $sql.
    $sql = "SELECT id, ch_password FROM coaches WHERE id='$username'";
    //Uses the php function that executes the query by using the data held within
    //the connection and the query variables.
    $result = mysqli_query($conn, $sql);
    //Holds the results of the query within an array.
    $row = mysqli_fetch_assoc($result);
    //Variable that holds the hashed p/w gained from the array.
    $hash_password = $row['ch_password'];
    //compares the two hashed results in order to verify password entered at login.
    $hash = password_verify($password, $hash_password);

    //If the result of password_verify is a 0, there is no match
    //If the result is 1 then there is a match.
    if ($hash == 0){
        //If there's no match, go to the home page and display an error in the url.
        redirect ("../login.php?error=invalid_pwd");
    } else {
        //If there is a match then run the SELECT query to search for the username and
        //the matched, hashed password that is contained in $hash_password.
        $sql = "SELECT id, ch_password FROM coaches WHERE id='$username' AND ch_password='$hash_password'";

        $result = mysqli_query($conn, $sql);

        //Checks to see if there is a match held within $row.
        if (!$row = mysqli_fetch_assoc($result)){
            //If theres no match send the user back to login with an error in the URL.
            redirect ("../login.php?error=invalid_pwd");
        } else {

            $sql = "SELECT * FROM coaches WHERE id='$username'";
            //Executes the query and holds the results within $result.
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);

            $_SESSION['name'] = $row['ch_forename'];

            $_SESSION['id'] = $row['id'];
            redirect ("../coach_page.php");
        }
    } //end of login code

} else {

    //If theres no match send the user back to login with an error in the URL.
    redirect ("../login.php?error=no_match");

}






