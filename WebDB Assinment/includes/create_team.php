<?php

require_once ("../init.php");

$id = $_POST['team'];
$team_sport = $_POST['sport'];
$team_field = $_POST['field'];
$team_coach = $_POST['username'];

//VALIDATION

//If nothing is entered then go back to login page and display error message in URL.
if (empty($id)){
    redirect("../coach_page.php?error=empty");
    exit();
} elseif (empty($team_sport)){
    redirect("../coach_page.php?error=empty");
    exit();
} elseif (empty($team_field)){
    redirect("../coach_page.php?error=empty");
    exit();
}

$sql = "INSERT INTO teams (id,team_sport,team_field,team_coach)
        VALUES ('$id','$team_sport','$team_field','$team_coach')";

$result = mysqli_query($conn, $sql);

redirect("../coach_page.php?success");