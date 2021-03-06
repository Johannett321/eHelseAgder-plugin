<?php

require 'PubliserProsjekt.php';
require 'OpprettProsjektKategorierJS.php';

add_shortcode( 'prosjektredigeringkategorier', 'prosjektredigeringkategorier');

securePageWithLogin('opprett-prosjekt/kategorier');
thisPageRequiresCookies('opprett-prosjekt/kategorier');

function prosjektredigeringkategorier() {
    if (areElementorBufferingObjects()) return;
    if (areWeVisitingFromMobileDevice()) {
        showErrorMessage("Du kan ikke opprette et prosjekt fra din mobil. Vennligst benytt en datamaskin");
        return;
    }
    session_start();
    validateFieldsFromPage1();

    createPopupBox("Legg til ekstra kategorier", "På denne siden kan du legge til informasjon du ønsker å dele om prosjektet ved hjelp av ulike kategorier. Finner du ikke kategorien du leter etter kan du velge «legg til egen kategori» for å definere kategori selv. <br> <br> All informasjon blir lagret automatisk underveis.", "Den er god!", null);

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
    saveFieldToSession("prosjektstatus");
    saveFieldToSession("samarbeidspartnere");
    saveFieldToSession("prosjekteierkommuner");
    saveFieldToSession("psummary");
    saveFieldToSession("sokerkommuner");
    saveImageUploaded();
}

function saveFieldToSession($fieldToSave) {
    if (isset($_POST[$fieldToSave])) {
        $_SESSION[$fieldToSave] = $_POST[$fieldToSave];
    }
}

function saveImageUploaded() {
    $uploadedFileName = uploadImageAndGetName("bilde");
    error_log("Lagrer bilde til session: " . $uploadedFileName);
    if ($uploadedFileName != null) {
        $_SESSION["bilde"] = $uploadedFileName;
    }else {
        $_SESSION["bilde"] = null;
    }
}

function leggTilInformasjonFelt() {
    if (isset($_GET['editProsjektID'])) {
        $postURL = "../../wp-json/ehelseagderplugin/api/lagre_utkast_prosjekt?editProsjektID=" . $_GET['editProsjektID'];
    }else {
        $postURL = "../../wp-json/ehelseagderplugin/api/lagre_utkast_prosjekt";
    }
    allowPagePOSTReqDuplication();
    ?>
    <form action="<?php echo $postURL ?>" method="post" id = "myForm" enctype="multipart/form-data">
        <div class="infoBlokk">
            <i class="material-icons">info</i>
            <h5 class="mainTitle">Legg til informasjon om prosjektet: <?php echo $_SESSION["pname"]?></h5>
            <br><br><p>Under kan du legge til informasjon du ønsker å dele om prosjektet ved hjelp av ulike kategorier. Finner du
                ikke kategorien du leter etter kan du velge «legg til egen kategori» for å definere kategori selv. Den nye kategorien vil dukke opp over. </p>
        </div>

        <div class="infoBlokk" id="topProgress">
            <textBox class="progressBar" id="steg2">
                <p class="stegText" id="step1">Grunnleggende info</p>
                <p class="stegText" id="step2">Ekstra kategorier</p>
                <p class="stegText" id="step3">Forhåndsvisning</p>
                <div class="border">
                    <div id="thisBar" class="bar">
                    </div>
                </div>
            </textBox>
        </div>

        <div class="innhold">
            <h3 class = "mainTitle">Ekstra kategorier</h3>
            <div id="collapsibles">

            </div>
            <div id="chooseLine">
            <h4>Legg til kategori</h4>
                <div class="addCustomField">
                        <select id="collapsibleChooser" name="collapsibleChooser">
                            <option value="" disabled selected>Velg kategori</option>
                            <!--<option value="carrangementer">Arrangementer</option>-->
                            <!--<option value="cbildegalleri">Bildegalleri</option>-->
                            <option value="cleverandorer">Leverandører</option>
                            <option value="cmerinfo">Mer informasjon om prosjektet</option>
                            <option value="cmilepaeler">Milepæler</option>
                            <!--<option value="cmål">Mål</option>-->
                            <!--<option value="cmålgruppe">Målgruppe</option>-->
                            <option value="cnedlastbaredokumenter">Nedlastbare dokumenter</option>
                            <option value="cprosjektteam">Prosjekt-team</option>
                            <!--<option value="cforskning">Relevant forskning</option>-->
                            <!--<option value="csamarbeidspartnere">Samarbeidspartnere</option>-->
                            <!--<option value="cstatus">Status</option>-->
                            <!--<option value="cvideoer">Videoer</option>-->
                            <option value="cegenkategori" style="font-weight:400;">+ Legg til egen kategori</option>
                        </select>
                        <button id="addCategoryButton" class="addInfoButton" type="button">
                            <i class="material-icons">add</i><p>Legg til kategori</p></button>
                        <div class = "hidden inlineBlock" id = "categoryAlreadyAdded">
                            <i class="material-icons">check</i>
                            <h5 class = "inlineBlock" id = "categoryAlreadyAddedText">Allerede lagt til</h5>
                        </div>
                    </div>
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
                    <button type="button" id = "backButton">Tilbake</button>
                    <input type = "submit" class = "button" id = "submitButton" value = "Fortsett">
                </center>

                <script type="text/javascript">
                    document.getElementById('backButton').onclick = function () {
                        window.history.go(-1)
                    }
                </script>
            </textBox>

        </div>

    </form>
<?php
prosjektRedigeringKategorierJS();
}