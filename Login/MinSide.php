<?php

add_shortcode( 'sc_logg_ut_knapp', 'sc_logg_ut_knapp');
add_shortcode( 'sc_pabegynt_prosjekt', 'sc_pabegynt_prosjekt');
add_action( 'wp_ajax_action', 'ajax_hent_prosjektnavn' );
add_action( 'wp_ajax_nopriv_action', 'ajax_hent_prosjektnavn' );

securePageWithLogin('min-side');
thisPageRequiresCookies('min-side');

function sc_pabegynt_prosjekt() {
    $ajaxurl = admin_url('admin-ajax.php');
    //localStorage.getItem("prosjektID");
    ?>
    <a id = "pabegyntProsjektLink"><h5 id = "pabegyntProsjekt"></h5></a>
    <script type="text/javascript">
        const pabegyntProsjektLink = document.getElementById('pabegyntProsjektLink');
        const pabegyntProsjekt = document.getElementById('pabegyntProsjekt');

        if (localStorage.getItem("prosjektID") != null) {
            var request = $.ajax({
                url: ajaxurl,
                type: "POST",
                data: {action: "action", prosjektID : localStorage.getItem("prosjektID")},
                dataType: "html"
            });

            request.done(function(response) {
                pabegyntProsjekt.innerText = "Det ser ut som du har et påbegynt prosjekt! Du ble aldri ferdig å redigere " + response + "! Trykk her for å fortsette";
                pabegyntProsjektLink.href = "opprett-prosjekt/?editProsjektID=" + localStorage.getItem("prosjektID");
            });
        }else {
            pabegyntProsjektLink.classList.add("hidden");
            pabegyntProsjekt.classList.add("hidden");
        }
    </script>
    <?php
}

function ajax_hent_prosjektnavn() {
    $prosjektID = $_POST['prosjektID'];

    global $wpdb;
    $prosjekt = $wpdb->get_results("SELECT project_name FROM " . getProsjekterDatabaseRef() . " WHERE id = " . $prosjektID);

    echo $prosjekt[0]->project_name;
    wp_die();
}

function sc_logg_ut_knapp() {
    if (userIsLoggedIn()) {
        ?>
        <center>
            <a href = "/wp-json/ehelseagderplugin/api/logg_ut">
                <button>
                    Logg ut
                </button>
            </a>
        </center>
        <style>
            .button {
                background: white;
                color: black;
                border-top-left-radius: 12px;
                border-top-right-radius: 12px;
                border-style: solid;
                border-width: 1px 1px 0px 1px;
                border-color: #84c58e;
                width: 130px;
                font-family: 'Lato' sans-serif;
                font-weight: 400;
                font-size: 14px;
                text-transform: uppercase;
                padding-top: 1.3em;
                text-align: center;
            }
            .button:hover {
                background:#7cc48c;
                font-weight: 700;
                color: #fff;
        </style>
        <?php
    }
}