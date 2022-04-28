<?php

add_shortcode('sc_kommende_arrangementer', 'sc_kommende_arrangementer');

function sc_kommende_arrangementer() {
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
    $dagensDato = date('Y-m-d');
    $query = "SELECT * FROM " . getArrangementerDatabaseRef() . " WHERE start_dato > '" . $dagensDato . "'  ORDER BY start_dato ASC LIMIT " . $limit;
    return $wpdb->get_results($query);
}