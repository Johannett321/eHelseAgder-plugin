<?php
add_action( 'rest_api_init', 'rest_add_arrangement_routes');

function rest_add_arrangement_routes() {
    register_rest_route( 'ehelseagderplugin/api', '/publiser_arrangement', array(
        'methods' => 'GET',
        'callback' => 'publiserArrangement',
    ));

    register_rest_route( 'ehelseagderplugin/api', '/lagre_utkast_arrangement', array(
        'methods' => 'POST',
        'callback' => 'lagreArrangementUtkast',
    ));
}

function lagreArrangementUtkast() {
    session_start();
    jsonRequiresLogin();

    prepareArrangementerDraftsTable();

    $formatted_table_name = getDraftArrangementerDatabaseRef();

    global $wpdb;
    $data = array("tittel"=>$_POST["tittel"],
        "kort_besk"=>$_POST["kort_besk"],
        "start_dato"=>$_POST["startdato"],
        "start_klokkeslett"=>$_POST["start_klokkeslett"],
        "slutt_dato"=>$_POST["sluttdato"],
        "slutt_klokkeslett"=>$_POST["slutt_klokkeslett"],
        "sted"=>$_POST['sted'],
        "arrangor"=>$_POST['arrangor'],
        "kontaktperson"=>$_POST['kontaktperson'],
        "kontaktperson_mail"=>$_POST['kontaktmail'],
        "innhold"=>$_POST["psummary"],
        "publisert"=>1);

    $format = array("%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%d");

    if (isset($_POST['pamelding'])) {
        $data += array("pamelding_link"=>$_POST['pamelding']);
        array_push($format, "%s");
    }

    if (isset($_GET['editEventID'])) {
        $eventID = $_GET['editEventID'];
        $result = $wpdb->get_results("SELECT * FROM " . getArrangementerDatabaseRef() . " WHERE id = " . $eventID);

        $data += array("id"=>$eventID);
        array_push($format, "%d");
    }else {
        $eventID = generateEventID();
        $data += array("id"=>$eventID);
        array_push($format,"%d");
    }


    $coverPhotoName = uploadImageAndGetName("bilde");
    if ($coverPhotoName != null) {
        $data += array("bilde"=>$coverPhotoName);
        array_push($format,"%s");
    }else {
        $data += array("bilde"=>$result[0]->bilde);
        array_push($format,"%s");
    }

    $filesUploaded = "";
    $folderName = generateRandomString();
    createFileUploadFolder($folderName);
    for ($i = 1; $i < 6; $i++) {
        $fileName = uploadFileAndGetName($folderName, "fil" . $i);
        if ($fileName != null) {
            if ($filesUploaded != "") {
                $filesUploaded .= ";";
            }
            $filesUploaded .= $fileName;
        }
    }

    $data += array("vedlegg"=>$filesUploaded);
    array_push($format,"%s");


    $wpdb->insert($formatted_table_name, $data, $format);
    gotoViewEvent($eventID, "Velkommen til forhåndsvisning!", "Her ser du hvordan arrangementsiden vil bli seende ut når du publiserer arrangementet. Hvis du er fornøyd og ønsker å publisere, blar du ned på siden og klikker «Publiser». Om du vil endre på noe, blar du ned og klikker «Tilbake».", "Dette er bare en forhåndsvisning", true);
}

function publiserArrangement() {
    jsonRequiresLogin();
    $eventID = $_GET['eventID'];

    global $wpdb;
    $tittel = $wpdb->get_results("SELECT tittel FROM " . getDraftArrangementerDatabaseRef() . " WHERE id = " . $eventID)[0]->tittel;
    if ($wpdb->delete(getArrangementerDatabaseRef(), array('id'=>$eventID)) == false) {
        addEventToChangelog("Nytt arrangement ble opprettet", $tittel, "vis-arrangement/?eventID=" . $eventID);
    }else {
        addEventToChangelog("Endring i arrangement", $tittel, "vis-arrangement/?eventID=" . $eventID);
    }
    $wpdb->query("INSERT INTO " . getArrangementerDatabaseRef() . " SELECT * FROM " . getDraftArrangementerDatabaseRef() . " WHERE id = " . $eventID);

    gotoViewEvent($eventID, null, null, "Arrangementet ble publisert!", false);
}

function gotoViewEvent($eventID, $popupTitle, $popupMessage, $message, $draft) {
    $redirectAddress = "../../../../../arrangementer/vis-arrangement/?eventID=" . $eventID;
    redirectUserToPageOrPreview($redirectAddress,$message,$popupTitle,$popupMessage,$draft);
}