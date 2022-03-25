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

/**
 * Genererer en HTML blokk med en egendefinert errormelding
 * @param $errorMessage
 */
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

/**
 * Reserverer URL'en slik at man må logge inn for å kunne se denne siden.
 * @param $pageTitle
 */
function securePageWithLogin($pageTitle) {
    error_log("Adding " . $pageTitle . " to list of pages requiring login");
    global $pagesRequireLogin;
    $pagesRequireLogin[sizeof($pagesRequireLogin)] = $pageTitle;
}


add_action('init', 'checkIfPageRequiresLogin');
/**
 * Sjekker om siden man besøker krever login. Dersom den gjør det, blir brukeren redirecta til login siden.
 * Det er derfor viktig at denne kjører før headeren blir sendt.
 */
function checkIfPageRequiresLogin() {
    global $pagesRequireLogin;
    $pageTitle = $_SERVER[REQUEST_URI];
    $pageTitle = strtolower($pageTitle);
    $pageTitle = substr($pageTitle, 1, strlen($pageTitle)-2);
    error_log("Sjekker om siden krever innlogging: " . $pageTitle);

    for ($i = 0; $i < sizeof($pagesRequireLogin); $i++) {
        if (strtolower($pagesRequireLogin[$i]) == $pageTitle) {
            error_log("Brukeren forsøker å besøke en side som krever innlogging");
            wp_redirect("../../../logg-inn");
            exit;
        }
    }
}