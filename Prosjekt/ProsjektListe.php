<?php

add_shortcode( 'listeoverprosjekter', 'getprojectlist');

function getProjects() {
    error_log("Trying to get projects",0);
    global $wpdb;
    $query = "SELECT * FROM " . getFormattedTableName("eha_prosjekter");
    return $wpdb->get_results($query);
}

function getprojectlist() {
    $projects = getProjects();
    ?>
    <h3>Alle prosjekter: </h3>
        <?php
            foreach ($projects as $currentProject) {
                ?>
                    <a href = <?php echo "prosjektside?prosjektID=" . $currentProject->id; ?>>
                        <h5><?php echo $currentProject->project_name; ?></h5>
                    </a>
                <?php
            }
        ?>
    <?php
}