<?php

/**
 * Returnerer tittelen på tallet som symboliserer hvilken status prosjektet har.
 * @param $prosjektStatusNumber int tallet som forteller status på prosjektet
 * @return string returnerer tittelen for tallet som symboliserer statusen på prosjektet. Returnerer ingenting dersom tallet ikke har noen tittel
 */
function getProsjektStatusAsText($prosjektStatusNumber) {
    switch ($prosjektStatusNumber) {
        case 1:
            return "Ikke startet";
        case 2:
            return "Påbegynt";
        case 3:
            return "I drift";
        case 4:
            return "Avsluttet";
        case 5:
            return "Kansellert";
    }
    return "";
}