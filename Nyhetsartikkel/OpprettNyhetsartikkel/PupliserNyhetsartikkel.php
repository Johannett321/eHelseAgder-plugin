<?php
add_action( 'rest_api_init', 'rest_add_publiser_nyhetsartikkel');

function rest_add_publiser_nyhetsartikkel() {
    register_rest_route( 'ehelseagderplugin/api', '/publiser_nyhetsartikkel', array(
        'methods' => 'POST',
        'callback' => 'publiserNyhetsartikkel',
    ));
}

function publiserNyhetsartikkel() {
    jsonRequiresLogin();
    session_start();

    $formatted_table_name = getNyhetsartiklerDatabaseRef();
    
    $dagensDato = date("d.m.Y");


    global $wpdb;
    $data = array("tittel"=>$_POST["tittel"],
        "ingress"=>$_POST["ingress"],
        "tilknyttet_prosjekt"=>$_POST["assignedProjectChooser"],
        "innhold"=>$_POST["psummary"]);

    $format = array("%s", "%s", "%d", "%s");

    if (isset($_GET['editArticleID'])) {
        $data += array("endret_av"=>$_POST["endret_av"], "dato_endret"=>$dagensDato);
        $format += array("%s", "%s");
    }else {
        $data += array("skrevet_av"=>$_POST["skrevet_av"], "dato_skrevet"=>$dagensDato, "rolle"=>$_POST["rolle"]);
        $format += array("%s", "%s", "%s");
    }

    $fileName = uploadFileAndGetName("bilde");
    if ($fileName != null) {
        $data += array("bilde"=>$fileName);
        array_push($format,"%s");
    }

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