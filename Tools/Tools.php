<?php

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