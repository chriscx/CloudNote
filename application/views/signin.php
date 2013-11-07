<?php include "header.php"?>
    <div class="container">

        <form class="form-horizontal" action="check" method="post">
            <div class="control-group">
                <label class="control-label" for="inputEmail">Email</label>
                <div class="controls">
                    <input type="text" id="email" name="email" placeholder="Email">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPassword">Password</label>
                <div class="controls">
                    <input type="password" id="password" name="password" placeholder="Password">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <label class="checkbox"><input type="checkbox"> Remember me</label>
                    <button type="submit" class="btn">Sign in</button>
                </div>
            </div>
        </form>
    </div>

    <?php 
    echo realpath('../CloudNote/');
        if(isset($isAlreadySignedIn)) {
            echo $isAlreadySignedIn;
            if($isAlreadySignedIn) {
    ?>
            <div class="container">
                <div class="alert">
                    You are already signed in!
                </div>
            </div>
    <?php
            }
        }
    ?>

    <?php 
        if(isset($isSignedIn)) {
            echo $isSignedIn;
            if($isSignedIn) {
    ?>
            <div class="container">
                <div class="alert alert-error">
                    Something went wrong... try again!
                </div>
            </div>
    <?php
            }
        }
    ?>

<?php include "footer.php"?>