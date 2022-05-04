<?php

add_action( 'rest_api_init', 'rest_add_prosjekter_routes');

function rest_add_prosjekter_routes(){
    register_rest_route( 'ehelseagderplugin/api', '/publiser_prosjekt', array(
        'methods' => 'GET',
        'callback' => 'publiserProsjekt',
    ));

    register_rest_route( 'ehelseagderplugin/api', '/lagre_utkast_prosjekt', array(
        'methods' => 'POST',
        'callback' => 'lagreProsjektUtkast',
    ));
}

function publiserProsjekt() {
    jsonRequiresLogin();
    $projectID = $_GET['prosjektID'];

    global $wpdb;
    $wpdb->delete(getCollapsiblesDatabaseRef(), array('prosjekt_id' => $projectID), array("%d"));
    $tittel = $wpdb->get_results("SELECT project_name FROM " . getDraftProsjekterDatabaseRef() . " WHERE id = " . $projectID)[0]->project_name;
    if ($wpdb->delete(getProsjekterDatabaseRef(), array('id'=>$projectID)) == false) {
        addEventToChangelog("Et nytt prosjekt ble opprettet", $tittel, "prosjekter/prosjektside/?prosjektID=" . $projectID);
    }else {
        addEventToChangelog("Endring i prosjekt", $tittel, "prosjekter/prosjektside/?prosjektID=" . $projectID);
    }

    $wpdb->query("INSERT INTO " . getProsjekterDatabaseRef() . " SELECT * FROM " . getDraftProsjekterDatabaseRef() . " WHERE id = " . $projectID);
    $wpdb->query("INSERT INTO " . getCollapsiblesDatabaseRef() . " SELECT * FROM " . getDraftCollapsibleDatabaseRef() . " WHERE prosjekt_id = " . $projectID);

    gotoViewProject($projectID, null, null, "Prosjektet ble publisert!", false);
}

function lagreProsjektUtkast() {
    jsonRequiresLogin();

    prepareProsjekterDraftsTable();
    prepareCollapsibleDraftsTable();

    $formatted_table_name = getDraftProsjekterDatabaseRef();

    global $wpdb;
    $data = array("publisert" => 1,
        "project_name" => $_SESSION["pname"],
        "undertittel" => $_SESSION["psubtitle"],
        "ledernavn" => $_SESSION["pleadername"],
        "ledermail" => $_SESSION["pleaderemail"],
        "ledertlf" => $_SESSION["pleaderphone"],
        "prosjektstart" => $_SESSION["project_start"],
        "prosjektslutt" => $_SESSION["project_end"],
        "prosjektstatus" => $_SESSION["prosjektstatus"],
        "prosjekteierkommuner" => $_SESSION["prosjekteierkommuner"],
        "samarbeidspartnere" => $_SESSION["samarbeidspartnere"],
        "sokerkommuner" => $_SESSION["sokerkommuner"],
        "project_text" => $_SESSION["psummary"],
        "revision"=>$_SESSION["correctLocalRevision"]);

    if ($data["prosjektstart"] == "0") {
        $data["prosjektstart"] = "2022";
    }
    if ($data["prosjektslutt"] == "0") {
        $data["prosjektslutt"] = "2022";
    }

    $format = array("%d",
        "%s",
        "%s",
        "%s",
        "%s",
        "%s",
        "%d",
        "%s",
        "%d",
        "%s",
        "%s",
        "%s",
        "%s",
        "%d");

    if (isset($_SESSION["bilde"]) && $_SESSION["bilde"] != null  && $_SESSION["bilde"] != "") {
        error_log("Bilde lagt til i prosjekt: " . $_SESSION["bilde"]);
        $data += array("bilde"=>$_SESSION["bilde"]);
        array_push($format,"%s");
    }else {
        error_log("Fant ikke noe info om bilde. Bruker gammelt bilde dersom prosjektet blir redigert");
        if (isset($_GET['editProsjektID'])) {
            $projectID = $_GET['editProsjektID'];
            $result = $wpdb->get_results("SELECT * FROM " . getProsjekterDatabaseRef() . " WHERE id = " . $projectID);

            $data += array("bilde"=>$result[0]->bilde);
            array_push($format,"%s");
        }
    }

    if (isset($_GET['editProsjektID'])) {
        $prosjektID = $_GET['editProsjektID'];

        $data += array("id"=>$prosjektID);
        array_push($format, "%d");
    }else {
        $prosjektID = generateProjectID();

        $data += array("id"=>$prosjektID);
        array_push($format, "%d");
    }

    $wpdb->insert($formatted_table_name, $data, $format);
    error_log("Added project: " . $prosjektID, 0);

    lagreCollapsibles($prosjektID);

    gotoViewProject($prosjektID, "Velkommen til forhåndsvisning!", "Her ser du hvordan prosjektsiden vil bli seende ut når du publiserer prosjektet.
     Hvis du er fornøyd og ønsker å publisere, blar du ned på siden og klikker «Publiser».
     Om du vil endre på noe, klikker du «Tilbake».",
        "Dette er en forhåndsvisning av prosjektet. Ønsker du å gjøre endringer kan du gå tilbake å redigere innholdet. Er du ferdig med å redigere kan du publisere prosjektet for å offentliggjøre det.", true);
}

