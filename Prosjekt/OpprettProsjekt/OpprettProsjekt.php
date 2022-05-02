<?php

require 'OpprettProsjektKategorier.php';
require 'OpprettProsjektTools.php';
include 'SlettProsjekt.php';

add_shortcode( 'prosjektredigeringsverktoy', 'startverktoy');

securePageWithLogin('opprett-prosjekt');
thisPageRequiresCookies('opprett-prosjekt');

function startverktoy( $atts ) {
    $loadedProsjekt = loadProsjekt();
    lagFelter($loadedProsjekt);
}

function loadProsjekt() {
    $prosjektID = $_GET['editProsjektID'];
    error_log("Received projectID: " . $prosjektID, 0);
    $formatted_table_name = getProsjekterDatabaseRef();

    if ($prosjektID != null) {
        global $wpdb;
        $query = "SELECT * FROM " . $formatted_table_name . " WHERE id = " . $prosjektID;
        $project = $wpdb->get_results($query);

        return $project[0];
    }
}

function lagFelter($loadedProsjekt) {
    ?>
    <form action = "kategorier<?php if (isset($_GET['editProsjektID'])) echo "?editProsjektID=" . $_GET['editProsjektID']?>" method = "post" id = "minform" enctype="multipart/form-data">
        <div class="infoBlokk">
            <i class="material-icons">info</i>
            <h5>Denne prosessen skjer i tre steg. For å gå videre til neste steg trykker du fortsett nederst på siden.</h5>
            <br>
            <textBox class="progressBar" id="steg1">
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

            <!-- OPPLASTING AV BILDE -->
            <div id="photoPlaceholder">
                <h3>Velg forsidebilde</h3>
                <div class="uploadPhoto" id = "uploadPhotoButton">
                    <div class="lastOppBildeKnapp">
                        <h5>Last opp bilde</h5>
                        <i class="material-icons">upload</i>
                    </div>
                    <img id="output" src = "<?php echo getPhotoUploadUrl() . $loadedProsjekt->bilde ?>"/>
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
            </div>

            <div class = "requiredPart">
                <h3 class = "mainTitle">Kort om prosjektet</h3>
                <label for="pname" class = "labelForInput">Prosjektets navn*</label>
                <input type="text" id="pname" name="pname" placeholder="Digital Hjemmeoppfølging" class = "small_input" maxlength="55" value = "<?php echo $loadedProsjekt->project_name ?>"><?php addCharacterCounter("pname");?>
                <label for="psubtitle" class = "labelForInput">En setning om prosjektet (beskrivende undertittel)*</label>
                <?php addInfoBox("subtitleInfo", "Eksempel: Et EU prosjekt for å øke livskvalitet for pasienter med kronisk sykdom");?>
                <input type="text" id="psubtitle" name="psubtitle" placeholder="Et EU prosjekt for å øke livskvalitet for pasienter med kronisk sykdom." class = "small_input" maxlength="100" value = "<?php echo $loadedProsjekt->undertittel?>"><?php addCharacterCounter("psubtitle");?>
                <div class = "uthevetBoksForm" id = "prosjektLederBoks">
                    <h4>Prosjektleder</h4>
                    <ul id="prosjLederInputList">
                        <li><label for="pleadername" class = "labelForInput">Fullt navn*</label>
                            <input type="text" id="pleadername" name="pleadername" placeholder="Navn Navnesen" class = "small_input" maxlength="35" value = "<?php echo $loadedProsjekt->ledernavn ?>"></li><?php addCharacterCounter("pleadername");?>
                        <li><label for="pleaderemail" class = "labelForInput">Epost*</label>
                            <input type="text" id="pleaderemail" name="pleaderemail" placeholder="navn.navnesen@gmail.com" class = "small_input" maxlength="60" value = "<?php echo $loadedProsjekt->ledermail ?>"></li><?php addCharacterCounter("pleaderemail");?>
                        <li><label for="pleaderphone" class = "labelForInput">Mobil</label>
                            <input type="text" id="pleaderphone" name="pleaderphone" placeholder="40640382" class = "small_input" maxlength="15" value = "<?php echo $loadedProsjekt->ledertlf ?>"></li><?php addCharacterCounter("pleaderphone");?>
                    </ul>
                </div>
                <label for="prosjekteierkommuner" class = "labelForInput">Prosjekteier*</label>
                <input type="text" id="prosjekteierkommuner" name="prosjekteierkommuner" placeholder="Kristiansand" class = "small_input" maxlength="40" value = "<?php echo $loadedProsjekt->prosjekteierkommuner ?>"><?php addCharacterCounter("prosjekteierkommuner");?>
                <label for="sokerkommuner" class = "labelForInput">Søkerkommune(r)</label>
                <input type="text" id="sokerkommuner" name="sokerkommuner" placeholder="Grimstad, Arendal" class = "small_input" maxlength="200" value = "<?php echo $loadedProsjekt->sokerkommuner ?>"><?php addCharacterCounter("sokerkommuner");?>
                <label for="samarbeidspartnere" class = "labelForInput">Samarbeidspartner(e)</label>
                <input type="text" id="samarbeidspartnere" name="samarbeidspartnere" placeholder="Grimstad, Arendal" class = "small_input" maxlength="200" value = "<?php echo $loadedProsjekt->samarbeidspartnere ?>"><?php addCharacterCounter("samarbeidspartnere");?>
                <label for="project_start" class = "labelForInput">Prosjektstart*</label><?php addInfoBox("prosjektStartInfo", "Her fyller du ut årstallet som prosjektet starter/startet");?>
                <input type="text" id="project_start" name="project_start" placeholder="2025" class = "small_input" maxlength="4" value = "<?php echo $loadedProsjekt->prosjektstart ?>"><?php addCharacterCounter("project_start");?>
                <label for="project_end" class = "labelForInput">Estimert prosjektslutt</label>
                <input type="text" id="project_end" name="project_end" placeholder="2032" class = "small_input" maxlength="14" value = "<?php echo $loadedProsjekt->prosjektslutt ?>"><?php addCharacterCounter("project_end");?>

                <label for="prosjektstatus" class = "labelForInput">Prosjektets status*</label><?php addInfoBox("prosjektStatusInfoBox", "Her velger du hvor i prosessen prosjektet er akkurat nå. Dette påvirker hvor prosjektet blir vist på nettsiden");?>
                <select id="prosjektstatus" name="prosjektstatus">
                    <?php
                    for ($i = 1; $i <=5; $i++) {
                        ?>
                        <option value = "<?php echo $i?>" <?php if ($loadedProsjekt->prosjektstatus == $i) echo "selected"?>><?php echo getProsjektStatusAsText($i)?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class = "sammendragContainer">
                <label for = "psummary" class = "labelForInput"><h3>Sammendrag*</h3></label>
                <?php addInfoBox("prosjektSammendrag", "Her skriver du en kort forklaring på hva prosjektet går ut på. OBS: Mer informasjon om prosjektet legges til på neste trinn");?>
                <textarea id = "psummary" name="psummary" form="minform" maxlength="1700" placeholder="Her kan du skrive en kort tekst om prosjektet"><?php echo $loadedProsjekt->project_text ?></textarea><?php addCharacterCounter("psummary");?>
            </div>

        </div>
        <div class="infoBlokk" id="bottomProgress">
            <textBox class="progressBar" id="steg1">
                <p class="stegText" id="step1">Grunnleggende info</p>
                <p class="stegText" id="step2">Ekstra kategorier</p>
                <p class="stegText" id="step3">Forhåndsvisning</p>
                <div class="border">
                    <div id="thisBar" class="bar">
                    </div>
                </div>
                <br>
                <?php
                addSubmitButtonWithVerification("minform",
                    array("pname",
                    "psubtitle",
                    "pleadername",
                    "pleaderemail",
                    "prosjekteierkommuner",
                    "project_start",
                    "psummary"),
                    array("pleaderphone",
                    "sokerkommuner",
                    "samarbeidspartnere",
                    "project_end"));
                ?>
            </textBox>
        </div>
    </form>
    <?php
    addCreepyCharactersMonitorToWholePage();
}
