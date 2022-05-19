<?php

add_action("wp_body_open", "check_cookies_not_important");
add_action("init", "check_cookies_very_important");

function check_cookies_very_important() {
    session_start();
    global $pagesRequireCookies;

    $pageTitle = $_SERVER["REQUEST_URI"];
    $pageTitle = strtolower($pageTitle);
    $pageTitle = substr($pageTitle, 1, strlen($pageTitle)-2);

    for ($i = 0; $i < sizeof($pagesRequireCookies); $i++) {
        if (strtolower($pagesRequireCookies[$i]) == $pageTitle) {
            if (!isset($_COOKIE['CookieAccepted'])) {
                error_log("ERROR: Cookies not enabled. Asking user to confirm cookies");
                addImportantCookieConfirmDialog();
            }
        }
    }
}

function check_cookies_not_important() {
    if (!isset($_COOKIE['CookieAccepted'])) {
        error_log("ERROR: Cookies not enabled. Asking user to confirm cookies");
        addCookieConfirmDialog();
    }
}

/**
 * Sørger for at en side ikke laster inn dersom man ikke har godkjent cookies. Viser også en stor popup boks på skjermen som må godkjennes dersom man ikke har cookies enabled.
 * @return void
 */
function addImportantCookieConfirmDialog() {
    ?>
    <div class = "cookiesRequired">
        <h2>Siden du forsøker å besøke krever cookies (informasjonskapsler)</h2>
        <p>
            Ved å trykke 'Godkjenn cookies', godkjenner du at vi kan lagre informasjonskapsler på din enhet for å forbedre din opplevelse av siden.
        </p>
        <button type="button" id = "rejectCookies">Tilbake</button>
        <button type="button" id = "acceptCookies">Godkjenn cookies</button>
    </div>

    <style>
        .cookiesRequired {
            font-family: 'Lato', sans-serif;

            position: fixed;
            left: 17%;
            bottom: 40%;
            padding: 40px 30px;

            width: 60%;
            background-color: #cbe6cf;

            border-radius: 20px;
            border: 1px solid lightgray;
            box-shadow: 5px 5px 10px grey;

            text-align: center;
        }
    </style>
    <script type="text/javascript">
        const acceptCookies = document.getElementById('acceptCookies');
        const rejectCookies = document.getElementById('rejectCookies');
        const cookieConfirmDialog = document.getElementById('cookieConfirmDialog');

        acceptCookies.onclick = function () {
            setCookie("CookieAccepted", "true", 365);

            location.reload();

            function setCookie(cname, cvalue, exdays) {
                const d = new Date();
                d.setTime(d.getTime() + (exdays*24*60*60*1000));
                let expires = "expires="+ d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }
        }

        rejectCookies.onclick = function () {
            history.back();
        }
    </script>
    <?php
    exit;
}

/**
 * Legger til en bar nederst på skjermen dersom man ikke har godkjent cookies, som ber en godkjenne cookies.
 * @return void
 */
function addCookieConfirmDialog() {
    ?>
    <div id="cookieConfirmDialog">
        <div id = "backgroundColor">

            <div id="cookieTekst">
                <h5>Vi bruker informasjonskapsler:</h5>
                <p>Ehelseagder.no bruker informsjonskapsler for å lagre data midlertidig lokalt på din datamaskin. Dette er kun relevant for personer som skal opprette innhold på nettsiden. Informasjonskapslene påvirker ikke lesere av nettsiden. Det benyttes ingen tredjeparts-informasjonskapsler, så din datta er trygg.</p>
                <br>
                <p>Ved å trykke "Jeg forstår" samtykker du til bruken av informasjonskapsler. Ønsker du ikke å samtykke kan du ignorere feltet. Vær obs på at brukeropplevelsen vil bli redusert.</p>
            </div>
        <button type="button" id = "acceptCookies">Jeg forstår</button>
        </div>
    </div>

    <style>
        #cookieConfirmDialog {
            z-index: 3;
            position: fixed;
            bottom: 20px;
            padding: 20px 30px;

            width: 80%;
            background-color: #d9ead4;

            left: 10%;

            border-radius: 20px;
            border: 1px solid lightgray;

            box-shadow: 5px 5px 10px grey;

        }

        #backgroundColor {
            width: 100%;
            height: 100%;
            z-index: -1;


        }

        #acceptCookies {
            position: absolute;
            background-color: #76b17f;
            border-radius: 8px;
            color: black;
            margin-top: 20px;
            bottom: 40px;
            right: 50px;

        }

        #acceptCookies:hover {
            background-color: #84C58ED4;
            transform: scale(1.05);
            box-shadow: 5px 5px 10px lightgray;
        }

        #cookieConfirmDialog p {
            font-size: 16px;
            text-align: left;
        }

        #cookieConfirmDialog h5 {
            font-weight: 700;
        }

        #cookieTekst {
            display: inline-block;
            width: 80%;
        }
        @media only screen and (max-width: 500px) {
            #cookieConfirmDialog {
                width: 98%;
                left: 1%;
                padding: 10px 10px;
                overflow: scroll;
            }
            #cookieTekst {
                width: 100%;
                display: block;
            }
            #cookieConfirmDialog h5 {
                margin: 10px 0;
            }
            #acceptCookies {
                position: unset;
                margin: 10px 0;
            }
        }


    </style>

    <script type="text/javascript">
        const acceptCookies = document.getElementById('acceptCookies');
        const cookieConfirmDialog = document.getElementById('cookieConfirmDialog');

        acceptCookies.onclick = function () {
            setCookie("CookieAccepted", "true", 365);
            cookieConfirmDialog.remove();

            function setCookie(cname, cvalue, exdays) {
                const d = new Date();
                d.setTime(d.getTime() + (exdays*24*60*60*1000));
                let expires = "expires="+ d.toUTCString();
                document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            }
        }
    </script>
    <?php
}

/**
 * Markerer at en side MÅ bruke cookies, og man får ikke bruke den uten cookies.
 * @param $pageTitle string navnet på siden som må ha cookies
 * @return void
 */
function thisPageRequiresCookies($pageTitle) {
    global $pagesRequireCookies;
    if ($pagesRequireCookies != null) {
        $pagesRequireCookies[sizeof($pagesRequireCookies)] = $pageTitle;
    }else {
        $pagesRequireCookies[0] = $pageTitle;
    }
}