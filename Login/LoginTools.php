<?php

add_action( 'rest_api_init', 'rest_add_signout');

function rest_add_signout() {
    register_rest_route( 'ehelseagderplugin/api', '/logg_ut', array(
        'methods' => 'GET',
        'callback' => 'signOutUser',
    ));
}

/**
 * Logger ut brukeren og redirigerer brukeren tilbake til logg-inn siden.
 */
function signOutUser() {
    session_start();
    $_SESSION["UserIsLoggedIn"] = null;
    wp_redirect("../../../../../logg-inn?errorMessage=Du er nå logget ut!");
    exit;
}

function validateLoginFields() {
    if (!isset($_POST['username']) || strlen($_POST['username']) > 255 || !preg_match('/^[a-zA-Z- ]+$/', $_POST['username'])) {
        return "Brukernavn er feil formatert";
    }

    if (!isset($_POST['password']) || strlen($_POST['password']) > 255) {
        return "Passord er feil formatert";
    }
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

/**
 * Sjekker om siden blir lastet via en HTTPS connection.
 * @return bool True dersom det er HTTPS
 */
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
    if ($pagesRequireLogin != null) {
        $pagesRequireLogin[sizeof($pagesRequireLogin)] = $pageTitle;
    }else {
        $pagesRequireLogin[0] = $pageTitle;
    }
}


add_action('init', 'checkIfPageRequiresLogin');
/**
 * Sjekker om siden man besøker krever login. Dersom den gjør det, blir brukeren redirecta til login siden.
 * Det er derfor viktig at denne kjører før headeren blir sendt.
 */
function checkIfPageRequiresLogin() {
    session_start();
    global $pagesRequireLogin;

    $pageTitle = $_SERVER["REQUEST_URI"];
    $pageTitle = strtolower($pageTitle);
    $pageTitle = substr($pageTitle, 1, strlen($pageTitle)-2);
    error_log("Sjekker om siden krever innlogging: " . $pageTitle);

    for ($i = 0; $i < sizeof($pagesRequireLogin); $i++) {
        if (strtolower($pagesRequireLogin[$i]) == $pageTitle) {
            //Er brukeren logget inn?
            if ($_SESSION["UserIsLoggedIn"] != null && $_SESSION["UserIsLoggedIn"] == "true") {
                //Brukeren er logget inn
                error_log("Brukeren forsøker å besøke en side som krever innlogging. Brukeren er innlogget, og får se siden");
            }else {
                //Brukeren er ikke logget inn
                error_log("Brukeren forsøker å besøke en side som krever innlogging. Brukeren er IKKE innlogget, og blir omdirigert til login");
                redirectToLoginAndExit();
            }
        }
    }
}

/**
 * Gjør akkurat det funksjonen sier.
 */
function redirectToLoginAndExit() {
    wp_redirect("../../../logg-inn?prevpage=" . $_SERVER["REQUEST_URI"]);
    exit;
}

/**
 * Sjekker om brukeren er logget inn, og redirigerer brukeren til login siden hvis ikke.
 */
function jsonRequiresLogin() {
    if ($_SESSION["UserIsLoggedIn"] == null || $_SESSION["UserIsLoggedIn"] != "true") {
        error_log("Brukeren er ikke innlogget, og får ikke kjøre dette json scriptet");
        redirectUserBackToLogin("Denne siden krever innlogging");
    }
}

/**
 * Sjekker om brukeren er logget inn og returnerer true eller false.
 * @return bool True dersom brukeren er logget inn.
 */
function userIsLoggedIn() {
    if ($_SESSION["UserIsLoggedIn"] != null || $_SESSION["UserIsLoggedIn"] == "true") {
        return true;
    }else {
        return false;
    }
}