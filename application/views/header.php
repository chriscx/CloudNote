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
    </head>
    <body>
        <div class="navbar navbar-inverse">
            <div class="navbar-inner">
                <a class="brand" href="#">CloudNote</a>
                    <ul class="nav">
                        <?php 
                            $isSignedIn = $this->session->userdata('logged_in');
                            if($isSignedIn){
                                ?>
                                <li class="active"><a href="#">Home</a></li>
                                <li><a href="#">Notes</a></li>
                                <li><a href="#">Reminders</a></li>
                                <li><a href="" class="">Sign Out</a></li>
                            <?php
                            }
                        ?>
                </ul>
            </div>
        </div>
            