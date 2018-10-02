<?php

include("../init.php");

//pre defined function that strips the whitespaces (or other characters)
//from either end of the string.
$username = trim($_POST['username']);
$forename = trim($_POST['forename']);
$surname = trim($_POST['surname']);
$password = trim($_POST['password']);
$phone_no = trim($_POST['phone_no']);

// ERROR HANDLING, CHECKING IF ALL FIELDS HAVE TEXT IN THEM
if (empty($forename)){
    redirect("../signup.php?error=empty");
    exit();
}
if (empty($surname)){
    redirect ("../signup.php?error=empty");
    exit();
}
if (empty($password)){
    redirect ("../signup.php?error=empty");
    exit();
}
if (empty($phone_no)){
    redirect ("../signup.php?error=empty");
    exit();
} else {// HASHING THE PASSWORD BEFORE IT'S INSERTED
        $enc_pwd = password_hash($password, PASSWORD_DEFAULT);
        // INSERT NEW USER DETAILS INTO DATABASE
        $sql = "INSERT INTO students (id,std_forename,std_surname,std_password,std_phone)
                VALUES ('$username','$forename','$surname','$enc_pwd','$phone_no')";
        // EXECUTE THE INSERTION
        $result = mysqli_query($conn, $sql);
        redirect("../login.php?success");
    }


