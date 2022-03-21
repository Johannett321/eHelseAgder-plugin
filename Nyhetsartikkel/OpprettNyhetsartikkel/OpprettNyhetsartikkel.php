<?php
add_shortcode( 'sc_opprett_nyhetsartikkel', 'sc_opprett_nyhetsartikkel');

require "PupliserNyhetsartikkel.php";
require "OpprettNyhetsartikkelTools.php";
include "SlettNyhetsartikkel.php";

//ShortCode_Opprett_Nyhetsartikkel
function sc_opprett_nyhetsartikkel() {
    $loadedNyhetsartikkel = getEditingNewsArticle();

    $postURL = "";
    if (isset($_GET['editArticleID'])) {
        $postURL = "../../../../wp-json/ehelseagderplugin/api/publiser_nyhetsartikkel?editArticleID=" . $_GET['editArticleID'];
    }else {
        $postURL = "../../../../wp-json/ehelseagderplugin/api/publiser_nyhetsartikkel";
    }
    ?>
    <form action = "<?php echo $postURL?>" method = "post" id = "minform">
        <div class = "requiredPart">
            <h3 class = "mainTitle">Kort om nyheten</h3>
            <label for="tittel" class = "labelForInput">Tittel:</label>
            <input type="text" id="tittel" name="tittel" placeholder="Vi har signert kontrakt!" class = "small_input" value = "<?php echo $loadedNyhetsartikkel->tittel?>">
            <label for="ingress" class = "labelForInput">Ingress:</label>
            <input type="text" id="ingress" name="ingress" placeholder="Etter mange måneder med venting, har endelig kontrakten med Min Bedrift AS blitt signert." class = "small_input" value = "<?php echo $loadedNyhetsartikkel->ingress?>">
            <div class = "uthevetBoksForm" id = "kildeboks">
                <h4>Kildekritikk</h4>
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

        <div class = "sammendragContainer">
            <label for = "psummary" class = "labelForInput">Innhold</label>
            <textarea id = "psummary" name="psummary" form="minform" maxlength="1700" placeholder="Her kan du skrive selve artikkelen"><?php echo $loadedNyhetsartikkel->innhold?></textarea>
        </div>

        <center>
            <input type = "submit" class = "button" id = "submitButton" value = "Videre">
        </center>
    </form>
    <?php
    if ($loadedNyhetsartikkel != null) {
        ?>
        <a href = "../../../wp-json/ehelseagderplugin/api/slett_nyhetsartikkel?articleID=<?php echo $_GET['editArticleID']?>"><button>Slett nyhetsartikkel</button></a>
        <?php
    }
    ?>
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