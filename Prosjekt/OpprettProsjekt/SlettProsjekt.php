<?php
add_action( 'rest_api_init', 'rest_add_slett_prosjekt');

function rest_add_slett_prosjekt() {
    register_rest_route( 'ehelseagderplugin/api', '/slett_prosjekt', array(
        'methods' => 'GET',
        'callback' => 'slettProsjekt',
    ));
}

function slettProsjekt() {
    session_start();
    jsonRequiresLogin();
    $projectID = $_GET['projectID'];
    global $wpdb;
    $wpdb->delete(getProsjekterDatabaseRef(), array("id"=>$projectID), array("%d"));
    $wpdb->delete(getCollapsiblesDatabaseRef(), array("prosjekt_id"=>$projectID), array("%d"));
    redirectUserToPageOrPreview("../../../min-side?s=s", "Prosjektet ble slettet!", null, null, false);
}