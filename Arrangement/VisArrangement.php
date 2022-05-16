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
    if (areElementorBufferingObjects()) return;
    if (areWeEditingWithElementor()) {
        ?>
        <center><h5>Her vil arrangementet man er inne på vises</h5></center>
        <?php
        return;
    }
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

    <div class="edit">

        <?php
        if (userIsLoggedIn() && !lookingAtDraft()) {
            ?>
            <a href = "../../opprett-arrangement?editEventID=<?php echo $eventID ?>"><button class="editButton">Rediger arrangement<span class = "material-icons">edit</span></button></a>
            <?php
        }
        ?>

    </div>

    <div class = "artikkel" id="arrangement">

        <div class = "topPart">
            <?php
            if ($eventInfo[0]->bilde != null && $eventInfo[0]->bilde != "") {
                ?>
                <div class = "coverPhoto" id = "coverPhoto"><img src = "<?php echo getPhotoUploadUrl() . $bildeUrl ?>" id = "coverPhotoImg"></div>
                <?php
            }
            ?>

            <div class = "oppsummert" id = "oppsummert">
                <h4>Kort om arrangementet</h4>
                <div>
                    <h5>Starter:</h5><span><?php echo getNoneImportantDisplayDateFormat($eventInfo[0]->start_dato); if ($eventInfo[0]->start_klokkeslett != null) echo " kl " . $eventInfo[0]->start_klokkeslett?></span>
                </div>
                <div>
                    <h5>Slutter:</h5><span><?php echo getNoneImportantDisplayDateFormat($eventInfo[0]->slutt_dato); if ($eventInfo[0]->slutt_klokkeslett != null) echo " kl " . $eventInfo[0]->slutt_klokkeslett?></span>
                </div>
                <div>
                    <h5>Sted:</h5><span><?php echo $eventInfo[0]->sted?></span>
                </div>
                <div>
                    <h5>Arrangør:</h5><span><?php echo $eventInfo[0]->arrangor?></span>
                </div>
                <div>
                    <h5>Kontaktperson:</h5><br><i><?php echo $eventInfo[0]->kontaktperson?></i><br>
                    <i> <?php echo $eventInfo[0]->kontaktperson_mail?></i>
                </div>

                <a href = "<?php echo $eventInfo[0]->pamelding_link ?>" target="_blank"><button type="button" class = "button" id="signUpButton">Påmelding<i class="material-icons">arrow_forward</i></button></a>
            </div>
            <?php insertSyncCoverPhotoAndSummaryJS();?>
        </div>

        <div class = "arrInnhold">

            <h1 class = "nyhetTittel"><?php echo $eventInfo[0]->tittel; ?></h1>
            <span class = "ingress">– <?php echo $eventInfo[0]->kort_besk ?></span>

            <div class = "artikkelTekst" id = "artikkelTekst"><?php echo nl2br(stripcslashes($eventInfo[0]->innhold)); ?></div>
            <?php transformLinkInTextToClickableJS("artikkelTekst");?>

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
                    <a href = "<?php echo $eventInfo[0]->pamelding_link ?>" target="_blank"><button type="button" class = "button" id="signUpButton">Påmelding<i class="material-icons">
                                arrow_forward
                            </i></button></a>
                    <?php
                }
            }
            ?>
        </div>


    </div>
    <?php
    if (lookingAtDraft()) {
        ?>
        <br/>
        <div class = "buttons">
            <button type="button" id = "backButton">Tilbake</button>
            <button type="button" id = "publishButton">Publiser</button>
            <script type="text/javascript">
                const backButton = document.getElementById('backButton');
                const publishButton = document.getElementById('publishButton');

                backButton.onclick = function () {
                    window.history.go(-1)
                }

                publishButton.onclick = function () {
                    if (confirm("Er du sikker på at du vil publisere arrangementet?")) {
                        console.log("Clearer localstorage for å publisere arrangement");
                        localStorage.clear();

                        location.href = "../../../../wp-json/ehelseagderplugin/api/publiser_arrangement?eventID=<?php echo $_GET['eventID'] ?>";
                    }
                }
            </script>
        </div>
        <?php
    }
}