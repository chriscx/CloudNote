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
        if(isset($result)) {
            echo $result;
        }
    ?>

<?php include "footer.php"?>