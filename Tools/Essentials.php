<?php

include ("CookieTool.php");

add_action('wp', 'check_page_in_dev');
add_action('wp_head', 'add_correct_meta');
add_action('wp_body_open', 'add_jquery');
add_action('wp_body_open', 'add_ajaxurl');
add_action('wp_body_open', 'add_single_field_creepy_character_monitor');

function add_correct_meta() {
    if (isset($_GET['artikkelID'])) {
        global $wpdb;
        $articleInfo = $wpdb->get_results("SELECT tittel, ingress, bilde, innhold FROM " . getNyhetsartiklerDatabaseRef() . " WHERE id = " . $_GET['artikkelID'])[0];
        $bilde = $articleInfo->bilde;
        if ($bilde == null) {

        }
        setMetas($articleInfo->tittel, $articleInfo->ingress, getPhotoUploadUrl() . $bilde, get_site_url() . "/nyheter/vis-artikkel/?artikkelID=" . $_GET['artikkelID']);
    }else {
        global $wp;
        $url =  home_url( $wp->request );
        setMetas("eHelse Agder", "Regional koordineringsgruppe e-helse og velferdsteknologi Agder", wp_upload_dir()['baseurl'] . "/ehelseagderplus/nettsidelogo.png", $url);
    }
}

function setMetas($title, $description, $image, $url) {
    ?>
    <meta property='og:title' content='<?php echo $title?>'/>
    <meta property='og:image' content='<?php echo $image?>'/>
    <meta property='og:description' content='<?php echo $description?>'/>
    <meta property='og:url' content='<?php echo $url?>'/>
    <meta property="og:type" content="article"/>
    <?php
}

/**
 * Legger til ajax på nettsiden.
 */
function add_ajaxurl() {
    echo '<script type="text/javascript">
           var ajaxurl = "' . admin_url('admin-ajax.php') . '";
         </script>';
}

/**
 * Legger til JQuery på siden
 */
function add_jquery() {
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <?php
}

/**
 * Legger til en JS funksjon som kan kalles på for felter som skal beskyttes fra "creepy characters";
 */
function add_single_field_creepy_character_monitor() {
    ?>
    <script type="text/javascript">
        function protectTextFieldFromCreepyCharacters(textField) {
            $(textField).on("input", function(){
                if (textField.value.includes(";")) {
                    alert("Du kan ikke bruke dette spesielle tegnet ';'. Det er reservert.");
                    textField.value = textField.value.replace(";","");
                }
                if (textField.value.includes("--!--")) {
                    alert("Du kan ikke bruke dette spesielle tegnet '--!--'. Det er reservert.");
                    textField.value = textField.value.replace("--!--","");
                }
                if (textField.value.includes("[")) {
                    alert("Du kan ikke bruke dette spesielle tegnet '['. Det er reservert.");
                    textField.value = textField.value.replace("[","");
                }
                if (textField.value.includes("]")) {
                    alert("Du kan ikke bruke dette spesielle tegnet ']'. Det er reservert.");
                    textField.value = textField.value.replace("]","");
                }
            });
        }
    </script>
    <?php
}

/**
 * Legger til en JS funksjon som kan kalles på for felter som skal beskyttes fra "creepy characters";
 */
function addCreepyCharactersMonitorToWholePage() {
    ?>
    <script type="text/javascript">
        const inputs = document.getElementsByTagName("input");
        for (let i = 0; i < inputs.length; i++) {
            $(inputs[i]).on("input", function(){
                if (inputs[i].value.includes(";")) {
                    alert("Du kan ikke bruke dette spesielle tegnet ';'. Det er reservert.");
                    inputs[i].value = inputs[i].value.replace(";","");
                }
                if (inputs[i].value.includes("--!--")) {
                    alert("Du kan ikke bruke dette spesielle tegnet '--!--'. Det er reservert.");
                    inputs[i].value = inputs[i].value.replace("--!--","");
                }
                if (inputs[i].value.includes("[")) {
                    alert("Du kan ikke bruke dette spesielle tegnet '['. Det er reservert.");
                    inputs[i].value = inputs[i].value.replace("[","");
                }
                if (inputs[i].value.includes("]")) {
                    alert("Du kan ikke bruke dette spesielle tegnet ']'. Det er reservert.");
                    inputs[i].value = inputs[i].value.replace("]","");
                }
            });
        }
    </script>
    <?php
}

/**
 * Sjekker om siden fortsatt er under utvikling, og evt viser en melding over hele skjermen dersom den er det.
 */
function check_page_in_dev() {
    if (pageIsInDevelopment() && !userIsEnrolled()) {
        ?>
        <img class = "pageBackground" src = "<?php echo wp_upload_dir()['baseurl'] . "/eHelseAgderPlus/background.jpg" ?>"/>
        <div class = "bigMessage">
            <h2>Vi er tilbake 23. mai!</h2>
            <p>
                eHelse Agder blir for tiden oppgradert. Nettsiden er derfor utilgjengelig for øyeblikket. Den nye nettsiden lanseres 23. mai med et helt nytt design og nye funksjoner! Det er bare å glede seg!
            </p>
            <p>
                Beklager ulempene dette medfører.
            </p>
            <p><b>Har du tilgang? Skriv passord her:</b></p>
            <input type = "text" placeholder="Passord" id = "passwordField"/>
            <button id = "unlockButton">Lås opp</button>
            <script type="text/javascript">
                document.getElementById('unlockButton').onclick = function () {
                    if (document.getElementById('passwordField').value === "<?php echo (date('d')*21)?>") {
                        setCookie("limitedEnrollment", Date.now()+1000*60*60*3, 3)
                        location.reload();
                    }else {
                        alert("Beklager! Tilgangen er ment for testbrukere. Du kan dessverre ikke se siden for øyeblikket")
                    }

                    function setCookie(cname, cvalue, exhours) {
                        const d = new Date();
                        d.setTime(d.getTime() + (exhours*60*60*1000));
                        let expires = "expires="+ d.toUTCString();
                        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
                    }
                }
            </script>
        </div>

        <style>
            h2 {
                font-size: 3rem;
                font-weight: 700;
                font-family: "Lato", sans-serif;
            }

            p {
                font-family: 'Lato', sans-serif;
                font-size: 1.3rem;
                font-weight: 400;
                line-height: 1.5;
            }

            .bigMessage {
                max-width: 500px;
                background-color: #D6EBCA;
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
                padding: 30px 30px;
                border-radius: 20px;
                box-shadow: #666666 2px 2px 20px;
            }

            .pageBackground {
                width: 100%;
                height: 100%;
                position: fixed;
                object-fit: cover;

                /* Add the blur effect */
                filter: blur(8px);
                -webkit-filter: blur(8px);
            }

            #unlockButton {

            }

            #passwordField {

            }
        </style>
        <?php
        exit;
    }
}

add_action('rest_api_init', 'add_pass_gen');

function add_pass_gen(){
    register_rest_route( 'ehelseagderplugin/api', '/generatepassword', array(
        'methods' => 'GET',
        'callback' => 'generate_password',
    ));
}

function generate_password() {
    echo date('d')*21;
    exit;
}