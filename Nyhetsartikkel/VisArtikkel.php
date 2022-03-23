<?php
include ('SisteArtiklerListe.php');
require "NyhetsartiklerTools.php";

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
    $bildeUrl =  $artikkelInfo[0]->bilde;

    ?>
        <div class = "artikkel">
            <a href = "../../opprett-nyhetsartikkel?editArticleID=<?php echo $artikkelID ?>"><button>Rediger artikkel</button></a>
            <h3><?php echo $artikkelInfo[0]->tittel; ?></h3>
            <span><?php echo $artikkelInfo[0]->ingress ?></span>
            <?php
            if ($artikkelInfo[0]->bilde != null && $artikkelInfo[0]->bilde != "") {
                ?>
                <div class = "coverPhoto"><img src = "<?php echo getPhotoUploadUrl() . $bildeUrl ?>"></div>
                <?php
            }
            ?>
            <div class = "artikkelTekst"><?php echo nl2br($artikkelInfo[0]->innhold); ?></div>
            <div class = "tilknyttetProsjektTekst"><?php echo getTilknyttetProsjektTekst($artikkelInfo[0])?></div>
            <div id = "kildeinfo">Publisert <?php echo $artikkelInfo[0]->dato_skrevet?>, av <?php echo $artikkelInfo[0]->skrevet_av ?> (<?php echo $artikkelInfo[0]->rolle ?>)</div>
            <?php
            $endretAv = $artikkelInfo[0]->endret_av;
            if ($endretAv != null && $endretAv != "") {
                ?>
                <div id = "endretInfo">Endret den <?php echo $artikkelInfo[0]->dato_endret?>, av <?php echo $artikkelInfo[0]->endret_av ?></div>
                <?php
            }
            implementFacebookShareButton();
            ?>
            <style>
                .coverPhoto {
                    float: left;
                    background-color: gray;
                    width: 250px;
                    height: 150px;
                }
            </style>
        </div>
    <?php
}