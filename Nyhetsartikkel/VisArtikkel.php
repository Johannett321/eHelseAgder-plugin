<?php
include ('SisteArtiklerListe.php');
require "NyhetsartiklerTools.php";

add_shortcode( 'sc_vis_artikkel', 'sc_vis_artikkel');

function getArtikkel($artikkelID) {
    error_log("Trying to get projects",0);

    $database = getNyhetsartiklerDatabaseRef();
    if (lookingAtDraft()) {
        $database = getDraftNyhetsartiklerDatabaseRef();
    }

    global $wpdb;
    $query = "SELECT * FROM " . $database . " WHERE id = " . $artikkelID;
    error_log("Sending query: " . $query,0);
    return $wpdb->get_results($query);
}

function sc_vis_artikkel() {
    if (!isset($_GET["artikkelID"])) {
        showErrorMessage("Denne siden ble ikke lastet inn riktig");
        return;
    }
    $artikkelID = $_GET["artikkelID"];
    $artikkelInfo = getArtikkel($artikkelID);
    $bildeUrl =  $artikkelInfo[0]->bilde;

    if (isset($_GET['message'])) {
        showCompleteMessage($_GET['message']);
    }
    if (isset($_GET['popupT'])) {
        createPopupBox($_GET['popupT'], $_GET['popupM']);
    }

    ?>
    <div class = "artikkel">
        <?php
        if (userIsLoggedIn() && !lookingAtDraft()) {
            ?>
            <head>
                <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
            </head>
            <a href = "../../opprett-nyhetsartikkel?editArticleID=<?php echo $artikkelID ?>"><button class="editButton">Rediger nyhetsartikkel<span class = "material-icons">edit</span></button></a>
            <?php
        }
        ?>
        <h2 class = "nyhetTittel"><?php echo $artikkelInfo[0]->tittel; ?></h2>
        <span class = "ingress">– <?php echo $artikkelInfo[0]->ingress ?></span>
        <?php
        if ($artikkelInfo[0]->bilde != null && $artikkelInfo[0]->bilde != "") {
            ?>
            <div class = "coverPhoto"><img src = "<?php echo getPhotoUploadUrl() . $bildeUrl ?>"></div>
            <?php
        }
        ?>
        <div class = "artikkelTekst"><?php echo nl2br($artikkelInfo[0]->innhold); ?></div>
        <div class = "tilknyttetProsjektTekst"><?php echo getTilknyttetProsjektTekst($artikkelInfo[0])?></div>
        <hr class="divider">
        <div class="infoBunn">
            <div id = "kildeinfo">Publisert <?php echo getDisplayDateFormat($artikkelInfo[0]->dato_skrevet)?>, av <?php echo $artikkelInfo[0]->skrevet_av ?> (<?php echo $artikkelInfo[0]->rolle ?>)</div>
            <?php
            $endretAv = $artikkelInfo[0]->endret_av;
            if ($endretAv != null && $endretAv != "") {
                ?>
                <div id = "endretInfo">Endret <?php echo getDisplayDateFormat($artikkelInfo[0]->dato_endret)?>, av <?php echo $artikkelInfo[0]->endret_av ?></div>
                <?php
            }
            if (!lookingAtDraft()) {
                implementFacebookShareButton();
            }
            ?>
        </div>
        <style>
            .coverPhoto {
                float: right;
                background-color: gray;
                width: 250px;
                height: 150px;
            }
        </style>
    </div>
    <?php
    if (lookingAtDraft()) {
        ?>
        <br/>
        <div class = "buttons">
            <button type="button" id = "backButton">Tilbake</button>
            <button type="button" id = "publishButton">Publiser</button>
        </div>
        <script type="text/javascript">
            const backButton = document.getElementById('backButton');
            const publishButton = document.getElementById('publishButton');

            backButton.onclick = function () {
                window.history.go(-1)
            }

            publishButton.onclick = function () {
                if (confirm("Er du sikker på at du vil publisere nyhetsartikkelen?")) {
                    console.log("Clearer localstorage for å publisere prosjekt");
                    localStorage.clear();

                    location.href = "../../../../wp-json/ehelseagderplugin/api/publiser_nyhetsartikkel?articleID=<?php echo $_GET['artikkelID'] ?>";
                }
            }
        </script>
        <?php
    }else {
        increaseArticleReadCount(intval($artikkelID));
    }
}