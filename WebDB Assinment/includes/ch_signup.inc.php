<?php
include("../init.php");

//pre defined function that strips the whitespaces (or other characters)
//from either end of the string.
$username = trim($_POST['username']);
$forename = trim($_POST['forename']);
$surname = trim($_POST['surname']);
$password = trim($_POST['password']);
$room_no = trim($_POST['room_no']);
$office_no = trim($_POST['office_no']);
$phone_no = trim($_POST['phone_no']);

// ERROR HANDLING, CHECKING IF ALL FIELDS HAVE TEXT IN THEM
if (empty($forename)){
    redirect("../ch_signup.php?id=$username&error=empty");
    exit();
}
if (empty($surname)){
    redirect ("../ch_signup.php?id=$username&error=empty");
    exit();
}
if (empty($password)){
    redirect ("../ch_signup.php?id=$username&error=empty");
    exit();
}
if (empty($room_no)){
    redirect ("../ch_signup.php?id=$username&error=empty");
    exit();
}
if (empty($office_no)){
    redirect ("../ch_signup.php?id=$username&error=empty");
    exit();
}
if (empty($phone_no)){
    redirect ("../ch_signup.php?id=$username&error=empty");
    exit();
} else {// HASHING THE PASSWORD BEFORE IT'S INSERTED
    $enc_pwd = password_hash($password, PASSWORD_DEFAULT);

    // INSERT NEW USER DETAILS INTO DATABASE
    $sql = "INSERT INTO coaches (id,ch_forename,ch_surname,ch_password,ch_room_no,ch_office_ext,ch_mob_no)
                VALUES ('$username','$forename','$surname','$enc_pwd','$room_no','$office_no','$phone_no')";
    // EXECUTE THE INSERTION
    $result = mysqli_query($conn, $sql);
    redirect("../login.php?success");
}