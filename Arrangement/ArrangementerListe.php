<?php

add_shortcode('sc_siste_arrangementer_stor_liste', 'sc_siste_arrangementer_stor_liste');

function sc_siste_arrangementer_stor_liste() {
    $events = getLastEventsList(5);
    foreach ($events as $currentEvent) {
        createLargeListItem($currentEvent->tittel,
            $currentEvent->kort_besk,
            date("d-m-Y", strtotime($currentEvent->start_dato)),
            $currentEvent->sted, $currentEvent->bilde,
            "vis-arrangement/?eventID=" . $currentEvent->id);
    }
    ?>
    <a href = "arrangementarkiv/"><button type="button" class="button">Arrangementarkiv</button></a>
    <?php
}

function getLastEventsList($limit) {
    global $wpdb;
    $query = "SELECT * FROM " . getArrangementerDatabaseRef() . " LIMIT " . $limit;
    return $wpdb->get_results($query);
}