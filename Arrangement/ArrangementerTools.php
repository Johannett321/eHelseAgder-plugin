<?php
add_shortcode('sc_opprett_arrangement_knapp','sc_opprett_arrangement_knapp');

function sc_opprett_arrangement_knapp() {
    if (userIsLoggedIn()) {
        ?>
        <head>
            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        </head>
        <a href = "../../opprett-arrangement"><button>Opprett arrangement<span class = "material-icons">add</span></button></a>
        <?php
    }
}

/**
 * Oppretter et lite HTML element med artikkelens tittel, ingress, bilde og når den ble publisert.
 * @param $article array Hele artikkelen.
 */
function createShortEvent($article) {
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
 * Sletter draft tabellen som allerede eksisterer, og oppretter en ny draft tabell
 */
function prepareArrangementerDraftsTable() {
    global $wpdb;
    $wpdb->query("DROP TABLE " . getDraftArrangementerDatabaseRef());
    createArrangementerTable(getDraftArrangementerDatabaseRef());
}

/**
 * Genererer en unik nyhetsid som er lik antall rader i nyhetsartikkel databasen.
 * @return int Den unike iden
 */
function generateEventID() {
    global $wpdb;
    $result = $wpdb->get_results("SELECT id FROM " . getArrangementerDatabaseRef());
    return sizeof($result)+1;
}

/**
 * Sjekker databasen om arrangement eksisterer.
 * @param $eventID int Arrangement som skal sjekkes
 * @return bool Returnerer true dersom den eksisterer.
 */
function eventExists($eventID) {
    global $wpdb;
    $result = $wpdb->get_results("SELECT id FROM " . getArrangementerDatabaseRef() . " WHERE id = " . $eventID);
    return sizeof($result) > 0;
}