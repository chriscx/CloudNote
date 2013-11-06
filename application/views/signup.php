<?php include "header.php"?>
<div class="container">
<form action="val" method="post">
  <fieldset>
    <legend>Sign up</legend>
        <input type="text" placeholder="First Name" id="firstname" name="firstname"><br />
        <input type="text" placeholder="Last Name" id="lastname" name="lastname"><br />
        <input type="text" placeholder="E-mail" id="email" name="email">
        <input type="text" placeholder="E-mail confirmation" id="email_c"><br />
        <input type="password" placeholder="Password" id="password" name="password">
        <input type="password" placeholder="Password confirmation" id="password_c"><br />
    <label class="checkbox">
      <input type="checkbox"> Check me out
    </label>
    <button type="submit" class="btn">Submit</button>
  </fieldset>
</form>
</div>
<?php
    if(isset($userIsCreated)) {
        if($userIsCreated) {
            ?>
                <div class="container">
                    <div class="alert alert-success">
                        Account has been created :)
                    </div>
                </div>
            <?php
        }
        else {
            
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