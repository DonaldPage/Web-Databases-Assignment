<?php
//Starts a session or resumes one already running.
//Alowing me to grab, preset user details that can be used
//to provide things like tailered content while a user is "logged in".
session_start();

//Includes the header file and all of it's settings on this page, at this point.
include("includes/header.php");

//checks to see if the session from the login has been set.
//If no session is in place, send back to login.
if (!isset($_SESSION['name'])) { redirect("login.php");}

//Sets the $team variable depending on the state of the URL.
(!isset($_GET['submit'])) ? $team = $_GET['team'] : $team = $_POST['team'];

$user = $_SESSION['id'];

$message = "";
$bad_message = "";

//GETS THE INFORMATION FROM THE URL
$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if(strpos($url, 'error=exists')!== false){
    $bad_message = "Player is already on this team!";
} elseif(strpos($url, 'success')!== false){
    $message = "Student has been added to the team";
} elseif(strpos($url, 'error=empty')!== false) {
    $bad_message = "No ID was defined!";
} elseif(strpos($url, 'delete=done')!== false) {
    $message = "Student has been removed from the team";
}

?>

<body>
    <div class="container">
        <br>
        <br>
        <!-- Page Heading -->
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-1"></div>
                <div class="col-sm-8">
                    <h1 class="page-header">
                        <small>Below are the students in team: <?php echo $team ?></small>
                    </h1>
                </div>
                <div class="col-sm-3">
                    <a href="coach_page.php" type="submit" name="submit" value="submit" class="btn btn-primary">Home</a>&nbsp;&nbsp;
                    <a href="includes/logout.inc.php" type="submit" name="submit" value="submit" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
        <!-- /.row -->

        <!-- TEAM LIST -->
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <table class="table table-hover">
                        <thread>
                            <tr>
                                <th>Student ID</th>
                                <th>Forename</th>
                                <th>Surname</th>
                                <th>Team Name</th>
                                <th>Captain</th>
                            </tr>
                        </thread>
                        <tbody>

                        <?php

                        //SELECT quesry that joins the two tables together to get only the fileds I need from each table
                        //WHERE the team in the teams table matches the value held within $team.
                        $sql = "SELECT students.std_forename, students.std_surname, players_in_teams.id,
                                players_in_teams.team_player, players_in_teams.team, players_in_teams.team_capt 
                                FROM students 
                                INNER JOIN players_in_teams 
                                ON students.id=players_in_teams.team_player
                                WHERE players_in_teams.team='$team'";

                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>

                            <tr>
                                <td><?php echo $row['team_player']; ?>
                                    <div class="pictures_link links_style">
                                        <a href="delete.php?id=<?php echo $row['id']; ?>&team=<?php echo $team?>">Remove from team</a>
                                    </div>
                                </td>
                                <td><?php echo $row['std_forename']; ?></td>
                                <td><?php echo $row['std_surname']; ?></td>
                                <td><?php echo $row['team']; ?></td>
                                <!-- Converting the 1 or 0 that comes back from the database to Yes or No for the user.
                                     Using a Ternary operator, just because it looks much tidier.-->
                                <td><?php echo ($row['team_capt'] == 1) ? "Yes" : "No"; ?></td>
                            </tr>

                            <?php
                        }
                        mysqli_free_result($result); ?>


                        </tbody>

                    </table>
                </div>
                <div class="col-sm-1"></div>
            </div>
        </div>
        <!-- /.TEAM LIST -->

        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <!-- Using while loop to populate the dropdown with a list of availale students
                         gained from the students table, via the query-->
                    <form action="includes/add_team_member.php" method="get">
                        <!-- Displays a message if one is available-->
                        <h4 class="bg-success"><?php echo $message; ?></h4>
                        <h4 class="bg-danger"><?php echo $bad_message; ?></h4>
                        <div class="form-group">
                            <label for="student">Put a student on this team</label><br>
                            <select name="student">
                                <option value="">Choose a student</option>
                                <?php
                                $sql = "SELECT id, std_forename, std_surname FROM students";

                                $result = mysqli_query($conn, $sql);

                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                    <option id="" value="<?php echo $row['id']; ?>"><?php echo $row['std_forename'] . " " . $row['std_surname']; ?></option>

                                    <?php
                                }
                                mysqli_free_result($result); ?>
                            </select>
                        </div>

                        <!-- Radio buttons to enter 1 or 0 for the team captain field in
                             players_in_teams-->
                        <div class="form-group">
                            <label for="captain">Team Captain?</label>
                            <div class="radio">
                                <label><input type="radio" name="captain" value="1">Yes</label>
                                <label> </label>
                                <label><input type="radio" name="captain" value="0" checked>No</label>
                            </div>
                        </div>

                        <!-- Using a hidden html input to hold the value of the team name
                             after the submit button has been pressed-->
                        <div class="form-group">
                            <input type="hidden" name="team" value="<?php echo $team; ?>">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="submit" value="Join Team" class="btn btn-primary">
                        </div>
                    </form>
                </div>
                <!-- /.div 10 -->
                <div class="col-sm-3"></div>
            </div>
        </div>
        <!-- /.row -->










    </div>
    <!-- /.container -->
</body>