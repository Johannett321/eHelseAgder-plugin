<?php

add_shortcode( 'sc_vis_artikkel', 'sc_vis_artikkel');

function getArtikkel($artikkelID) {
    error_log("Trying to get projects",0);
    global $wpdb;
    $query = "SELECT * FROM " . getNyhetsartiklerDatabaseRef() . " WHERE id = " . $artikkelID;
    error_log("Sending query: " . $query,0);
    return $wpdb->get_results($query);
}

function sc_vis_artikkel() {
    $artikkelID = $_GET["artikkelID"];
    $artikkelInfo = getArtikkel($artikkelID);
    ?>
    <a href = "../../opprett-nyhetsartikkel?editArticleID=<?php echo $artikkelID ?>"><button>Rediger prosjekt</button></a>
    <h3><?php echo $artikkelInfo[0]->tittel; ?></h3>
    <span><?php echo $artikkelInfo[0]->ingress ?></span>
    <div class = "topPart">
        <div class = "coverPhoto"></div>
        <div class = "oppsummert"></div>
    </div>
    <div><?php echo nl2br($artikkelInfo[0]->innhold); ?></div>
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
    </style>
    <?php
}