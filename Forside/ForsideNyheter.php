<?php

add_shortcode( 'sc_forside_nyheter', 'sc_forside_nyheter');

function sc_forside_nyheter() {
    if (areElementorBufferingObjects()) return;
    loadForsideNyheter();
}

function loadForsideNyheter() {
    if (areWeEditingWithElementor()) {
        ?>
        <center><h5>Her vil siste nyheter vises</h5></center>
        <?php
        return;
    }
    global $wpdb;
    $nyheter = $wpdb->get_results("SELECT * FROM " . getNyhetsartiklerDatabaseRef() . " ORDER BY dato_skrevet DESC LIMIT 3");
    ?>
    <div class = "artikkelKortHolder">
        <?php
        foreach ($nyheter as $currentNyhet) {
            createLargeListItem($currentNyhet->tittel, $currentNyhet->ingress, "Publisert: " . getNoneImportantDisplayDateFormat($currentNyhet->dato_skrevet), null, $currentNyhet->bilde, "");
        }
        ?>
    </div>
    <?php
}