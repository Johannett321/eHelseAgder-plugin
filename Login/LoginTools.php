<?php
function validateLoginFields() {
    if (!isset($_POST['username']) || strlen($_POST['username']) > 255 || !preg_match('/^[a-zA-Z- ]+$/', $_POST['username'])) {
        return "Brukernavn er feil formatert";
    }

    if (!isset($_POST['password']) || strlen($_POST['password']) > 255 || !preg_match('/^[a-zA-Z- ]+$/', $_POST['password']))
    return true;
}

function validateLoginInfo() {
    $username = "fellesbruker";
    $password = "Julebrus123";
    if ($_POST['password'] === $password && strtolower($_POST['username']) === $username) {
        return true;
    }else {
        return "Feil brukernavn eller passord";
    }
}

function useHTTPS() {
    return
        (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || $_SERVER['SERVER_PORT'] == 443;
}

function showLoginError($errorMessage) {
    ?>
    <div class = "infoBlokk">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <span class="material-icons">
            warning
        </span>
        <h5><?php echo $errorMessage ?></h5>
    </div>
    <?php
}

function requiresLogin() {
    if (!userIsLoggedIn()) {
        wp_redirect("../../../../../../../logg-inn?errorMessage=Denne siden krever innlogging");
    }
}

function jsonRequiresLogin() {

}