<?php

add_shortcode( 'listeoverprosjekter', 'getprojectlist');

function getProjects() {
    global $wpdb;
    $query = "SELECT * FROM " . getProsjekterDatabaseRef();
    return $wpdb->get_results($query);
}

function getprojectlist() {
    $projects = getProjects();
    ?>
        <?php
            foreach ($projects as $currentProject) {
                createLargeListItem($currentProject->project_name,
                    $currentProject->undertittel,
                    "Prosjektstart: " . $currentProject->prosjektstart,
                    "Prosjekteier: " . $currentProject->prosjekteierkommuner,
                    $currentProject->bilde,
                    "se-alle-prosjekter/prosjektside/?prosjektID=" . $currentProject->id);
            }
        ?>
    <?php
}