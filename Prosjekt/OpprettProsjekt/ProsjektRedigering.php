<?php

require 'ProsjektRedigeringKategorier.php';

//add_action( 'rest_api_init', 'add_post_receiver');
add_shortcode( 'prosjektredigeringsverktoy', 'startverktoy');

function startverktoy( $atts ) {
    if (userIsNotLoggedInWithThrowback()) {
        return;
    }
    error_log("STEP 7");
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
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

        <div class="infoBlokk">
            <i class="material-icons">info</i>
            <h5>Denne prosessen skjer i tre steg. For å gå videre til neste steg trykker du "videre" nederst på siden.</h5>
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
                    <h5>Velg bilde</h5>
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
                <label for="pname" class = "labelForInput">Prosjektets navn</label>
                <input type="text" id="pname" name="pname" placeholder="Digital Hjemmeoppfølging" class = "small_input" maxlength="100" value = "<?php echo $loadedProsjekt->project_name ?>">
                <label for="psubtitle" class = "labelForInput">En setning om prosjektet (beskrivende undertittel)</label>
                <input type="text" id="psubtitle" name="psubtitle" placeholder="Et EU prosjekt for å øke livskvalitet for pasienter med kronisk sykdom." class = "small_input" maxlength="100" value = "<?php echo $loadedProsjekt->undertittel?>">
                <div class = "uthevetBoksForm" id = "prosjektLederBoks">
                    <h4>Prosjektleder</h4>
                    <ul id="prosjLederInputList">
                    <li><label for="pleadername" class = "labelForInput">Fullt navn</label>
                    <input type="text" id="pleadername" name="pleadername" placeholder="Navn Navnesen" class = "small_input" maxlength="35" value = "<?php echo $loadedProsjekt->ledernavn ?>"></li>
                    <li><label for="pleaderemail" class = "labelForInput">Epost</label>
                    <input type="text" id="pleaderemail" name="pleaderemail" placeholder="navn.navnesen@gmail.com" class = "small_input" maxlength="60" value = "<?php echo $loadedProsjekt->ledermail ?>"></li>
                    <li><label for="pleaderphone" class = "labelForInput">Mobil</label>
                    <input type="text" id="pleaderphone" name="pleaderphone" placeholder="40640382" class = "small_input" maxlength="15" value = "<?php echo $loadedProsjekt->ledertlf ?>"></li>
                    </ul>
                </div>
                <label for="prosjekteierkommuner" class = "labelForInput">Prosjekteierkommune(r)</label>
                <input type="text" id="prosjekteierkommuner" name="prosjekteierkommuner" placeholder="Kristiansand" class = "small_input" maxlength="40" value = "<?php echo $loadedProsjekt->prosjekteierkommuner ?>">
                <label for="samarbeidspartnere" class = "labelForInput">Søkerkommune(r)/samarbeidspartnere</label>
                <input type="text" id="samarbeidspartnere" name="samarbeidspartnere" placeholder="Grimstad, Arendal" class = "small_input" maxlength="40" value = "<?php echo $loadedProsjekt->samarbeidspartnere ?>">
                <label for="project_start" class = "labelForInput">Prosjektstart</label>
                <input type="text" id="project_start" name="project_start" placeholder="2025" class = "small_input" maxlength="14" value = "<?php echo $loadedProsjekt->prosjektstart ?>">
                <label for="project_end" class = "labelForInput">Estimert prosjektslutt</label>
                <input type="text" id="project_end" name="project_end" placeholder="2032" class = "small_input" maxlength="14" value = "<?php echo $loadedProsjekt->prosjektslutt ?>">

            </div>

            <div class = "sammendragContainer">
                <label for = "psummary" class = "labelForInput"><h3>Sammendrag</h3></label>
                <textarea id = "psummary" name="psummary" form="minform" maxlength="1700" placeholder="Her kan du skrive en kort tekst om prosjektet"><?php echo $loadedProsjekt->project_text ?></textarea>
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
                    <center>
                        <input type = "submit" class = "button" id = "submitButton" value = "Videre">
                    </center>
                </textBox>
            </div>
        </div>
    </form>
    <?php
}
