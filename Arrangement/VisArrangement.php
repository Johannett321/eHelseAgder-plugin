<?php
require "ArrangementerTools.php";

add_shortcode( 'sc_vis_arrangement', 'sc_vis_arrangement');

function getEvent($eventID) {
    $database = getArrangementerDatabaseRef();
    if (lookingAtDraft()) {
        $database = getDraftArrangementerDatabaseRef();
    }

    global $wpdb;
    $query = "SELECT * FROM " . $database . " WHERE id = " . $eventID;
    error_log("Sending query: " . $query,0);
    return $wpdb->get_results($query);
}

function sc_vis_arrangement() {
    if (!isset($_GET["eventID"])) {
        showErrorMessage("Denne siden ble ikke lastet inn riktig");
        return;
    }
    $eventID = $_GET["eventID"];
    $eventInfo = getEvent($eventID);
    $bildeUrl =  $eventInfo[0]->bilde;

    if ($eventInfo == null) {
        showErrorMessage("Dette arrangementet eksisterer ikke lenger!");
        return;
    }

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
            <a href = "../../opprett-arrangement?editEventID=<?php echo $eventID ?>"><button>Rediger arrangement<span class = "material-icons">edit</span></button></a>
            <?php
        }
        ?>
        <h2 class = "nyhetTittel"><?php echo $eventInfo[0]->tittel; ?></h2>
        <span class = "ingress">– <?php echo $eventInfo[0]->kort_besk ?></span>

        <div class = "topPart">
            <?php
            if ($eventInfo[0]->bilde != null && $eventInfo[0]->bilde != "") {
                ?>
                <div class = "coverPhoto"><img src = "<?php echo getPhotoUploadUrl() . $bildeUrl ?>"></div>
                <?php
            }
            ?>
            <div class = "oppsummert">
                <h4>Kort om arrangementet</h4>
                <div>
                    <h5>Starter:</h5><span><?php echo $eventInfo[0]->start_dato?></span>
                </div>
                <div>
                    <h5>Slutter:</h5><span><?php echo $eventInfo[0]->slutt_dato?></span>
                </div>
                <div>
                    <h5>Arrangør:</h5><span><?php echo $eventInfo[0]->arrangor?></span>
                </div>
                <div>
                    <h5>Kontaktperson:</h5><span><?php echo $eventInfo[0]->kontaktperson?></span>
                    <span>Epost: <?php echo $eventInfo[0]->kontaktperson_mail?></span>
                </div>
            </div>
        </div>

        <div class = "artikkelTekst"><?php echo nl2br($eventInfo[0]->innhold); ?></div>

        <?php
        $vedlegg = $eventInfo[0]->vedlegg;
        if ($vedlegg != null && $vedlegg != "") {
            ?>
            <h5>Nedlastbart innhold</h5>
            <?php
            $filer = decodeFileUploadList($eventInfo[0]->vedlegg);
            for ($i = 0; $i < sizeof($filer); $i++) {
                ?>
                <div><a href="<?php echo getFilesUploadUrl() . $filer[$i] ?>" download><?php echo explode("/", $filer[$i])[1]; ?></a></div>
                <?php
            }
        }
        ?>

        <hr class="divider">
        <?php
        if (!lookingAtDraft()) {
            implementAllSMShareButtons();
            if ($eventInfo[0]->pamelding_link != null && $eventInfo[0]->pamelding_link != "") {
                ?>
                <a href = "<?php echo $eventInfo[0]->pamelding_link ?>" target="_blank"><button type="button" class = "button">Påmelding</button></a>
                <?php
            }
        }
        ?>
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
        <button type="button" id = "backButton">Tilbake</button>
        <button type="button" id = "publishButton">Publiser</button>
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

                    location.href = "../../../../wp-json/ehelseagderplugin/api/publiser_arrangement?eventID=<?php echo $_GET['eventID'] ?>";
                }
            }
        </script>
        <?php
    }
}