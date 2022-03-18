<?php
function shallWeLoadProsjekt() {
    //Dersom man skal redigere et prosjekt
    if (isset($_GET['editProsjektID'])) {
        error_log("ProsjektID is set");
        $prosjektID = $_GET['editProsjektID'];
        $formatted_table_name = getCollapsiblesDatabaseRef();

        global $wpdb;
        $query = "SELECT * FROM " . $formatted_table_name . " WHERE prosjekt_id = " . $prosjektID;
        $collapsiblesFound = $wpdb->get_results($query);
        error_log("Found collapsibles: " . sizeof($collapsiblesFound));

        for ($i = 0; $i < sizeof($collapsiblesFound); $i++) {
            $innhold = $collapsiblesFound[$i]->innhold;
            $innhold = str_replace("\r", '', $innhold);
            $innhold = str_replace("\n", '\n', $innhold);

            switch($collapsiblesFound[$i]->collapsible_type) {
                case 1:
                    //Custom kategori
                    $customName = $collapsiblesFound[$i]->egendefinert_navn;
                    error_log("Found custom name: " . $customName);
                    $customName = str_replace("\r", '', $customName);
                    $customName = str_replace("\n", '\n', $customName);
                    error_log("Modified custom name: " . $customName);

                    ?>
                    if (!colHasBeenDeletedLocally("cegenkategori" + (customColCounter+1))) {
                    createCustomCatCol("<?php echo $customName?>", "<?php echo $innhold ?>");
                    }
                    <?php
                    break;
                case 2:
                    //leverandører
                    ?>
                    if (!colHasBeenDeletedLocally("cleverandorer")) {
                    console.log("Creating leverandorer col with content: <?php echo $innhold ?>");
                    createLeverandorerCol("<?php echo $innhold ?>");
                    }
                    <?php
                    break;
                case 3:
                    //Prosjekt-team
                    ?>
                    if (!colHasBeenDeletedLocally("cprosjektteam")) {
                    createProsjektTeamCol("<?php echo $innhold ?>");
                    }
                    <?php
                    break;
                case 4:
                    //Mer informasjon om prosjektet
                    ?>
                    if (!colHasBeenDeletedLocally("cmerinfo")) {
                    createMerInfoCol("<?php echo $innhold ?>");
                    }
                    <?php
                    break;
                case 5:
                    //Milepæler
                    ?>
                    if (!colHasBeenDeletedLocally("cmilepaeler")) {
                    createMilepaelerCol("<?php echo $innhold ?>");
                    }
                    <?php
                    break;
            }
        }
    }
}