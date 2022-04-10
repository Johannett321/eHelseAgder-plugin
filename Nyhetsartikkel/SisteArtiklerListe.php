<?php
add_shortcode( 'sc_siste_nyhetsartikler', 'sc_siste_nyhetsartikler');

function sc_siste_nyhetsartikler() {
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
        createShortArticle($currentNyhet);
    }
    ?>
    <?php
}