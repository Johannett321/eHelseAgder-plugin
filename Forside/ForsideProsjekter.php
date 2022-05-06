<?php

add_shortcode( 'sc_forside_prosjekter', 'sc_forside_prosjekter');

function sc_forside_prosjekter() {
    if (areElementorBufferingObjects()) return;
    loadForsideProsjekter();
}

function loadForsideProsjekter() {
    global $wpdb;
    $prosjekter = $wpdb->get_results("SELECT * FROM " . getProsjekterDatabaseRef() . " WHERE prosjektstatus = 2 ORDER BY id DESC");
    if (areWeEditingWithElementor() && sizeof($prosjekter) == 0) {
        ?>
        <center><h5>Her vil de 6 første prosjektene vises (alfabetisk)</h5></center>
        <?php
        return;
    }
    ?>
    <div class = "prosjekter">
        <?php
        foreach ($prosjekter as $currentProsjekt) {
            ?>
            <a href = "prosjekter/prosjektside/?prosjektID=<?php echo $currentProsjekt->id ?>">
                <div class ="prosjektCard">
                    <img src = "<?php if ($currentProsjekt->bilde != null) echo getPhotoUploadUrl() . $currentProsjekt->bilde ?>"/>
                    <div class = "greenBackground">
                        <div class = "pCardTitleDesc">
                            <h5><?php echo $currentProsjekt->project_name ?></h5>
                            <p><?php echo $currentProsjekt->undertittel ?></p>
                        </div>
                    </div>
                </div>
            </a>
            <?php
        }
        ?>
    </div>
    <?php
}