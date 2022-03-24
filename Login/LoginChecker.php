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
    error_log("A user has signed in successfully!");

    session_start();
    $_SESSION["UserIsLoggedIn"] = true;

    wp_redirect("../../../");
    exit;
}

function userIsLoggedIn() {
    return $_SESSION["UserIsLoggedIn"];
}