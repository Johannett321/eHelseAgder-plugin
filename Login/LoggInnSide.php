<?php

require 'LoginTools.php';
include 'LoginChecker.php';

add_shortcode( 'sc_loginform', 'sc_loginform');

function sc_loginform( $atts ) {
    global $runningOnLocalHost;

    if (!useHTTPS() && !$runningOnLocalHost) {
        showLoginError("Du besøker ikke nettsiden på riktig måte. Vennligst besøk nettsiden via denne linken: https://www.ehelseagder.no");
        return;
    }

    if (isset($_GET['errorMessage'])) {
        showLoginError($_GET['errorMessage']);
    }

    ?>
    <form action = "../wp-json/ehelseagderplugin/api/login?prevpage=<?php echo $_GET["prevpage"] ?>" method = "post">
        <div class = "requiredPart" id = "loginBox">
            <h3 class = "mainTitle">Logg inn</h3>
            <label for="username">Brukernavn:</label>
            <input type="text" class = "small_input" id="username" name="username" placeholder="Brukernavn"><br>
            <label for="password">Passord:</label>
            <input type="password" class = "small_input" id="password" name="password" placeholder="Passord"><br>
            <center>
                <input type = "submit" class = "button" id = "submitButton" value = "Logg inn">
            </center>
        </div>
    </form>
    <?php
}