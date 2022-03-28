<?php

require 'PubliserProsjekt.php';
require 'ProsjektRedigeringKategorierJS.php';

add_shortcode( 'prosjektredigeringkategorier', 'prosjektredigeringkategorier');

securePageWithLogin('prosjektredigering/kategorier');

function prosjektredigeringkategorier() {
    /*
    if (userIsNotLoggedInWithThrowback()) {
        return;
    }
    */
    session_start();
    validateFieldsFromPage1();
    leggTilInformasjonFelt();
}

function validateFieldsFromPage1() {
    saveFieldToSession("pname");
    saveFieldToSession("psubtitle");
    saveFieldToSession("pleadername");
    saveFieldToSession("pleaderemail");
    saveFieldToSession("pleaderphone");
    saveFieldToSession("project_start");
    saveFieldToSession("project_end");
    saveFieldToSession("samarbeidspartnere");
    saveFieldToSession("prosjekteierkommuner");
    saveFieldToSession("psummary");
    saveImageUploaded();
}

function saveFieldToSession($fieldToSave) {
    if (isset($_POST[$fieldToSave])) {
        error_log("-");
        error_log("Saving field: " . $fieldToSave . " to session.");
        $_SESSION[$fieldToSave] = $_POST[$fieldToSave];
        error_log("Verification: " . $_SESSION[$fieldToSave]);
    }
}

function saveImageUploaded() {
    $uploadedFileName = uploadFileAndGetName("bilde");
    error_log("Lagrer bilde til session: " . $uploadedFileName);
    $_SESSION["bilde"] = $uploadedFileName;
}

function leggTilInformasjonFelt() {
    if (isset($_GET['editProsjektID'])) {
        $postURL = "../../wp-json/ehelseagderplugin/api/publiser_prosjekt?editProsjektID=" . $_GET['editProsjektID'];
    }else {
        $postURL = "../../wp-json/ehelseagderplugin/api/publiser_prosjekt";
    }
    ?>
    <form action="<?php echo $postURL ?>" method="post" id = "myForm">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <div class="infoBlokk">
            <i class="material-icons">info</i>
            <h5 class="mainTitle">Legg til informasjon om prosjektet <?php echo $_SESSION["pname"] ?></h5>
            <p>Under kan du legge til informasjon du ønsker å dele om prosjektet ved hjelp av ulike kategorier. Finner du
                ikke kategorien du leter etter kan du velge «legg til egen kategori» for å definere kategori selv. Den nye kategorien vil dukke opp under. </p>
        </div>

        <div class="innhold">
            <h4>Legg til kategori:</h4>
            <div class="addCustomField">
                <div id="chooseLine">
                    <select id="collapsibleChooser" name="collapsibleChooser">
                        <option value="" disabled selected>Velg kategori</option>
                        <!--<option value="carrangementer">Arrangementer</option>-->
                        <!--<option value="cbildegalleri">Bildegalleri</option>-->
                        <option value="cleverandorer">Leverandører</option>
                        <option value="cmerinfo">Mer informasjon om prosjektet</option>
                        <option value="cmilepaeler">Milepæler</option>
                        <!--<option value="cmål">Mål</option>-->
                        <!--<option value="cmålgruppe">Målgruppe</option>-->
                        <!--<option value="cnedlastbaredokumenter">Nedlastbare dokumenter</option>-->
                        <option value="cprosjektteam">Prosjekt-team</option>
                        <!--<option value="cforskning">Relevant forskning</option>-->
                        <!--<option value="csamarbeidspartnere">Samarbeidspartnere</option>-->
                        <!--<option value="cstatus">Status</option>-->
                        <!--<option value="cvideoer">Videoer</option>-->
                        <option value="cegenkategori" style="font-weight:400;">+ Legg til egen kategori</option>
                    </select>
                    <button id="addCategoryButton" class="addInfoButton" type="button">
                        <i class="material-icons">add</i><p>Legg til informasjon</p></button>
                    <div class = "hidden inlineBlock" id = "categoryAlreadyAdded">
                        <i class="material-icons">check</i>
                        <h5 class = "inlineBlock" id = "categoryAlreadyAddedText">Allerede lagt til</h5>
                    </div>
                </div>

            </div>
            <div id="collapsibles">

            </div>
        </div>

        <div class="infoBlokk" id="bottomProgress">
            <textBox class="progressBar" id="steg2">
                <p class="stegText" id="step1">Grunnleggende info</p>
                <p class="stegText" id="step2">Ekstra kategorier</p>
                <p class="stegText" id="step3">Forhåndsvisning</p>
                <div class="border">
                    <div id="thisBar" class="bar">
                    </div>
                </div>
                <br>
                <center>
                    <input type = "submit" class = "button" id = "submitButton" value = "Videre">
                </center>
            </textBox>

        </div>

    </form>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<?php
prosjektRedigeringKategorierJS();
}