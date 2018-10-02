<?php
require_once ("../init.php");

//Fetches the password and id from the URL.
$username = $_POST['id'];
$password = $_POST['password'];

if (empty($password)){
    redirect("../coach_page.php?id=$username&reset=false");
    exit();
}

//Finding the first character of the password.
$id = substr("{$username}", -5, 1);

// Assigning the table names and correct start of the field names
// depending on the first character.

//Students settings
if($id == 2){
    $table = "students";
    $field = "std_";
}

//Coaches settings
if($id == 3){
    $table = "coaches";
    $field = "ch_";
}

//Updating the database, depending on the contents of the variables as set above.
$sql = "UPDATE $table SET " . $field . "password='$password' WHERE id='$username'";

// Executes the query.
$result = mysqli_query($conn, $sql);

//closes database connnection on this page.
mysqli_close($conn);

//Sends user straight back to the home page with a catchable message in the URL.
redirect("../coach_page.php?reset=true");




