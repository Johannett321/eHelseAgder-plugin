<?php
add_action( 'rest_api_init', 'rest_add_slett_nyhetsartikkel');

function rest_add_slett_nyhetsartikkel() {
    register_rest_route( 'ehelseagderplugin/api', '/slett_nyhetsartikkel', array(
        'methods' => 'GET',
        'callback' => 'slettNyhetsartikkel',
    ));
}

function slettNyhetsartikkel() {
    $articleID = $_GET['articleID'];
    global $wpdb;
    $wpdb->delete(getNyhetsartiklerDatabaseRef(), array("id"=>$articleID), array("%d"));
    return "Slettet artikkel id: " . $articleID;
}