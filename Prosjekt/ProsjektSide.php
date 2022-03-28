<?php

add_shortcode( 'prosjektside', 'getprojectpage');

function getProject($projectID) {
    error_log("Trying to get projects",0);
    global $wpdb;
    $query = "SELECT * FROM " . getProsjekterDatabaseRef() . " WHERE id = " . $projectID;
    error_log("Sending query: " . $query,0);
    return $wpdb->get_results($query);
}

function getCollapsibles($projectID) {
    global $wpdb;
    $formatted_table_name = getCollapsiblesDatabaseRef();
    return $wpdb->get_results("SELECT * FROM " . $formatted_table_name . " WHERE prosjekt_id = " . $projectID);
}

function getprojectpage() {
    $prosjektID = $_GET["prosjektID"];
    $projectInfo = getProject($prosjektID);
    $bildeUrl =  $projectInfo[0]->bilde;

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
                    <h5>Søkerkommuner/samarbeidspartnere:</h5><span><?php echo $projectInfo[0]->samarbeidspartnere?></span>
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
        <center><h4 class = "contentTitle">Vil du vite mer?</h4></center>
        <div class = "collapsibles" id = "displayCol">
            <?php
                $collapsibles = getCollapsibles($prosjektID);

                for ($i = 0; $i < sizeof($collapsibles); $i++) {
                    error_log("Collapsible found", 0);
                    ?>
                    <button type="button" class="collapsible"><?php 
                        echo getCollapsibleName($collapsibles[$i]->collapsible_type, $collapsibles[$i]->egendefinert_navn);
                    ?></button>
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
}