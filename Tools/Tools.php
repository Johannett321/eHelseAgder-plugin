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
    if (array_key_exists('debug_mode', $config)) {
        return $config['debug_mode'];
    }else {
        return false;
    }
}

/**
 * Sjekker om running_on_localhost er på i config arrayet.
 * @return mixed
 */
function runningOnLocalHost() {
    global $config;
    return $config['running_on_localhost'];
}

/**
 * @return bool returnerer true dersom nettsiden fortsatt er under utvikling
 */
function pageIsInDevelopment() {
    return true;
}

/**
 * Tar brukeren endten til en visningside av prosjekt/nyhet eller til draften for dette.
 * @param $redirectAddress string adressen til siden inkludert articleID eller projectID.
 * @param $message string dersom en melding skal vises på toppen av siden når den laster inn.
 * @param $popupTitle string dersom en popup boks skal vises med en tekst.
 * @param $popupMessage string dersom en popup boks skal vises med en tekst.
 * @param $draft boolean om dette er en draft eller ikke.
 */
function redirectUserToPageOrPreview($redirectAddress, $message, $popupTitle, $popupMessage, $draft) {
    if ($message != null) {
        $redirectAddress .= "&message=" . $message;
    }

    if ($popupTitle != null) {
        $redirectAddress .= "&popupT=" . $popupTitle;
        $redirectAddress .= "&popupM=" . $popupMessage;
    }

    if ($draft) {
        $redirectAddress .= "&draft=true";
    }
    wp_redirect($redirectAddress);
    exit;
}

/**
 * Leser GET parametere for å finne ut om draft parameteren er true.
 * @return bool Returnerer true dersom man ser på en draft.
 */
function lookingAtDraft() {
    if (isset($_GET['draft']) && $_GET['draft'] == "true") {
        return true;
    }
    return false;
}