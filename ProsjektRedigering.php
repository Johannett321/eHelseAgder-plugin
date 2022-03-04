<?php

require 'ProsjektRedigeringKategorier.php';

//add_action( 'rest_api_init', 'add_post_receiver');
add_shortcode( 'prosjektredigeringsverktoy', 'startverktoy');

function startverktoy( $atts ) {
    //kreverInnlogging();
    $loadedProsjekt = loadProsjekt();
    lagFelter($loadedProsjekt);
}

function loadProsjekt() {
    $prosjektID = $_GET['editProsjektID'];
    error_log("Received projectID: " . $prosjektID, 0);
    $formatted_table_name = getFormattedTableName("eha_prosjekter");

    if ($prosjektID != null) {
        global $wpdb;
        $query = "SELECT * FROM " . $formatted_table_name . " WHERE id = " . $prosjektID;
        $project = $wpdb->get_results($query);

        $projectName = $project[0]->project_name;
        
        return array("projectName"=>$projectName,
        "undertittel"=>$project[0]->undertittel,
        "ledernavn"=>$project[0]->ledernavn,
        "ledermail"=>$project[0]->ledermail,
        "ledertlf"=>$project[0]->ledertlf,
        "prosjektstart"=>$project[0]->prosjektstart,
        "prosjektslutt"=>$project[0]->prosjektslutt,
        "kostnadsramme"=>$project[0]->kostnadsramme,
        "project_text"=>$project[0]->project_text
        );
    }
}

function lagFelter($loadedProsjekt) {
    ?>
    <form action = "kategorier<?php if (isset($_GET['editProsjektID'])) echo "?editProsjektID=" . $_GET['editProsjektID']?>" method = "post" id = "minform">

        <div class="infoBlokk">
            <textBox id=steg2>
                <p class="stegText" id="step1">Grunnleggende info</p>
                <p class="stegText" id="step2">Ekstra kategorier</p>
                <p class="stegText" id="step3">Forhåndsvisning</p>
                <div class="border">
                    <div id="thisBar" class="bar">
                    </div>
                </div>
            </textBox>
        </div>

        <div class = "requiredPart">
            <h3 class = "mainTitle">Kort om prosjektet</h3>
            <label for="pname" class = "labelForInput">Prosjektets navn:</label>
            <input type="text" id="pname" name="pname" placeholder="Digital Hjemmeoppfølging" class = "small_input" value = "<?php echo $loadedProsjekt['projectName']?>">
            <label for="psubtitle" class = "labelForInput">En setning om prosjektet (beskrivende undertittel):</label>
            <input type="text" id="psubtitle" name="psubtitle" placeholder="Et EU prosjekt for å øke livskvalitet for pasienter med kronisk sykdom." class = "small_input" value = "<?php echo $loadedProsjekt['undertittel']?>">
            <div class = "projectLeader" id = "prosjektLederBoks">
                <h4>Prosjektleder</h4>
                <label for="pleadername" class = "labelForInput">Fullt navn:</label>
                <input type="text" id="pleadername" name="pleadername" placeholder="Navn Navnesen" class = "small_input" value = "<?php echo $loadedProsjekt['ledernavn']?>">
                <label for="pleaderemail" class = "labelForInput">Epost:</label>
                <input type="text" id="pleaderemail" name="pleaderemail" placeholder="navn.navnesen@gmail.com" class = "small_input" value = "<?php echo $loadedProsjekt['ledermail']?>">
                <label for="pleaderphone" class = "labelForInput">Mobil:</label>
                <input type="text" id="pleaderphone" name="pleaderphone" placeholder="40640382" class = "small_input" value = "<?php echo $loadedProsjekt['ledertlf']?>">
            </div>
            <label for="project_start" class = "labelForInput">Prosjektstart:</label>
            <input type="text" id="project_start" name="project_start" placeholder="2025" class = "small_input" value = "<?php echo $loadedProsjekt['prosjektstart']?>">
            <label for="project_end" class = "labelForInput">Estimert prosjektslutt:</label>
            <input type="text" id="project_end" name="project_end" placeholder="2032" class = "small_input" value = "<?php echo $loadedProsjekt['prosjektslutt']?>">
            <label for="cost" class = "labelForInput">Kostnadsramme:</label>
            <input type="text" id="cost" name="cost" placeholder="86 millioner" class = "small_input" value = "<?php echo $loadedProsjekt['kostnadsramme']?>">
        </div>

        <div class = "sammendragContainer">
            <label for = "psummary" class = "labelForInput">Sammendrag</label>
            <textarea id = "psummary" name="psummary" form="minform" maxlength="1700" placeholder="Her kan du skrive en kort tekst om prosjektet"><?php echo $loadedProsjekt['project_text']?></textarea>
        </div>

        <div class="infoBlokk">
            <textBox id=steg2>
                <p class="stegText" id="step1">Grunnleggende info</p>
                <p class="stegText" id="step2">Ekstra kategorier</p>
                <p class="stegText" id="step3">Forhåndsvisning</p>
                <div class="border">
                    <div id="thisBar" class="bar">
                    </div>
                </div>
            </textBox>
        </div>

        <center>
            <input type = "submit" class = "button" id = "submitButton" value = "Videre">
        </center>
    </form>
    <?php
}
