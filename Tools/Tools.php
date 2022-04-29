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
 * Returnerer en dato med tid for stringen med dato som blir gitt som parameter
 * @param $dateString
 * @return string
 */
function getDisplayTimestampFormat($dateString) {
    error_log("Forsøker å formatere: " . $dateString);
    $date = date_create($dateString);
    return $date->format('d-m-Y H:i');
}

/**
 * Returnerer 'i dag', 'i går', eller datoen som blir gitt som parameter
 * @param $dateString
 * @return false|string
 */
function getNoneImportantDisplayTimestampFormat($dateString) {
    $current = strtotime(date("Y-m-d"));
    $dateTime = strtotime($dateString);

    $datediff = $dateTime - $current;
    $difference = floor($datediff/(60*60*24));
    if($difference==0) {
        return 'I dag kl ' . date_create($dateString)->format("H:i");
    }else if($difference == +1) {
        return 'I morgen kl ' . date_create($dateString)->format("H:i");
    }else if($difference == +2) {
        return 'I overmorgen kl ' . date_create($dateString)->format("H:i");;
    }else if($difference == -1) {
        return 'I går kl ' . date_create($dateString)->format("H:i");
    }else {
        return getDisplayTimestampFormat($dateString);
    }
}

/**
 * Returnerer 'i dag', 'i går', eller datoen som blir gitt som parameter UTEN klokkeslett
 * @param $dateString
 * @return false|string
 */
function getNoneImportantDisplayDateFormat($dateString) {
    $current = strtotime(date("Y-m-d"));
    $dateTime = strtotime($dateString);

    $datediff = $dateTime - $current;
    $difference = floor($datediff/(60*60*24));
    if($difference==0) {
        return 'I dag';
    }else if($difference == -1) {
        return 'I går';
    }else if($difference == +1) {
        return 'I morgen';
    }else if($difference == +2) {
        return 'I overmorgen';
    }else {
        return getDisplayDateFormat($dateString);
    }
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
 * Sjekker om brukeren skal ha tilgang til siden mens den er under utvikling.
 * @return bool
 */
function userIsEnrolled() {
    if (isset($_COOKIE['DevelopmentDeviceEnrolled'])) {
        return true;
    }
    if (isset($_COOKIE['limitedEnrollment'])) {
        $milliseconds = round(microtime(true) * 1000);
        if ($milliseconds < floatval($_COOKIE['limitedEnrollment'])) {
            return true;
        }
    }
    return false;
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

/**
 * Legger til kode som gjør at collapsibles blir klikkbare og animerte
 */
function makeCollapsiblesWork() {
    ?>
    <script type = "text/javascript">
        var coll = document.getElementsByClassName("collapsible");

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                const content = this.nextElementSibling;
                if (content.style.display === "block") {
                    $(content).animate({
                        height: "0px"
                    }, 200, function() {
                        content.style.display = "none";
                    })
                } else {
                    $(content).height(0);
                    var curHeight = $(content).height();
                    $(content).css('height', 'auto');
                    var autoHeight = $(content).height() + 40;
                    $(content).height(curHeight);

                    content.style.display = "block";
                    $(content).animate({
                        height: autoHeight
                    }, 200);
                }
            });
        }
    </script>
    <?php
}

function areWeEditingWithElementor() {
    if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
        error_log("Vi redigerer!");
        return true;
    }else {
        error_log("Vi redigerer ikke!");
        return false;
    }
}

function areElementorBufferingObjects() {
    return \Elementor\Plugin::$instance->preview->is_preview_mode();
}