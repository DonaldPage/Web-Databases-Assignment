<?php
include("../init.php");



    $team = $_GET['team'];
    $checkID = $_GET['student'];
    $team_capt = $_GET['captain'];

    $sql = "SELECT id FROM players_in_teams WHERE team_player='$checkID' && team='$team'";

    $result = mysqli_query($conn, $sql);

    //If no result is found then INSERT the data held in the variables above, into the perscribed table.
    if (!$row = mysqli_fetch_assoc($result)){

        //The $sql variable holds the Query as a string, which is passed  to the database below.
        $sql = "INSERT INTO players_in_teams (team,team_capt,team_player) VALUES ('$team','$team_capt','$checkID')";

        //mysqli_query executes the query to the database.
        $result = mysqli_query($conn, $sql);

        redirect ("../edit_team.php?team=$team&success");


    } else {

        //If theres is a match send the user back to login with an error in the URL.
        redirect ("../edit_team.php?team=$team&error=exists");

    }