function lagreCollapsibles($projectID) {
    error_log("--- Collapsibles ---", 0);
    lagreCustomCollapsibles($projectID);
    lagreLeverandører($projectID);
    lagreProsjektTeam($projectID);
    lagreMerInfoOmProsjekt($projectID);
    lagreMilepaeler($projectID);
    lagreNedlastbareDokumenter($projectID);
}

function lagreSimpleTekstBoks($projectID, $name, $type) {
    global $wpdb;

    if (isset($_POST[$name])) {
        $formatted_table_name = getDraftCollapsibleDatabaseRef();
        $wpdb->insert($formatted_table_name,
            array("prosjekt_id" => $projectID,
                "innhold" => $_POST[$name],
                "collapsible_type" => $type,
                "id"=>generateRandomString(15)),
            array("%d", "%s", "%d", "%s"));
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

            $milepaeler = $milepaeler . $_POST["cmtittel" . $counter] . "--!--" .
            $_POST["milepaeldropdown" . $counter] . "--!--" .
            $_POST["cmcontact" . $counter] . "--!--" .
            $_POST["cmdate" . $counter];
            error_log("La til milepæl: " . $_POST["cmtittel" . $counter], 0);
        }else {
            error_log("Ingen flere milepæler er skrevet om. Returning...", 0);
            $shouldContinue = false;
        }
    }

    $formatted_table_name = getDraftCollapsibleDatabaseRef();
    $wpdb->insert($formatted_table_name,
        array("prosjekt_id" => $projectID,
            "innhold" => $milepaeler,
            "collapsible_type" => 5,
            "id" => generateRandomString(15)),
        array("%d", "%s", "%d", "%s"));
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

            $projectTeamMembers = $projectTeamMembers . $_POST["cvtmfulltnavn" . $counter] . "--!--" .
            $_POST["cvtmrolle" . $counter] . "--!--" .
            $_POST["cvtmepost" . $counter] . "--!--" .
            $_POST["cvtmmobil" . $counter];

            error_log("Added project team member: " . $_POST["cvtmfulltnavn" . $counter], 0);
        }else {
            error_log("No more people in project team. Returning...", 0);
            $shouldContinue = false;
        }
    }

    $formatted_table_name = getDraftCollapsibleDatabaseRef();
    $wpdb->insert($formatted_table_name,
        array("prosjekt_id" => $projectID,
            "innhold" => $projectTeamMembers,
            "collapsible_type" => 3,
            "id" => generateRandomString(15)),
        array("%d", "%s", "%d", "%s"));
}

function lagreCustomCollapsibles($projectID) {
    global $wpdb;

    $shouldContinue = true;
    $counter = 0;

    $attemptsLeft = 20;
    $foundAnyCustomCollapsibles = false;

    while($shouldContinue) {
        $counter += 1;
        if (isset($_POST["cvcustomtitle" . $counter])) {
            $foundAnyCustomCollapsibles = true;
            $formatted_table_name = getDraftCollapsibleDatabaseRef();
            $wpdb->insert($formatted_table_name,
                array("prosjekt_id" => $projectID,
                    "egendefinert_navn" => $_POST["cvcustomtitle" . $counter],
                    "innhold" => $_POST["cvcustomdesc" . $counter],
                    "collapsible_type" => 1,
                    "id" => generateRandomString(15)),
                array("%d", "%s", "%s", "%d", "%s"));
            error_log("Added custom collapsible: " . $_POST["cvcustomtitle" . $counter], 0);
        }else {
            $attemptsLeft -= 1;
            if ($attemptsLeft <= 0) {
                $shouldContinue = false;
            }
        }
    }
    if (!$foundAnyCustomCollapsibles) {
        error_log("Fant ingen custom collapsibles");
    }
}

function lagreNedlastbareDokumenter($projectID){
    if (!isset($_POST["fil1"]) && !array_key_exists("fil1", $_FILES)) {
        error_log("Ingen filer er lastet opp");
        return;
    }

    $filesUploaded = "";
    $folderName = generateRandomString();
    createFileUploadFolder($folderName);
    for ($i = 1; $i <= 20; $i++) {
        $fileName = uploadFileAndGetName($folderName, "fil" . $i);
        if ($fileName != null) {
            if ($filesUploaded != "") {
                $filesUploaded .= ";";
            }
            $filesUploaded .= $fileName;
        }
    }

    if ($filesUploaded !== "") {
        global $wpdb;
        $formatted_table_name = getDraftCollapsibleDatabaseRef();
        $wpdb->insert($formatted_table_name,
            array("prosjekt_id" => $projectID,
                "innhold" =>$filesUploaded,
                "collapsible_type" => 6,
                "id" => generateRandomString(15)),
            array("%d", "%s", "%d", "%s"));
        error_log("Added nedlastbare dokumenter collapsible!", 0);
    }
}

function gotoViewProject($projectID, $popupTitle, $popupMessage, $message, $draft) {
    $redirectAddress = "../../../../../prosjekter/prosjektside/?prosjektID=" . $projectID;
    redirectUserToPageOrPreview($redirectAddress, $message, $popupTitle, $popupMessage, $draft);
}