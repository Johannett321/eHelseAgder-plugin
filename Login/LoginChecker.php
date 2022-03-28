<?php

add_action( 'rest_api_init', 'rest_add_login');

function rest_add_login() {
    register_rest_route( 'ehelseagderplugin/api', '/login', array(
        'methods' => 'POST',
        'callback' => 'startLoginProcedure',
    ));
}

function startLoginProcedure() {
    $fieldValidationResult = validateLoginFields();
    if ($fieldValidationResult !== true) {
        redirectUserBackToLogin($fieldValidationResult);
    }

    $passwordValidationResult = validateLoginInfo();
    if ($passwordValidationResult !== true) {
        redirectUserBackToLogin($passwordValidationResult);
    }else {
        userSignedInSuccessfully();
    }
}

function redirectUserBackToLogin($message) {
    error_log("A sign in request was rejected with the reason: " . $message);
    $redirectURL = "../../../logg-inn";
    if ($message != null) {
        $redirectURL .= "?errorMessage=" . $message;
    }
    wp_redirect($redirectURL);
    exit;
}

function userSignedInSuccessfully() {
    error_log("UserIsLoggedInValue before update: " . $_SESSION["UserIsLoggedIn"]);
    $_SESSION["UserIsLoggedIn"] = "true";
    error_log("UserIsLoggedInValue after update: " . $_SESSION["UserIsLoggedIn"]);

    error_log("Checking if prevpage is set");
    if (isset($_GET["prevpage"])) {
        global $runningOnLocalHost;
        if ($runningOnLocalHost) {
            $prevPage = "http://localhost:8888" . $_GET["prevpage"];
            error_log("Redirecting user to previous page: " . $prevPage);
            wp_redirect($prevPage);
        }else {
            wp_redirect("https://www.ehelseagder.no" . $_GET["prevPage"]);
        }
        error_log("User should now have been redirected. Exiting script...");
    }else {
        error_log("Attempting to redirect user to front page");
        wp_redirect("../../../");
        error_log("User should now have been redirected. Exiting script...");
    }
    exit;
}