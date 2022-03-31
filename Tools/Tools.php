<?php

global $config;
$config = parse_ini_file("config.ini");

/**
 * Formaterer YYYY-MM-DD stil til DD-MM-YYYY
 * @param $date string Datoen som skal formateres
 * @return false|string Datoen som blir returnert. False dersom den feiler.
 */
function getDisplayDateFormat($dateString) {
    $date = date_create($dateString);
    error_log("Forsøker å formatere: " . $dateString);
    return date_format($date, 'd-m-Y');
}

/**
 * Sjekker om debug mode er på i config arrayet.
 * @return mixed
 */
function debugModeIsOn() {
    global $config;
    return $config['debug_mode'];
}

function runningOnLocalHost() {
    global $config;
    return $config['running_on_localhost'];
}