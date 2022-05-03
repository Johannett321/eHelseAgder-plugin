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
    return false;
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

/**
 * Sjekker om vi redigerer dokumentet med Elementor
 * @return bool Returnerer true dersom vi redigerer
 */
function areWeEditingWithElementor() {
    if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
        return true;
    }else {
        return false;
    }
}

/**
 * Sjekker om Elementor bufferer objektet. Kan brukes blant annet til å sørge for at ting ikke vises dobbelt opp.
 * @return mixed
 */
function areElementorBufferingObjects() {
    return \Elementor\Plugin::$instance->preview->is_preview_mode();
}

/**
 * @return bool Returnerer true dersom man besøker siden fra en mobiltelefon
 */
function areWeVisitingFromMobileDevice() {
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
        return true;
    }
    return false;
}