<?php

add_shortcode('sc_siste_arrangementer_stor_liste', 'sc_siste_arrangementer_stor_liste');

function sc_siste_arrangementer_stor_liste() {
    ?>
    <div class = "artikkelKortHolder">
        <?php
        $events = getLastEventsList(5);
        foreach ($events as $currentEvent) {
            createLargeListItem($currentEvent->tittel,
                $currentEvent->kort_besk,
                date("d-m-Y", strtotime($currentEvent->start_dato)),
                $currentEvent->sted, $currentEvent->bilde,
                "vis-arrangement/?eventID=" . $currentEvent->id);
        }
        ?>
    </div>
    <?php
}

function getLastEventsList($limit) {
    global $wpdb;
    //TODO: Få den til å laste inn alt som er i fremtiden limit 5 ASC.
    $query = "SELECT * FROM " . getArrangementerDatabaseRef() . " ORDER BY start_dato ASC LIMIT " . $limit;
    return $wpdb->get_results($query);
}