<?php
add_shortcode( 'sc_opprett_nyhetsartikkel', 'sc_opprett_nyhetsartikkel');

require "PupliserNyhetsartikkel.php";
require "OpprettNyhetsartikkelTools.php";
include "SlettNyhetsartikkel.php";

securePageWithLogin('opprett-nyhetsartikkel');

function sc_opprett_nyhetsartikkel() {
    error_log("Redigerer nå opprett nyhetsartikkel");
    $loadedNyhetsartikkel = getEditingNewsArticle();

    if (isset($_GET['editArticleID'])) {
        $postURL = "../../../../wp-json/ehelseagderplugin/api/publiser_nyhetsartikkel?editArticleID=" . $_GET['editArticleID'];
    }else {
        $postURL = "../../../../wp-json/ehelseagderplugin/api/publiser_nyhetsartikkel";
    }
    ?>

    <?php
    if ($loadedNyhetsartikkel != null) {
        ?>
        <a href = "../../../wp-json/ehelseagderplugin/api/slett_nyhetsartikkel?articleID=<?php echo $_GET['editArticleID']?>"><button>Slett nyhetsartikkel</button></a>
        <?php
    }
    ?>
    <form action = "<?php echo $postURL?>" method = "post" id = "minform" enctype="multipart/form-data">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <div class = "innhold">
            <h3 class = "mainTitle">Opprett nyhetsartikkel</h3>
            <!-- OPPLASTING AV BILDE -->
            <h4>Velg forsidebilde</h4>
            <div class="uploadPhoto" id = "uploadPhotoButton">
                <div>
                    <h5>Last opp bilde</h5>
                    <i class="material-icons">upload</i>
                </div>
                <input class = "hidden" type="file" name = "bilde" accept="image/*" onchange="loadFile(event)" id = "actualUploadButton">
                <img id="output" src = "<?php echo getPhotoUploadUrl() . $loadedNyhetsartikkel->bilde ?>"/>
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

                <label for="tittel" class = "labelForInput">Tittel:</label>
                <input type="text" id="tittel" name="tittel" placeholder="Vi har signert kontrakt!" class = "small_input" value = "<?php echo $loadedNyhetsartikkel->tittel?>">
                <label for="ingress" class = "labelForInput">Ingress:</label>
                <input type="text" id="ingress" name="ingress" placeholder="Etter mange måneder med venting, har endelig kontrakten med Min Bedrift AS blitt signert." class = "small_input" value = "<?php echo $loadedNyhetsartikkel->ingress?>">

                <div class = "sammendragContainer">
                    <label for = "psummary" class = "labelForInput">Innhold</label>
                    <textarea id = "psummary" name="psummary" form="minform" maxlength="1700" placeholder="Her kan du skrive selve artikkelen"><?php echo $loadedNyhetsartikkel->innhold?></textarea>
                </div>

                <!-- Kildeboks -->
                <div class = "uthevetBoksForm" id = "kildeboks">
                    <?php
                    if ($loadedNyhetsartikkel == null) {
                        ?>
                        <label for="skrevet_av" class = "labelForInput">Forfatter/skrevet av:</label>
                        <input type="text" id="skrevet_av" name="skrevet_av" placeholder="Navn Navnesen" class = "small_input" value = "<?php echo $loadedNyhetsartikkel->skrevet_av?>">
                        <label for="rolle" class = "labelForInput">Rolle/stilling:</label>
                        <input type="text" id="rolle" name="rolle" placeholder="Prosjektleder" class = "small_input" maxlength="100" value = "<?php echo $loadedNyhetsartikkel->dato_skrevet?>">
                        <?php
                    }else {
                        ?>
                        <label for="endret_av" class = "labelForInput">Hvem gjør endringer?</label>
                        <input type="text" id="endret_av" name="endret_av" placeholder="Navn Navnesen" class = "small_input" value = "<?php echo $loadedNyhetsartikkel->endret_av?>">
                        <?php
                    }
                    ?>
                </div>

                <label for="assignedProjectChooser" class = "labelForInput">Tilhørende prosjekt:</label>
                <select id="assignedProjectChooserDropdown" name="assignedProjectChooser">
                    <?php
                    loadProjectsAsDropdownOptions($loadedNyhetsartikkel->tilknyttet_prosjekt);
                    ?>
                </select>
            </div>

        <center>
            <input type = "submit" class = "button" id = "submitButton" value = "Videre">
        </center>
    </form>
    <?php
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