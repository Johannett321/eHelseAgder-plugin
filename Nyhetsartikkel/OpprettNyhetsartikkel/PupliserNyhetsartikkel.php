<?php
add_action( 'rest_api_init', 'rest_add_nyhetsartikkel_routes');

function rest_add_nyhetsartikkel_routes() {
    register_rest_route( 'ehelseagderplugin/api', '/publiser_nyhetsartikkel', array(
        'methods' => 'GET',
        'callback' => 'publiserNyhetsartikkel',
    ));

    register_rest_route( 'ehelseagderplugin/api', '/lagre_utkast_nyhetsartikkel', array(
        'methods' => 'POST',
        'callback' => 'lagreNyhetsUtkast',
    ));
}

function lagreNyhetsUtkast() {
    session_start();
    jsonRequiresLogin();

    prepareNyhetsartiklerDraftsTable();

    $formatted_table_name = getDraftNyhetsartiklerDatabaseRef();
    
    $dagensDato = date("Y-m-d");

    global $wpdb;
    $data = array("tittel"=>$_POST["tittel"],
        "ingress"=>$_POST["ingress"],
        "tilknyttet_prosjekt"=>$_POST["assignedProjectChooser"],
        "innhold"=>$_POST["psummary"],
        "publisert"=>1);

    $format = array("%s", "%s", "%d", "%s", "%d");

    if (isset($_GET['editArticleID'])) {
        $articleID = $_GET['editArticleID'];
        $result = $wpdb->get_results("SELECT * FROM " . getNyhetsartiklerDatabaseRef() . " WHERE id = " . $articleID);
        $readCount = $result[0]->antall_lesere;

        $data += array("skrevet_av"=>$result[0]->skrevet_av,
            "rolle"=>$result[0]->rolle,
            "dato_skrevet"=>$result[0]->dato_skrevet,
            "endret_av"=>$_POST["endret_av"],
            "dato_endret"=>$dagensDato,
            "antall_lesere"=>$readCount,
            "id"=>$articleID);

        array_push($format, "%s", "%s", "%s", "%s", "%s", "%d", "%d");
    }else {
        $articleID = generateNewsArticleID();

        $data += array("skrevet_av"=>$_POST["skrevet_av"],
            "dato_skrevet"=>$dagensDato,
            "rolle"=>$_POST["rolle"],
            "id"=>$articleID);

        array_push($format,"%s", "%s", "%s", "%d");
    }

    $fileName = uploadImageAndGetName("bilde");
    if ($fileName != null) {
        $data += array("bilde"=>$fileName);
        array_push($format,"%s");
    }else {
        $data += array("bilde"=>$result[0]->bilde);
        array_push($format,"%s");
    }

    $wpdb->insert($formatted_table_name, $data, $format);
    $articleJustAdded = $wpdb->get_results("SELECT * FROM $formatted_table_name WHERE id = (SELECT MAX(ID) FROM $formatted_table_name)");
    $articleID = $articleJustAdded[0]->id;
    error_log("La til nyhetsartikkel med artikkelID: " . $articleID, 0);
    gotoViewArticle($articleID, "Velkommen til forh??ndsvisning!",
        "Her ser du hvordan nyhetssiden vil bli seende ut n??r du publiserer artikkelen. Hvis du er forn??yd og ??nsker ?? publisere, blar du ned p?? siden og klikker ??Publiser??. Om du vil endre p?? noe, klikker du ??Tilbake til redigering??.",
        "Dette er en forh??ndsvisning av nyhetsartikkelen. ??nsker du ?? gj??re endringer kan du g?? tilbake ?? redigere innholdet. Er du ferdig med ?? redigere, kan du publisere nyhetsartikkelen for ?? offentliggj??re den.",
        true);
}

function publiserNyhetsartikkel() {
    jsonRequiresLogin();
    $articleID = $_GET['articleID'];

    global $wpdb;
    $tittel = $wpdb->get_results("SELECT tittel FROM " . getDraftNyhetsartiklerDatabaseRef() . " WHERE id = " . $articleID)[0]->tittel;
    if ($wpdb->delete(getNyhetsartiklerDatabaseRef(), array('id'=>$articleID)) == false) {
        addEventToChangelog("En nyhetsartikkel ble opprettet", $tittel, "nyheter/vis-artikkel/?artikkelID=" . $articleID);
    }else {
        addEventToChangelog("Endring i nyhetsartikkel", $tittel, "nyheter/vis-artikkel/?artikkelID=" . $articleID);
    }
    $wpdb->query("INSERT INTO " . getNyhetsartiklerDatabaseRef() . " SELECT * FROM " . getDraftNyhetsartiklerDatabaseRef() . " WHERE id = " . $articleID);

    gotoViewArticle($articleID, null, null, "Artikkelen ble publisert!", false);
}

function gotoViewArticle($articleID, $popupTitle, $popupMessage, $message, $draft) {
    $redirectAddress = "../../../../../nyheter/vis-artikkel/?artikkelID=" . $articleID;
    redirectUserToPageOrPreview($redirectAddress,$message,$popupTitle,$popupMessage,$draft);
}