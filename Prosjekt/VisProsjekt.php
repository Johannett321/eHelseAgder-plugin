<?php

add_shortcode( 'prosjektside', 'getprojectpage');

function getProject($projectID) {
    $database = getProsjekterDatabaseRef();
    if (lookingAtDraft()) {
        $database = getDraftProsjekterDatabaseRef();
    }

    global $wpdb;
    $query = "SELECT * FROM " . $database . " WHERE id = " . $projectID;
    return $wpdb->get_results($query);
}

function getCollapsibles($projectID) {
    $database = getCollapsiblesDatabaseRef();
    if (lookingAtDraft()) {
        $database = getDraftCollapsibleDatabaseRef();
    }
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM " . $database . " WHERE prosjekt_id = " . $projectID);
}

function getprojectpage() {
    if (!isset($_GET["prosjektID"])) {
        showErrorMessage("Denne siden ble ikke lastet inn riktig");
        return;
    }

    $prosjektID = $_GET["prosjektID"];
    $projectInfo = getProject($prosjektID);
    $bildeUrl =  $projectInfo[0]->bilde;

    if ($projectInfo == null) {
        showErrorMessage("Dette prosjektet eksisterer ikke lenger!");
        return;
    }

    if (isset($_GET['message'])) {
        showCompleteMessage($_GET['message']);
    }

    if (isset($_GET['popupT'])) {
        createPopupBox($_GET['popupT'], $_GET['popupM']);
    }
    ?>
    <head>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <?php
    if (userIsLoggedIn() && !lookingAtDraft()) {
        ?>
        <head>
            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        </head>
        <a href = "../../opprett-prosjekt?editProsjektID=<?php echo $prosjektID ?>"><button class="editButton" id="editButtonProsj">Rediger prosjekt<span class = "material-icons">edit</span></button></a>
        <?php
    }
    ?>
    <div class = "topPart">
        <div class = "coverPhoto"><img src = "<?php echo getPhotoUploadUrl() . $bildeUrl ?>"></div>
        <div class = "oppsummert">
            <h4>Kort om prosjektet</h4>
            <div>
                <h5>Prosjektnavn:</h5><span><?php echo $projectInfo[0]->project_name?></span>
            </div>
            <div>
                <h5>Prosjektleder:</h5><span><?php echo $projectInfo[0]->ledernavn?></span>
            </div>
            <div>
                <h5>Prosjekteier:</h5>
                <div>
                    <i>Epost: <?php echo $projectInfo[0]->ledermail?></i>
                    <br>
                    <i>Mobil: <?php echo $projectInfo[0]->ledertlf?></i>
                </div>
            </div>
            <div>
                <h5>Søkerkommuner:</h5><span><?php echo $projectInfo[0]->sokerkommuner?></span>
            </div>
            <div>
                <h5>samarbeidspartnere:</h5><span><?php echo $projectInfo[0]->samarbeidspartnere?></span>
            </div>
            <div>
                <h5>Prosjektstart:</h5><span><?php echo $projectInfo[0]->prosjektstart?></span>
            </div>
            <div>
                <h5>Prosjektslutt (estimert):</h5><span><?php echo $projectInfo[0]->prosjektslutt?></span>
            </div>
        </div>
    </div>
    <center><h1><?php echo $projectInfo[0]->project_name; ?></h1></center>
    <div class = "projectText"><?php echo nl2br($projectInfo[0]->project_text); ?></div>
    <div class = "collapsibles" id = "displayCol">
        <?php
        $collapsibles = getCollapsibles($prosjektID);

        if ($collapsibles != null) {
            ?>
            <center><h4 class = "contentTitle">Vil du vite mer?</h4></center>
            <?php
        }

        for ($i = 0; $i < sizeof($collapsibles); $i++) {
            ?>
            <button type="button" class="collapsible"><?php
                echo getCollapsibleName($collapsibles[$i]->collapsible_type, $collapsibles[$i]->egendefinert_navn);
                ?><span class="material-icons">expand_more</span></button>
            <div class="content">
                <p><?php echo getHtmlContentForCollapsible($collapsibles[$i]);?></p>
            </div>
            <?php
        }
        ?>
    </div>
    <script type = "text/javascript">
        var coll = document.getElementsByClassName("collapsible");
        var i;

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        }
    </script>
    <?php
    if (lookingAtDraft()) {
        ?>
        <br/>
        <div class="infoBlokk" id="bottomProgress">
            <textBox class="progressBar" id="steg3">
                <p class="stegText" id="step1">Grunnleggende info</p>
                <p class="stegText" id="step2">Ekstra kategorier</p>
                <p class="stegText" id="step3">Forhåndsvisning</p>
                <div class="border">
                    <div id="thisBar" class="bar">
                    </div>
                </div>
                <br>

                <button type="button" id = "backButton">Tilbake</button>
                <button type="button" id = "publishButton">Publiser</button>
                <script type="text/javascript">
                    const backButton = document.getElementById('backButton');
                    const publishButton = document.getElementById('publishButton');

                    backButton.onclick = function () {
                        window.history.go(-1)
                    }

                    publishButton.onclick = function () {
                        if (confirm("Er du sikker på at du vil publisere prosjektet?")) {
                            console.log("Clearer localstorage for å publisere prosjekt");
                            localStorage.clear();

                            location.href = "../../../../wp-json/ehelseagderplugin/api/publiser_prosjekt?prosjektID=<?php echo $_GET['prosjektID'] ?>";
                        }
                    }
                </script>
            </textBox>

        </div>


        <?php
    }
}