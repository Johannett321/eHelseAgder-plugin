<?php
include ('SisteArtiklerListe.php');

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
    <a href = "../../opprett-nyhetsartikkel?editArticleID=<?php echo $artikkelID ?>"><button>Rediger artikkel</button></a>
    <h3><?php echo $artikkelInfo[0]->tittel; ?></h3>
    <span><?php echo $artikkelInfo[0]->ingress ?></span>
    <div class = "coverPhoto"></div>
    <div><?php echo nl2br($artikkelInfo[0]->innhold); ?></div>
    <div id = "kildeinfo">Publisert <?php echo $artikkelInfo[0]->dato_skrevet?>, av <?php echo $artikkelInfo[0]->skrevet_av ?></div>
    <style>
        .coverPhoto {
            float: left;
            background-color: gray;
            width: 250px;
            height: 150px;
        }
    </style>
    <?php
}