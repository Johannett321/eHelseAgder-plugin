<?php

add_shortcode( 'sc_forside_prosjekter', 'sc_forside_prosjekter');

function sc_forside_prosjekter() {
    if (areElementorBufferingObjects()) return;
    loadForsideProsjekter();
}

function loadForsideProsjekter() {
    if (areWeEditingWithElementor()) {
        ?>
        <center><h5>Her vil de 6 første prosjektene vises (alfabetisk)</h5></center>
        <?php
        return;
    }
    global $wpdb;
    $prosjekter = $wpdb->get_results("SELECT * FROM " . getProsjekterDatabaseRef() . " WHERE prosjektstatus = 1 OR prosjektstatus = 2 ORDER BY project_name ASC");
    ?>
    <div class = "prosjekter">
        <?php
        foreach ($prosjekter as $currentProsjekt) {
            ?>
            <div class ="prosjektCard">
                <img src = "<?php echo getPhotoUploadUrl() . $currentProsjekt->bilde ?>"/>
                <div class = "pCardTitleDesc">
                    <div class = "greenBackground"></div>
                    <h5><?php echo $currentProsjekt->project_name ?></h5>
                    <p><?php echo $currentProsjekt->undertittel ?></p>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}