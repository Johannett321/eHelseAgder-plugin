<?php

include ("CookieTool.php");

add_action('wp', 'check_page_in_dev');
add_action('wp_body_open', 'add_jquery');
add_action('wp_body_open', 'add_ajaxurl');

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
 * Sjekker om siden fortsatt er under utvikling, og evt viser en melding over hele skjermen dersom den er det.
 */
function check_page_in_dev() {
    if (pageIsInDevelopment() && !userIsEnrolled()) {
        ?>
        <img class = "pageBackground" src = "<?php echo wp_upload_dir()['baseurl'] . "/eHelseAgderPlus/background.jpg" ?>"/>
        <div class = "bigMessage">
            <h2>Under konstruksjon</h2>
            <p>
                eHelse Agder blir for tiden oppdatert. Nettsiden er derfor utilgjengelig for øyeblikket. Nettsiden er forventet ferdig innen juni 2022.
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