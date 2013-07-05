<h2>Welcome to Eclub</h2>
<p>So head over to the <?php print anchor('auth/login','login page')?> and get started. Currently you are
<?php
    if(is_user())
        print "<font color='green'><b>logged in</b></font>";
    else
        print "<font color='red'><b>logged out</b></font>";
?>.</p>