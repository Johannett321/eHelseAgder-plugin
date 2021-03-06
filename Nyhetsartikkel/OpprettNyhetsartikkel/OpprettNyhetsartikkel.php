<?php
add_shortcode( 'sc_opprett_nyhetsartikkel', 'sc_opprett_nyhetsartikkel');

require "PupliserNyhetsartikkel.php";
require "OpprettNyhetsartikkelTools.php";
include "SlettNyhetsartikkel.php";

securePageWithLogin('opprett-nyhetsartikkel');
thisPageRequiresCookies('opprett-nyhetsartikkel');

function sc_opprett_nyhetsartikkel() {
    if (areElementorBufferingObjects()) return;
    if (areWeVisitingFromMobileDevice()) {
        showErrorMessage("Du kan ikke opprette et prosjekt fra din mobil. Vennligst benytt en datamaskin");
        return;
    }
    error_log("Redigerer nå opprett nyhetsartikkel");
    $loadedNyhetsartikkel = getEditingNewsArticle();

    if (isset($_GET['editArticleID'])) {
        $postURL = "../../../../wp-json/ehelseagderplugin/api/lagre_utkast_nyhetsartikkel?editArticleID=" . $_GET['editArticleID'];
    }else {
        $postURL = "../../../../wp-json/ehelseagderplugin/api/lagre_utkast_nyhetsartikkel";
    }
    ?>

    <?php
    if ($loadedNyhetsartikkel != null) {
        ?>
            <div class="slettKnapp">
                <button id ="deleteArticle">Slett nyhetsartikkel<i class="material-icons">close</i></button>
                <script type="text/javascript">
                    const deleteArticleButton = document.getElementById('deleteArticle');
                    const deleteArticleLink = "../../../wp-json/ehelseagderplugin/api/slett_nyhetsartikkel?articleID=<?php echo $_GET['editArticleID']?>";

                    deleteArticleButton.onclick = function () {
                        if (confirm("Er du sikker på at du vil slette '<?php echo $loadedNyhetsartikkel->tittel?>'?")) {
                            window.location.href = deleteArticleLink;
                        }
                    }
                </script>
            </div>
        <?php
    }
    ?>
    <form action = "<?php echo $postURL?>" method = "post" id = "minform" enctype="multipart/form-data">
        <div class = "innhold">
            <h3 class = "mainTitle">Opprett nyhetsartikkel</h3>
            <!-- OPPLASTING AV BILDE -->
            <h4>Velg forsidebilde</h4>
            <div class="uploadPhoto" id = "uploadPhotoButton">
                <div class = "lastOppBildeKnapp">
                    <h5>Last opp bilde</h5>
                    <i class="material-icons">upload</i>
                </div>

                <img id="output" src = "<?php if ($loadedNyhetsartikkel->bilde != null) echo getPhotoUploadUrl() . $loadedNyhetsartikkel->bilde ?>"/>
                <input class = "hidden" type="file" name = "bilde" accept="image/*" onchange="loadFile(event)" id = "actualUploadButton">

                <script>
                    const loadFile = function(event) {
                        const output = document.getElementById('output');
                        output.src = URL.createObjectURL(event.target.files[0]);
                        output.onload = function() {
                            URL.revokeObjectURL(output.src) // free memory
                        }
                    };

                    const uploadPhotoButton = document.getElementById('uploadPhotoButton');

                    uploadPhotoButton.onclick = function () {
                        document.getElementById('actualUploadButton').click();
                    }
                </script>
            </div>
            <label for="tittel" class = "labelForInput">Tittel*</label>
            <input type="text" id="tittel" name="tittel" placeholder="Eks.: Vi har signert kontrakt!" class = "small_input" maxlength="55" value = "<?php echo stripcslashes($loadedNyhetsartikkel->tittel)?>"><?php addCharacterCounter("tittel");?>

            <label for="ingress" class = "labelForInput">Ingress*</label>
            <input type="text" id="ingress" name="ingress" placeholder="Eks.: Etter mange måneder med venting, har endelig kontrakten med Min Bedrift AS blitt signert." class = "small_input" maxlength="200" value = "<?php echo stripcslashes($loadedNyhetsartikkel->ingress)?>"><?php addCharacterCounter("ingress");?>

            <div class = "sammendragContainer">
                <label for = "psummary" class = "labelForInput">Innhold*</label><?php addInfoBox("innholdInfo", "Her skrives selve nyhetsinnlegget. Hvordan du vil at artikkelen skal bygges opp er opp til deg")?>
                <textarea id = "psummary" name="psummary" form="minform" maxlength="3400" placeholder="Her kan du skrive selve artikkelen"><?php echo stripcslashes($loadedNyhetsartikkel->innhold)?></textarea><?php addCharacterCounter("psummary");?>
            </div>

            <!-- Kildeboks -->
            <div class = "uthevetBoksForm" id = "kildeboks">
                <?php
                if ($loadedNyhetsartikkel == null) {
                    ?>
                    <label for="skrevet_av" class = "labelForInput">Forfatter/skrevet av*</label>
                    <input type="text" id="skrevet_av" name="skrevet_av" placeholder="Eks.: Navn Navnesen" class = "small_input" maxlength="40" value = "<?php echo stripcslashes($loadedNyhetsartikkel->skrevet_av)?>"><?php addCharacterCounter("skrevet_av");?>
                    <label for="rolle" class = "labelForInput">Rolle/stilling</label>
                    <input type="text" id="rolle" name="rolle" placeholder="Eks.: Prosjektleder" class = "small_input" maxlength="40" value = "<?php echo stripcslashes($loadedNyhetsartikkel->rolle)?>"><?php addCharacterCounter("rolle");?>
                    <?php
                }else {
                    ?>
                    <label for="endret_av" class = "labelForInput">Hvem gjør endringer?*</label>
                    <?php addInfoBox("endringerFelt", "Her fyller du ut DITT navn, slik at en leser ser hvem som gjorde endringer sist.") ?>
                    <input type="text" id="endret_av" name="endret_av" placeholder="Eks.: Navn Navnesen" class = "small_input" maxlength="100" value = "<?php echo stripcslashes($loadedNyhetsartikkel->endret_av)?>"><?php addCharacterCounter("endret_av");?>
                    <?php
                }
                ?>
            </div>

            <label for="assignedProjectChooser" class = "labelForInput">Tilhørende prosjekt</label>
            <?php addInfoBox("prosjekterDropdownInfo", "Her legger du til prosjektet som er tilknyttet nyhetsartikkelen, slik at leser av artikkelen kan trykke seg videre til prosjektet via en link i artikkelen") ?>
            <select id="assignedProjectChooserDropdown" name="assignedProjectChooser">
                <?php
                loadProjectsAsDropdownOptions($loadedNyhetsartikkel->tilknyttet_prosjekt);
                ?>
            </select>
        </div>

        <?php
        if ($loadedNyhetsartikkel == null) {
            addSubmitButtonWithVerification("minform", array("tittel", "ingress", "psummary", "skrevet_av"), array("rolle"));
        }else {
            addSubmitButtonWithVerification("minform", array("tittel", "ingress", "psummary", "endret_av"), array());
        }
        ?>
    </form>
    <?php
    addCreepyCharactersMonitorToWholePage();
}

function getEditingNewsArticle() {
    $articleID = $_GET['editArticleID'];
    error_log("Received articleID: " . $articleID);
    $formatted_table_name = getFormattedTableName("eha_nyhetsartikler");

    if ($articleID != null) {
        global $wpdb;
        $query = "SELECT * FROM " . $formatted_table_name . " WHERE id = " . $articleID;
        $article = $wpdb->get_results($query);

        return $article[0];
    }
}