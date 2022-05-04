<?php

add_shortcode( 'sc_logg_ut_knapp', 'sc_logg_ut_knapp');
add_shortcode( 'sc_pabegynt_prosjekt', 'sc_pabegynt_prosjekt');
add_shortcode('sc_minside_prosjekter', 'sc_minside_prosjekter');
add_shortcode('sc_minside_arrangementer', 'sc_minside_arrangementer');
add_shortcode('sc_minside_nyhetsartikler', 'sc_minside_nyhetsartikler');
add_action( 'wp_ajax_action', 'ajax_hent_prosjektnavn' );
add_action( 'wp_ajax_nopriv_action', 'ajax_hent_prosjektnavn' );

securePageWithLogin('min-side');
thisPageRequiresCookies('min-side');

function sc_pabegynt_prosjekt() {
    if (areElementorBufferingObjects()) return;
    if (areWeEditingWithElementor()) {
        ?>
        <h6>Dersom brukeren har begynt på et prosjekt, vil det vises her</h6>
        <?php
        return;
    }
    $ajaxurl = admin_url('admin-ajax.php');
    //localStorage.getItem("prosjektID");
    ?>
    <div id="påbegyntLinje" >
        <a id = "pabegyntProsjektLink"><button id = "pabegyntProsjekt"></button></a>
        <button id = "pabegyntProsjektSlettKnapp">Slett utkast</button></div>
    <script type="text/javascript">
        const pabegyntProsjektLink = document.getElementById('pabegyntProsjektLink');
        const pabegyntProsjekt = document.getElementById('pabegyntProsjekt');
        const pabegyntProsjektSlettKnapp = document.getElementById('pabegyntProsjektSlettKnapp');

        if (localStorage.getItem("prosjektID") != null) {
            var request = $.ajax({
                url: ajaxurl,
                type: "POST",
                data: {action: "action", prosjektID : localStorage.getItem("prosjektID")},
                dataType: "html"
            });

            request.done(function(response) {
                if (response === "") {
                    pabegyntProsjekt.innerText = "Fortsett å redigere utkast";
                    pabegyntProsjektLink.href = "opprett-prosjekt/";
                }else {
                    pabegyntProsjekt.innerText = "Fortsett å redigere utkast for " + response + "";
                    pabegyntProsjektLink.href = "opprett-prosjekt/?editProsjektID=" + localStorage.getItem("prosjektID");
                }

                pabegyntProsjektSlettKnapp.onclick = function () {
                    if (confirm("Er du sikker på at du vil slette utkastet ditt for " + response + "?")) {
                        console.log("Clearer localstorage etter brukerens ønske");
                        localStorage.clear();
                        alert("Utkastet er nå slettet")
                        location.reload();
                    }
                }
            });
        }else {
            pabegyntProsjektLink.classList.add("hidden");
            pabegyntProsjekt.classList.add("hidden");
            pabegyntProsjektSlettKnapp.classList.add('hidden');
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

function sc_minside_prosjekter() {
    if (areElementorBufferingObjects()) return;
    global $wpdb;
    $prosjektInfo = $wpdb->get_results("SELECT project_name, id FROM " . getProsjekterDatabaseRef());
    if (sizeof($prosjektInfo) == 0) {
        ?>
        <center><h5>Fant ingen prosjekter</h5></center>
        <?php
        return;
    }
    ?>
    <table class = "minSideTB">
        <?php
        foreach ($prosjektInfo as $currentProsjekt) {
            ?>
            <tr>
                <td class="titleTB"><a href = "../prosjekter/prosjektside/?prosjektID=<?php echo $currentProsjekt->id ?>"><?php echo $currentProsjekt->project_name?></a></td>
                <td class="editButtonTB"><a href = "../opprett-prosjekt/?editProsjektID=<?php echo $currentProsjekt->id ?>">Rediger</a></td>
                <td class="deleteButtons" id="<?php echo $currentProsjekt->project_name ?>" data-tilhorer="<?php echo $currentProsjekt->id?>" data-type="prosjekt" style="cursor: pointer;">Slett</td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
}

function sc_minside_arrangementer() {
    if (areElementorBufferingObjects()) return;
    global $wpdb;
    $arrangementInfo = $wpdb->get_results("SELECT tittel, id FROM " . getArrangementerDatabaseRef() . " ORDER BY id DESC LIMIT 10");
    if (sizeof($arrangementInfo) == 0) {
        ?>
        <center><h5>Fant ingen arrangementer</h5></center>
        <?php
        return;
    }
    ?>
    <table class = "minSideTB">
        <?php
        foreach ($arrangementInfo as $currentArrangement) {
            ?>
            <tr>
                <td class="titleTB"><a href = "../vis-arrangement/?eventID=<?php echo $currentArrangement->id ?>"><?php echo $currentArrangement->tittel?></a></td>
                <td class="editButtonTB"><a href = "../opprett-arrangement/?editEventID=<?php echo $currentArrangement->id ?>">Rediger</a></td>
                <td class="deleteButtons" id="<?php echo $currentArrangement->tittel ?>" data-tilhorer="<?php echo $currentArrangement->id?>" data-type="arrangement" style="cursor: pointer;">Slett</td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
    makeDeleteButtonsFunctional();
}

function sc_minside_nyhetsartikler() {
    if (areElementorBufferingObjects()) return;
    global $wpdb;
    $artikkelInfo = $wpdb->get_results("SELECT tittel, id FROM " . getNyhetsartiklerDatabaseRef() . " ORDER BY dato_skrevet DESC LIMIT 10");
    if (sizeof($artikkelInfo) == 0) {
        ?>
        <center><h5>Fant ingen nyhetsartikler</h5></center>
        <?php
        return;
    }
    ?>
    <table class = "minSideTB">
        <?php
        foreach ($artikkelInfo as $currentArtikkel) {
            ?>
            <tr>
                <td class="titleTB"><a href = "../nyheter/vis-artikkel/?artikkelID=<?php echo $currentArtikkel->id ?>"><?php echo $currentArtikkel->tittel?></a></td>
                <td class="editButtonTB"><a href = "../opprett-nyhetsartikkel/?editArticleID=<?php echo $currentArtikkel->id ?>">Rediger</a></td>
                <td class="deleteButtons" id="<?php echo $currentArtikkel->tittel ?>" data-tilhorer="<?php echo $currentArtikkel->id?>" data-type="nyhetsartikkel" style="cursor: pointer;">Slett</td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
}

function makeDeleteButtonsFunctional() {
    ?>
    <script type="text/javascript">
        const deleteButtons = document.getElementsByClassName('deleteButtons');
        for (let i = 0; i < deleteButtons.length; i++) {
            deleteButtons[i].onclick = function () {
                if (confirm("Er du sikker på at du vil slette " + deleteButtons[i].id)) {
                    switch (deleteButtons[i].dataset.type) {
                        case "arrangement":
                            window.location.href = "../../../wp-json/ehelseagderplugin/api/slett_arrangement?eventID=" + deleteButtons[i].dataset.tilhorer;
                            break;
                        case "prosjekt":
                            window.location.href = "../../../wp-json/ehelseagderplugin/api/slett_prosjekt?projectID=" + deleteButtons[i].dataset.tilhorer;
                            break
                        case "nyhetsartikkel":
                            window.location.href = "../../../wp-json/ehelseagderplugin/api/slett_nyhetsartikkel?articleID=" + deleteButtons[i].dataset.tilhorer;
                            break
                    }
                }
            }
        }
    </script>
    <?php
}

function sc_logg_ut_knapp() {
    if (areElementorBufferingObjects()) return;
    if (userIsLoggedIn()) {
        ?>
        <center>
            <a href = "/wp-json/ehelseagderplugin/api/logg_ut">
                <button id="loggUtButton">
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
                text-decoration: underline;
                color: #fff;
        </style>
        <?php
    }
}