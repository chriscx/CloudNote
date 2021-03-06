<!DOCTYPE html>
<html lang="en">
    <head>
	   <meta charset="utf-8">
	   <title>CloudNote</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../../assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
        <link href="../../assets/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" type="text/css">
        <link href="../../assets/style.css" rel="stylesheet" type="text/css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="../../assets/bootstrap/js/bootstrap.js"></script>
        <script src="../../assets/js/Note.js"></script>
        <script src="../../assets/js/Reminder.js"></script>
        <script src="../../assets/js/ui.js"></script>
        <script src="../../assets/cookie_jquery/jquery.cookie.js"></script>
    </head>
    <body>
        <div class="navbar navbar-inverse" id="nav_bar">
            <div class="navbar-inner">
                <a class="brand" href="#">CloudNote</a>
                    <ul class="nav">
                        <?php 
                            $isSignedIn = $this->session->userdata('signed_in');
                            if($isSignedIn){
                                ?>
<!--                                 <li class="active"><a href="#">Home</a></li>
                                <li><a href="#">Notes</a></li>
                                <li><a href="#">Reminders</a></li> -->
                                <li class="active"><a href="../main/">Home</a></li>
                                <li><a href="../bug_report/">Report a bug</a></li>
                                <li><a href="../signout/">Sign out</a></li>
                            <?php
                            }
                            else {
                                ?>
                                <li><a href="../signin/">Sign In</a></li>
                                <li><a href="../signup/">Sign Up</a></li>
                                <?php
                            }
                        ?>
                </ul>
            </div>
        </div>
            