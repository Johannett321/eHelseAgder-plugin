<?php
add_action( 'rest_api_init', 'rest_add_slett_arrangement');

function rest_add_slett_arrangement() {
    register_rest_route( 'ehelseagderplugin/api', '/slett_arrangement', array(
        'methods' => 'GET',
        'callback' => 'slettArrangement',
    ));
}

function slettArrangement() {
    session_start();
    jsonRequiresLogin();
    $eventID = $_GET['eventID'];
    global $wpdb;
    $wpdb->delete(getArrangementerDatabaseRef(), array("id"=>$eventID), array("%d"));
    redirectUserToPageOrPreview("../../../arrangementer/?s=s", "Arrangementet ble slettet!", null, null, false);
}