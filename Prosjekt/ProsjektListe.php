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
                ?>
                    <a href = <?php echo "prosjektside?prosjektID=" . $currentProject->id; ?>>
                        <h5><?php echo $currentProject->project_name; ?></h5>
                    </a>
                <?php
            }
        ?>
    <?php
}