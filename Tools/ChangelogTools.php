<?php

function addEventToChangelog($title, $description, $href) {
    $dagensDato = date("Y-m-d");
    global $wpdb;
    $data = array("tittel" => $title,
        "beskrivelse"=>$description,
        "href"=>$href,
        "dato"=>$dagensDato);
    $format = array("%s", "%s", "%s", "%s");
    $wpdb->insert(getChangelogDatabaseRef(), $data, $format);
}