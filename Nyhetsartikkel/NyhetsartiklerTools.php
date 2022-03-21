<?php

function getTilknyttetProsjektTekst($artikkelInfo) {
    $tilknyttetProsjekt = $artikkelInfo->tilknyttet_prosjekt;

    global $wpdb;
    $query = "SELECT * FROM " . getProsjekterDatabaseRef() . " WHERE id = " . $tilknyttetProsjekt;
    $projectInfo = $wpdb->get_results($query);

    return "Besøk gjerne <a href = 'www.google.com'>" . $projectInfo[0]->project_name . "</a> sin prosjektside for mer informasjon.";

}