<?php

add_action("wp", "check_cookies_not_important");
add_action("init", "check_cookies_very_important");

function check_cookies_very_important() {
    session_start();
    global $pagesRequireCookies;

    $pageTitle = $_SERVER["REQUEST_URI"];
    $pageTitle = strtolower($pageTitle);
    $pageTitle = substr($pageTitle, 1, strlen($pageTitle)-2);
    error_log("Sjekker om siden krever cookies: " . $pageTitle);

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

function addImportantCookieConfirmDialog() {
    ?>
    <div class = "cookiesRequired">
        <h2>Siden du forsøker å besøke krever cookies</h2>
        <p>
            Ved å trykke 'godkjenn og lukk', godkjenner du at vi kan lagre informasjonskapsler på din enhet for å forbedre din opplevelse av siden
        </p>
        <button type="button" id = "rejectCookies">Tilbake</button>
        <button type="button" id = "acceptCookies">Godkjenn cookies</button>
    </div>

    <style>
        .cookiesRequired {
            background-color: #7cc48c;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            padding: 30px 30px;
            border-radius: 20px;
            box-shadow: #666666 2px 2px 20px;
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

function addCookieConfirmDialog() {
    ?>
    <div id="cookieConfirmDialog">
        <div id = "backgroundColor"></div>
        <h5>Om cookies</h5>
        <p>
            Ved å trykke 'godkjenn og lukk', godkjenner du at vi kan lagre informasjonskapsler på din enhet for å forbedre din opplevelse av siden
        </p>
        <button type="button" id = "acceptCookies">Godkjenn og lukk</button>
    </div>

    <style>
        #cookieConfirmDialog {
            z-index: 2;
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 30px 0px;
        }

        #backgroundColor {
            position: absolute;
            width: inherit;
            height: 100%;
            z-index: -1;
            background-color: #7cc48c;
            opacity: 80%;
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

function thisPageRequiresCookies($pageTitle) {
    error_log("Adding " . $pageTitle . " to list of pages requiring cookies");
    global $pagesRequireCookies;
    if ($pagesRequireCookies != null) {
        $pagesRequireCookies[sizeof($pagesRequireCookies)] = $pageTitle;
    }else {
        $pagesRequireCookies[0] = $pageTitle;
    }
}