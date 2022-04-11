<?php

include ("CookieTool.php");

add_action('wp', 'add_jquery');
add_action('wp', 'check_page_in_dev');

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
    if (pageIsInDevelopment() && !isset($_COOKIE['DevelopmentDeviceEnrolled'])) {
        ?>
        <img class = "pageBackground" src = "<?php echo wp_upload_dir()['baseurl'] . "/eHelseAgderPlus/background.png" ?>"/>
        <div class = "bigMessage">
            <img src = ""/>
            <h2>Under konstruksjon</h2>
            <p>
                eHelse Agder blir for tiden oppdatert. Nettsiden er derfor utilgjengelig for øyeblikket. Nettsiden er forventet ferdig innen juni 2022.
            </p>
            <p>
                Beklager ulempene dette medfører.
            </p>
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
        </style>
        <?php
        exit;
    }
}