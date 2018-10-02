<?php
require_once ("init.php");
//This page is designed as a absrtact delete function
//If you want to use this page to delete an entry in
//a table, simply leave the table name and the contents
//of the WHERE clause in the URL.

// ERROR HANDLING, CHECKING IF ALL FIELDS HAVE TEXT IN THEM

//Gianing the information from the URL
$id = $_GET['id'];
$team = $_GET['team'];

// Validation to check if the user has entered a value.
if (empty($id)){
    redirect("edit_team.php?team=$team&error=empty");
    exit();
}


$sql = "DELETE FROM players_in_teams WHERE id=" . $id . " LIMIT 1";

$result = mysqli_query($conn, $sql);

mysqli_close($conn);

redirect("edit_team.php?team=$team&delete=done");



