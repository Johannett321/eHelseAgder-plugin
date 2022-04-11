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

/**
 * Sjekker om running_on_localhost er på i config arrayet.
 * @return mixed
 */
function runningOnLocalHost() {
    global $config;
    return $config['running_on_localhost'];
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
 * Legger til eth HTML element som teller characters i et tekstfelt. Den viser brukeren hvor mange tegn som gjenstår
 * @param $textFieldID string id'en til html elementet du vil legge til en teller på.
 * @return void
 */
function addCharacterCounter($textFieldID) {
    ?>
    <span id ="<?php echo $textFieldID . "counter" ?>" class="inputFieldCounter">0/0</span>
    <script type="text/javascript">
        <?php echo $textFieldID . "()"?>

        function <?php echo $textFieldID?>() {
            const inputField = document.getElementById('<?php echo $textFieldID?>');
            const inputFieldCounter = document.getElementById('<?php echo $textFieldID . "counter"?>');
            const fieldMaxLength = inputField.maxLength;

            inputFieldCounter.innerText = inputField.value.length + "/" + fieldMaxLength;

            $(inputField).on("input", function(){
                inputFieldCounter.innerText = inputField.value.length + "/" + fieldMaxLength;
            });
        }
    </script>
    <style>
        .inputFieldCounter {
            position: sticky;
            float: right;
            margin-right: 5px;
            transform: translate(0, -170%);

            font-size: 15px;
            color: gray;
        }
    </style>
    <?php
}