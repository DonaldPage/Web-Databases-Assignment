<?php
//Starts a session or resumes one already running.
//Alowing me to grab, preset user details that can be used
//to provide things like tailered content while a user is "logged in".
session_start();

//includes the header page and all of it's content on this page.
include("includes/header.php");

//checks to see if the session from the login has been set.
//If no session is in place, send back to login.
if (!isset($_SESSION['name'])) { redirect("login.php");}

//Assigning the users ID to a variable so it can be used within this page.
$user = $_SESSION['id'];

// Setting the message variables to blank so they don't show unless
//they contain a "message".
$message = "";
$bad_message = "";
$messageAlt = "";
$bad_messageAlt = "";


//GETS THE INFORMATION FROM THE URL
$url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

//finds the first time the substring is used within the whole string.
//If it's not false, message variable is populated with a string.
if(strpos($url, 'error=empty')!== false){
    $bad_message = "Please fill out all fields!";
} elseif(strpos($url, 'success')!== false){
    $message = "Your team has been created";
} elseif(strpos($url, 'reset=true')!== false){
    $messageAlt = "Password updated";
} elseif(strpos($url, 'reset=false')!== false){
    $bad_messageAlt = "You must enter a new password!";
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
                <div class="col-sm-10">
                    <h1 class="page-header">
                        <!-- Using the users name, gained from the session, to provide a tailored welcome note -->
                        <small>Welcome <?php echo $_SESSION['name']; ?> to your profile page.</small>
                    </h1>
                </div>
            <div class="col-sm-1">
                <a href="includes/logout.inc.php" type="submit" name="submit" value="submit" class="btn btn-primary">Logout</a>
            </div>
        </div>
    </div>
    <!-- /.row -->

    <!-- CREATE A TEAM -->
    <div class="row">
        <div class="col-sm-12">
        <div class="col-sm-4">
            <form action="includes/create_team.php" method="post">
                <div class="form-group">
                    <!-- Displays a message if one is available-->
                    <h4 class="bg-success"><?php echo $message; ?></h4>
                    <h4 class="bg-danger"><?php echo $bad_message; ?></h4>
                    <h4 for="user_type">Create a new team</h4><br>
                    <label for="team">Enter new team name</label><br>
                    <!-- Form that will action the create_team page to run the query used to insert the new
                         team into the teams table-->
                    <input type="text" class="form-group" name="team"">
                </div>

                    <!-- Using while loop to populate the dropdown with a list of availale sports
                         gained from the sports table, via the query-->
                    <div class="form-group">

                            <select name="sport">
                                <option value="">Choose a sport</option>
                                <?php
                                // Search for all users ID's from the sports table, where the coach ID matches the users ID.
                                $sql = "SELECT id FROM sports WHERE spt_coach='$user'";

                                //Executing the query using a preset PHP function.
                                $result = mysqli_query($conn, $sql);

                                // Loops through all results and populates the drop-down list is the ID's from the sports table.
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></option>
                                <?php
                                }
                                // PHP function that frees up the memory associated with the result.
                                mysqli_free_result($result); ?>
                            </select>

                        <div class="form-group">
                            <!-- Hidden input used to pass the users ID from the session, to the URL -->
                            <input type="hidden" name="username" value=" <?php echo $user; ?>">

                        </div>
                    </div>

                    <!-- Using while loop to populate the dropdown with a list of availale fields
                         gained from the sports table, via the query-->
                    <div class="form-group">

                            <select name="field">
                                <option value="">Choose a field</option>
                                <?php
                                $sql = "SELECT id FROM fields";

                                $result = mysqli_query($conn, $sql);

                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></option>
                                    <?php
                                }
                                mysqli_free_result($result); ?>
                            </select>


                    </div>

                    <div class="form-group">
                        <input type="submit" name="submit" value="Create" class="btn btn-primary">
                    </div>
            </form>

            <!-- /. CREATE A TEAM -->

            <br>
            <br>

            <!-- TEAM EDIT SELECTION -->

            <div class="form-group">
                <label for="team">Pick a team to edit</label>
            <form action="edit_team.php" method="post">
                <div class="form-group">
                    <select name="team">
                        <option value="">Choose a team</option>
                        <?php
                        $sql = "SELECT id FROM teams WHERE team_coach=$user";

                        $result = mysqli_query($conn, $sql);

                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['id']; ?></option>
                            <?php
                        }
                        mysqli_free_result($result); ?>
                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" name="submit" value="Edit" class="btn btn-primary">
                </div>

            </form>

            </div>

            <!-- /. TEAM EDIT SELECTION -->


        <!-- .sm 4 -->
        </div>

        <div class="col-sm-1"></div>
            <div class="col-sm-3">

                <!-- PASSWORD RESET -->

                <div class="form-group">
                    <!-- Displays a message if one is available-->
                    <h4 class="bg-success"><?php echo $messageAlt; ?></h4>
                    <h4 class="bg-danger"><?php echo $bad_messageAlt; ?></h4>
                    <h4 for="user_type">Change users Password</h4>

                    <!-- Radio buttons to allow me to set a value that will be used as the table name in the query -->
                    <form action="coach_page.php" method="post">
                        <div class="form-group">
                            <label for="user_type">Choose a user type</label>
                            <div class="radio">
                                <label><input type="radio" name="user_type" value="students" checked>Student</label>
                                <label> </label>
                                <label><input type="radio" name="user_type" value="coaches">Coach</label> &nbsp;&nbsp;
                                <input type="submit" name="submit" value="Select" class="btn btn-primary btn-xs">
                            </div>
                        </div>
                    </form>

                    <?php

                        //Ternary operator to set the table name, depending on the result from the URL.
                        (isset($_POST['user_type'])) ? $table = $_POST['user_type'] : $table = "";

                        //Ternary operator to set the begining of the field name,  depending on the result from the URL.
                        ($table == "students") ? $field = "std_" : $field = "ch_"; ?>

                    <!-- Drop-down list that will hold ID, forename and surname from either the Students or Coaches table -->
                    <form action="coach_page.php" method="post">
                        <div class="form-group">
                            <select name="id">
                                <option value="">Choose a user</option>
                                <?php

                                //Abstract query that allows me to search for the table name provided by the radio buttons.
                                $sql = "SELECT id, " . $field . "forename, " . $field . "surname FROM " . $table;

                                $result = mysqli_query($conn, $sql);

                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) { ?>
                                    <option value="<?php echo $row['id']; ?>"><?php echo $row[$field . 'forename'] . " " . $row[$field . 'surname']; ?></option>
                                    <?php
                                }

                                mysqli_free_result($result); ?>
                            </select>&nbsp;&nbsp;
                            <input type="submit" name="submit" value="Select" class="btn btn-primary btn-xs">
                        </div>
                    </form>

                    <br>

                    <!-- Input box used to pass the new TEMPORARY password to the update page -->

                    <form action="includes/update_pword.php" method="post">
                        <h4 for="user_type">Set temporary password</h4>
                        <input type="password" class="form-group" name="password"">

                        <!-- Hidden input to pass the id chosen above to the update page. -->
                        <!-- Value contains the id from the URL, but only if it is set, and echos it in place. -->
                        <input type="hidden" class="form-group" name="id" value="<?php if(isset($_POST['id'])){ $id = $_POST['id']; echo $id;} ?>">
                        <div class="form-group">
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
                        </div>
                    </form>

                </div>

                <!-- /. PASSWORD RESET -->

            </div>
        <div class="col-sm-6"></div>
    </div>

    </div>
    <!-- .row -->
</div>
<!-- .container -->
</body>
