<?php
add_shortcode( 'sc_siste_nyhetsartikler', 'sc_siste_nyhetsartikler');

function sc_siste_nyhetsartikler() {
    error_log("Trying to get news");
    loadSisteNyhetsartikler();
}

function getLastNyheterList() {
    global $wpdb;
    $query = "SELECT * FROM " . getNyhetsartiklerDatabaseRef() . " LIMIT 4";
    return $wpdb->get_results($query);
}

function loadSisteNyhetsartikler() {
    $nyheter = getLastNyheterList();
    foreach ($nyheter as $currentNyhet) {
        ?>
        <a href = <?php echo "vis-artikkel?artikkelID=" . $currentNyhet->id; ?>>
            <div class = "artikkelKort">
                <div class="photoSmall">
                    <!-- photo placeholder -->
                </div>
                <div class="artikkelkorttekst">
                    <h5><?php echo $currentNyhet->tittel; ?></h5>
                    <p><?php echo $currentNyhet->ingress; ?></p>
                    <div id="additInfo">Publisert: <?php echo $currentNyhet->dato_skrevet; ?></div>
                </div>
            </div>
        </a>
        <?php
    }
    ?>
    <?php
}