<?php

add_action( 'rest_api_init', 'add_publiser_prosjekt_receiver');

function add_publiser_prosjekt_receiver(){
    register_rest_route( 'ehelseagderplugin/api', '/publiser_prosjekt', array(
        'methods' => 'POST',
        'callback' => 'publiserProsjekt',
    ));
}

function publiserProsjekt() {
    session_start();
    jsonRequiresLogin();

    $formatted_table_name = getProsjekterDatabaseRef();

    global $wpdb;
    $data = array("publisert" => 1,
        "project_name" => $_SESSION["pname"],
        "undertittel" => $_SESSION["psubtitle"],
        "ledernavn" => $_SESSION["pleadername"],
        "ledermail" => $_SESSION["pleaderemail"],
        "ledertlf" => $_SESSION["pleaderphone"],
        "prosjektstart" => $_SESSION["project_start"],
        "prosjektslutt" => $_SESSION["project_end"],
        "prosjekteierkommuner" => $_SESSION["prosjekteierkommuner"],
        "samarbeidspartnere" => $_SESSION["samarbeidspartnere"],
        "project_text" => $_SESSION["psummary"]);

    $format = array("%d",
        "%s",
        "%s",
        "%s",
        "%s",
        "%s",
        "%s",
        "%s",
        "%s",
        "%s",
        "%s");

    if (isset($_SESSION["bilde"]) && $_SESSION["bilde"] != null  && $_SESSION["bilde"] != "") {
        error_log("Bilde lagt til i prosjekt: " . $_SESSION["bilde"]);
        $data += array("bilde"=>$_SESSION["bilde"]);
        array_push($format,"%s");
    }else {
        error_log("Fant ikke bilde: " . $_SESSION["bilde"]);
    }

    if (isset($_GET['editProsjektID'])) {
        $prosjektID = $_GET['editProsjektID'];
        $wpdb->update($formatted_table_name, $data, array("id" => $prosjektID), $format);

        $collapsibleTable = getCollapsiblesDatabaseRef();
        error_log("Attempting to delete from: " . $collapsibleTable . ", where prosjekt_id => " . intval($prosjektID));
        
        $wpdb->delete($collapsibleTable, array('prosjekt_id' => intval($prosjektID)), array("%d"));
        $projectID = intval($prosjektID);
    }else {
        print_r($data);
        print_r($format);
        $wpdb->insert($formatted_table_name, $data, $format);
        $projectJustAdded = $wpdb->get_results("SELECT * FROM $formatted_table_name WHERE id = (SELECT MAX(ID) FROM $formatted_table_name)");
        $projectID = $projectJustAdded[0]->id;
        error_log("Added project: " . $projectID, 0);
    }

    lagreCollapsibles($projectID);

    wp_redirect("../../../../../../prosjektside?prosjektID=" . $projectID);
    exit;
}

function lagreCollapsibles($projectID) {
    //cvleverandorer
    //cvprosjektteam

    error_log("--- Collapsibles ---", 0);
    lagreCustomCollapsibles($projectID);
    lagreLeverandører($projectID);
    lagreProsjektTeam($projectID);
    lagreMerInfoOmProsjekt($projectID);
    lagreMilepaeler($projectID);
}

function lagreSimpleTekstBoks($projectID, $name, $type) {
    global $wpdb;

    if (isset($_POST[$name])) {
        $formatted_table_name = getCollapsiblesDatabaseRef();
        $wpdb->insert($formatted_table_name, array("prosjekt_id" => $projectID, "innhold" => $_POST[$name], "collapsible_type" => $type), array("%d", "%s", "%d"));
        error_log("Added " . $name . " collapsible");
    }else {
        error_log($name . " er ikke skrevet om");
    }
}

function lagreMerInfoOmProsjekt($projectID) {
    lagreSimpleTekstBoks($projectID, "cmerinfotekst", 4);
}

function lagreLeverandører($projectID) {
    lagreSimpleTekstBoks($projectID, "cleverandørtekst", 2);
}

function lagreMilepaeler($projectID) {
    if (!isset($_POST["cmtittel1"])) {
        return;
    }

    global $wpdb;

    $milepaeler = "";

    $shouldContinue = true;
    $counter = 0;

    while($shouldContinue) {
        $counter += 1;
        if (isset($_POST["cmtittel" . $counter])) {
            if ($milepaeler != "") {
                $milepaeler = $milepaeler . ";";
            }

            $milepaeler = $milepaeler . $_POST["cmtittel" . $counter] . "," .
            $_POST["milepaeldropdown" . $counter] . "," .
            $_POST["cmcontact" . $counter] . "," .
            $_POST["cmdate" . $counter];
            error_log("La til milepæl: " . $_POST["cmtittel" . $counter], 0);
        }else {
            error_log("Ingen flere milepæler er skrevet om. Returning...", 0);
            $shouldContinue = false;
        }
    }

    $formatted_table_name = getCollapsiblesDatabaseRef();
    $wpdb->insert($formatted_table_name, array("prosjekt_id" => $projectID, "innhold" => $milepaeler, "collapsible_type" => 5), array("%d", "%s", "%s", "%d"));
    error_log("Added custom collapsible: " . $_POST["cvcustomtitle" . $counter], 0);
}

function lagreProsjektTeam($projectID) {
    if (!isset($_POST["cvtmfulltnavn1"])) {
        return;
    }

    global $wpdb;

    $shouldContinue = true;
    $counter = 0;

    $projectTeamMembers = "";

    while($shouldContinue) {
        $counter += 1;
        if (isset($_POST["cvtmfulltnavn" . $counter])) {
            if ($projectTeamMembers != "") {
                $projectTeamMembers = $projectTeamMembers . ";";
            }

            $projectTeamMembers = $projectTeamMembers . $_POST["cvtmfulltnavn" . $counter] . "," . 
            $_POST["cvtmrolle" . $counter] . "," .
            $_POST["cvtmepost" . $counter] . "," .
            $_POST["cvtmmobil" . $counter];

            error_log("Added project team member: " . $_POST["cvtmfulltnavn" . $counter], 0);
        }else {
            error_log("No more people in project team. Returning...", 0);
            $shouldContinue = false;
        }
    }

    $formatted_table_name = getCollapsiblesDatabaseRef();
    $wpdb->insert($formatted_table_name, array("prosjekt_id" => $projectID, "innhold" => $projectTeamMembers, "collapsible_type" => 3), array("%d", "%s", "%d"));
}

function lagreCustomCollapsibles($projectID) {
    global $wpdb;

    $shouldContinue = true;
    $counter = 0;

    while($shouldContinue) {
        $counter += 1;
        if (isset($_POST["cvcustomtitle" . $counter])) {
            $formatted_table_name = getCollapsiblesDatabaseRef();
            $wpdb->insert($formatted_table_name, array("prosjekt_id" => $projectID, "egendefinert_navn" => $_POST["cvcustomtitle" . $counter], "innhold" => $_POST["cvcustomdesc" . $counter], "collapsible_type" => 1), array("%d", "%s", "%s", "%d"));
            error_log("Added custom collapsible: " . $_POST["cvcustomtitle" . $counter], 0);
        }else {
            error_log("No more items, returning...", 0);
            $shouldContinue = false;
        }
    }
}