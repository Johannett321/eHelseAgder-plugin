<?php
add_action( 'rest_api_init', 'rest_add_publiser_nyhetsartikkel');

function rest_add_publiser_nyhetsartikkel() {
    register_rest_route( 'ehelseagderplugin/api', '/publiser_nyhetsartikkel', array(
        'methods' => 'POST',
        'callback' => 'publiserNyhetsartikkel',
    ));
}

function publiserNyhetsartikkel() {
    session_start();

    $formatted_table_name = getNyhetsartiklerDatabaseRef();

    global $wpdb;
    $data = array("tittel"=>$_POST["tittel"],"ingress"=>$_POST["ingress"],"skrevet_av"=>$_POST["skrevet_av"],"dato_skrevet"=>$_POST["dato_skrevet"],"innhold"=>$_POST["psummary"]);
    $format = array("%s", "%s", "%s", "%s", "%s");
    $articleID = 0;

    if (isset($_GET['editArticleID'])) {
        $articleID = $_GET['editArticleID'];
        $wpdb->update($formatted_table_name, $data, array("id" => $articleID), $format);
        error_log("Oppdaterte nyhetsartikkel med ID: " . $articleID);
        return "Oppdaterte nyhetsartikkel: " . $_POST["tittel"];
    }else {
        $wpdb->insert($formatted_table_name, $data, $format);
        $articleJustAdded = $wpdb->get_results("SELECT * FROM $formatted_table_name WHERE id = (SELECT MAX(ID) FROM $formatted_table_name)");
        $articleID = $articleJustAdded[0]->id;
        error_log("La til nyhetsartikkel med artikkelID: " . $articleID, 0);
        return "Publiserte nyhetsartikkel: " . $_POST["tittel"];
    }
}