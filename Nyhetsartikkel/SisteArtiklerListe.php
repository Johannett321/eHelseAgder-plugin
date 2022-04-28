<?php
add_shortcode( 'sc_siste_nyhetsartikler', 'sc_siste_nyhetsartikler');

function sc_siste_nyhetsartikler() {
    loadSisteNyhetsartikler();
}

function getLastNyheterList() {
    global $wpdb;
    $query = "SELECT * FROM " . getNyhetsartiklerDatabaseRef() . " ORDER BY dato_skrevet DESC LIMIT 4";
    return $wpdb->get_results($query);
}

function loadSisteNyhetsartikler() {
    if (isset($_GET['message'])) {
        showCompleteMessage($_GET['message']);
    }

    $nyheter = getLastNyheterList();
    ?>
    <div class = "artikkelKortHolder">
        <?php
        foreach ($nyheter as $currentNyhet) {
            createShortArticle($currentNyhet);
        }
        ?>
    </div>
    <?php
}