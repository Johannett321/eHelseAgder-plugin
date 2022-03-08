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
    $data = array("publisert" => 1, "project_name" => $_SESSION["pname"], "undertittel" => $_SESSION["psubtitle"], "ledernavn" => $_SESSION["pleadername"], "ledermail" => $_SESSION["pleaderemail"], "ledertlf" => $_SESSION["pleaderphone"], "prosjektstart" => $_SESSION["project_start"], "prosjektslutt" => $_SESSION["project_end"], "kostnadsramme" => $_SESSION["cost"], "project_text" => $_SESSION["psummary"]);
    $format = array("%d", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s");
    $projectID = 0;

    if (isset($_GET['editProsjektID'])) {
        $prosjektID = $_GET['editProsjektID'];
        $wpdb->update($formatted_table_name, $data, array("id" => $prosjektID), $format);

        $collapsibleTable = getCollapsiblesDatabaseRef();
        error_log("Attempting to delete from: " . $collapsibleTable . ", where prosjekt_id => " . intval($prosjektID));

        $wpdb->delete($collapsibleTable, array('prosjekt_id' => intval($prosjektID)), array("%d"));
        $projectID = intval($prosjektID);
    }else {
        $wpdb->insert($formatted_table_name, $data, $format);
        $projectJustAdded = $wpdb->get_results("SELECT * FROM $formatted_table_name WHERE id = (SELECT MAX(ID) FROM $formatted_table_name)");
        $projectID = $projectJustAdded[0]->id;
        error_log("Added project: " . $projectID, 0);
    }



    lagreCollapsibles($projectID);

    return "Lagret: " . $_SESSION["pname"] . " - " . $collapsibleIDS[0];
}