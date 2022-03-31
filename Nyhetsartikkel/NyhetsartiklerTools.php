<?php
add_shortcode('sc_opprett_nyhetsartikkel_knapp','sc_opprett_nyhetsartikkel_knapp');

function sc_opprett_nyhetsartikkel_knapp() {
    if (userIsLoggedIn()) {
        ?>
        <head>
            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        </head>
        <a href = "../../opprett-nyhetsartikkel"><button>Opprett nyhetsartikkel<span class = "material-icons">add</span></button></a>
        <?php
    }
}

function getTilknyttetProsjektTekst($artikkelInfo) {
    $tilknyttetProsjekt = $artikkelInfo->tilknyttet_prosjekt;

    global $wpdb;
    $query = "SELECT * FROM " . getProsjekterDatabaseRef() . " WHERE id = " . $tilknyttetProsjekt;
    $projectInfo = $wpdb->get_results($query);

    return "Besøk gjerne <a href = 'www.google.com'>" . $projectInfo[0]->project_name . "</a> sin prosjektside for mer informasjon.";

}

/**
 * Oppretter et lite HTML element med artikkelens tittel, ingress, bilde og når den ble publisert.
 * @param $article array Hele artikkelen.
 */
function createShortArticle($article) {
    ?>
    <a href = "<?php echo "vis-artikkel?artikkelID=" . $article->id; ?>">
        <div class = "artikkelKort">
            <div class="photoSmall">
                <img src = "<?php echo getPhotoUploadUrl() . $article->bilde ?>"/>
            </div>
            <div class="artikkelkorttekst">
                <h5><?php echo $article->tittel; ?></h5>
                <p><?php echo $article->ingress; ?></p>
                <div id="additInfo">Publisert: <?php echo getDisplayDateFormat($article->dato_skrevet); ?></div>
            </div>
        </div>
    </a>
    <?php
}

/**
 * Registrerer at enda en leser har lest en artikkel i databasen.
 * @param $prosjektID int hvilket prosjekt blir lest?
 */
function increaseArticleReadCount($prosjektID) {
    global $wpdb;
    $result = $wpdb->get_results("SELECT antall_lesere FROM " . getNyhetsartiklerDatabaseRef() . " WHERE id = " . $prosjektID);
    $antallLesere = $result[0]->antall_lesere;
    $antallLesere += 1;
    $wpdb->update(getNyhetsartiklerDatabaseRef(), array("antall_lesere"=>$antallLesere), array("id"=>$prosjektID));
}