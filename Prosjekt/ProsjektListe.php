<?php

add_shortcode( 'sc_aktive_prosjekter', 'sc_aktive_prosjekter');

function getProjects() {
    global $wpdb;
    $query = "SELECT * FROM " . getProsjekterDatabaseRef() . " WHERE prosjektstatus = 1 OR prosjektstatus = 2 ORDER BY project_name ASC";
    return $wpdb->get_results($query);
}

function sc_aktive_prosjekter() {
    $projects = getProjects();
    ?>
    <div class = "artikkelKortHolder">
        <?php
        foreach ($projects as $currentProject) {
            createLargeListItem($currentProject->project_name,
                $currentProject->undertittel,
                "Prosjektstart: " . $currentProject->prosjektstart,
                "Prosjekteier: " . $currentProject->prosjekteierkommuner,
                $currentProject->bilde,
                "prosjektside/?prosjektID=" . $currentProject->id);
        }
        ?>
    </div>
    <?php
}