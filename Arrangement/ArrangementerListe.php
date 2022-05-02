<?php

add_shortcode('sc_kommende_arrangementer', 'sc_kommende_arrangementer');

function sc_kommende_arrangementer() {
    if (areElementorBufferingObjects()) return;
    ?>
    <div class = "artikkelKortHolder">
        <?php
        $events = getLastEventsList(5);
        if (sizeof($events) == 0) {
            ?>
            <center><h5>Fant ingen arrangementer</h5></center>
            <?php
            return;
        }
        foreach ($events as $currentEvent) {
            $visningsDato = getNoneImportantDisplayDateFormat($currentEvent->start_dato) . " kl " . $currentEvent->start_klokkeslett;

            $startDato = strtotime($currentEvent->start_dato);
            $sluttDato = strtotime($currentEvent->slutt_dato);

            $datediff = $sluttDato - $startDato;
            $difference = floor($datediff/(60*60*24));

            if ($difference > 0) {
                $visningsDato = "Fra " .
                    getNoneImportantDisplayDateFormat($currentEvent->start_dato) .
                    " kl " .
                    $currentEvent->start_klokkeslett .
                    " til " .
                    getNoneImportantDisplayDateFormat($currentEvent->slutt_dato);
            }

            createLargeListItem($currentEvent->tittel,
                $currentEvent->kort_besk,
                $visningsDato,
                $currentEvent->sted, $currentEvent->bilde,
                "vis-arrangement/?eventID=" . $currentEvent->id);
        }
        ?>
    </div>
    <?php
}

function getLastEventsList($limit) {
    global $wpdb;
    $dagensDato = date('Y-m-d');
    $query = "SELECT * FROM " . getArrangementerDatabaseRef() . " WHERE start_dato >= '" . $dagensDato . "'  ORDER BY start_dato ASC LIMIT " . $limit;
    return $wpdb->get_results($query);
}