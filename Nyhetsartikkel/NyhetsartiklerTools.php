<?php
add_shortcode('sc_opprett_nyhetsartikkel_knapp','sc_opprett_nyhetsartikkel_knapp');

function sc_opprett_nyhetsartikkel_knapp() {
    if (areElementorBufferingObjects()) return;
    if (userIsLoggedIn()) {
        ?>
        <a href = "../../opprett-nyhetsartikkel"><button>Opprett nyhetsartikkel<span class = "material-icons">add</span></button></a>
        <?php
    }
}

function getTilknyttetProsjektTekst($artikkelInfo) {
    $tilknyttetProsjekt = $artikkelInfo->tilknyttet_prosjekt;

    global $wpdb;
    $query = "SELECT * FROM " . getProsjekterDatabaseRef() . " WHERE id = " . $tilknyttetProsjekt;
    $projectInfo = $wpdb->get_results($query);

    if (sizeof($projectInfo) > 0) {
        //TODO Få linken til å fungere
        return "Besøk gjerne <a href = '../../../../prosjekter/prosjektside/?prosjektID=" . $tilknyttetProsjekt . "'>" . $projectInfo[0]->project_name . "</a> sin prosjektside for mer informasjon.";
    }else {
        return "";
    }
}

/**
 * Oppretter et lite HTML element med artikkelens tittel, ingress, bilde og når den ble publisert.
 * @param $article array Hele artikkelen.
 * @deprecated Use createLargeListItem() instead
 */
function createShortArticle($article) {
    ?>
    <a href = "<?php echo "../../../nyheter/vis-artikkel?artikkelID=" . $article->id; ?>">
        <div class = "artikkelKort">
            <?php if ($article->bilde != null) {
                ?>
                <div class="photoSmall">
                    <img src = "<?php echo getPhotoUploadUrl() . $article->bilde ?>"/>
                </div>
                <?php
            }
            ?>
            <div class="artikkelkorttekst<?php if ($article->bilde == null) echo " nophoto"?>">
                <h5><?php echo $article->tittel; ?></h5>
                <p><?php echo $article->ingress; ?></p>
                <div id="additInfo">Publisert: <?php echo getNoneImportantDisplayDateFormat($article->dato_skrevet); ?></div>
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

/**
 * Sletter draft tabellen som allerede eksisterer, og oppretter en ny draft tabell
 */
function prepareNyhetsartiklerDraftsTable() {
    global $wpdb;
    $wpdb->query("DROP TABLE " . getDraftNyhetsartiklerDatabaseRef());
    createNyhetsArtiklerTable(getDraftNyhetsartiklerDatabaseRef());
}

/**
 * Genererer en unik nyhetsid som er lik antall rader i nyhetsartikkel databasen.
 * @return int Den unike iden
 */
function generateNewsArticleID() {
    global $wpdb;
    $result = $wpdb->get_results("SELECT id FROM " . getNyhetsartiklerDatabaseRef() . " ORDER BY id DESC LIMIT 1");
    return $result[0]->id + 1;
}

/**
 * Sjekker databasen om artikkelen eksisterer.
 * @param $articleID int Artikkeliden som skal sjekkes
 * @return bool Returnerer true dersom den eksisterer.
 */
function articleExists($articleID) {
    global $wpdb;
    $result = $wpdb->get_results("SELECT id FROM " . getNyhetsartiklerDatabaseRef() . " WHERE id = " . $articleID);
    return sizeof($result) > 0;
}