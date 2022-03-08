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
    ?>
        <div class = "topPart">
            <div class = "coverPhoto"></div>
            <div class = "oppsummert"></div>
        </div>
        <center><h3><?php echo $projectInfo[0]->project_name; ?></h3></center>
        <div><?php echo nl2br($projectInfo[0]->project_text); ?></div>
        <center><h4 class = "contentTitle">Vil du vite mer?</h4></center>
        <div class = "collapsibles">
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
        <style>
            .topPart {
                height: 400px;
                overflow: hidden;
            }

            .coverPhoto {
                float: left;
                background-color: gray;
                width: 70%;
                height: 100%;
            }

            .oppsummert {
                float:right;
                background-color: green;
                width: 30%;
                height: 100%;
            }

            .contentTitle {
                margin-top: 100px;
            }

            .collapsibles {
                margin-top: 20px;
            }

            th {
                min-height: 20px;
                background-color: #D6EBCA;
                padding:10px;
            }

            td {
                height: 50px;
                background-color:#E7F0E2;
                padding:10px;
            }

            table {
                width:100%;
            }

            .redBlob {
                background-color: #E24545;
            }

            .greenBlob {
                background-color: #8CBE7E;
            }

            .yellowBlob {
                background-color: #EBE15C;
            }

            .blob {
                width: 10px;
                height: 10px;
                border-radius: 20px;
                display: inline-block;
            }

            .inliner {
                float: left;
                padding: 1em;
                width: 49%;
                text-align: center;
            }

            .inliner img {
                width: 100px;
            }

            .textFields h5 {
                text-transform: none;
                margin: 0px;
            }
            .textFields h6 {
                text-transform: none;
                margin: 0px;
            }
            .textFields p {
                margin: 0px;
                max-width:100%;
            }

            /* Style the button that is used to open and close the collapsible content */
            .collapsible {
                background-color: #eee;
                color: #444;
                cursor: pointer;
                padding: 18px;
                width: 100%;
                border: none;
                text-align: left;
                outline: none;
                font-size: 17px;
                font-weight:500;
                margin-top: 2px;
                margin-bottom: 2px;
            }

            /* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
            .active, .collapsible:hover {
                background-color: #ccc;
            }

            /* Style the collapsible content. Note: hidden by default */
            .content {
                padding: 0 18px;
                display: none;
                overflow: hidden;
                background-color: #f1f1f1;
                font-size: 15px;
            }
        </style>
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