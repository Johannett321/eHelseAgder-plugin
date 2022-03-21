<?php

function loadProjectsAsDropdownOptions($selectedProjectID) {
    global $wpdb;
    $query = "SELECT * FROM " . getProsjekterDatabaseRef();
    $projects = $wpdb->get_results($query);
    error_log("Found projects: " . sizeof($projects));

    if ($selectedProjectID == null) {
        ?>
        <option value="" selected>Ingen prosjekt</option>
        <?php
    }else {
        ?>
        <option value="">Ingen prosjekt</option>
        <?php
    }

    for($i = 0; $i < sizeof($projects); $i++) {
        ?>
        <option value="<?php echo $projects[$i]->id ?>" <?php if ($selectedProjectID == $projects[$i]->id) echo 'selected'?>><?php echo $projects[$i]->project_name ?></option>
        <?php
    }
}