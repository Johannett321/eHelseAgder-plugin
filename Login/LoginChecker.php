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

    error_log("Attempting to redirect user to front page");
    wp_redirect("../../../");
    error_log("User should now have been redirected. Exiting script...");
    exit;
}

function userIsLoggedIn() {
    $userIsLoggedInExists = isset($_SESSION["UserIsLoggedIn"]);
    $userIsLoggedInValue = $_SESSION["UserIsLoggedIn"];

    if (!$userIsLoggedInExists) {
        error_log("Notable: 'UserIsLoggedIn' eksisterer ikke, og funskjonen 'userIsLoggedIn()' returnerer derfor false");
        return false;
    }

    if ($userIsLoggedInValue == "true") {
        error_log("Riktig: 'UserIsLoggedIn' == 'true', og funskjonen 'userIsLoggedIn()' returnerer derfor true");
        return true;
    }else {
        error_log("Notable: 'UserIsLoggedIn' != 'true', og funskjonen 'userIsLoggedIn()' returnerer derfor false");
        return false;
    }
}