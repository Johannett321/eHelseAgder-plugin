<?php
add_shortcode( 'sc_prosjektarkiv', 'sc_prosjektarkiv');

function sc_prosjektarkiv() {
    if (areElementorBufferingObjects()) return;
    loadProsjekter();
}

function loadProsjekter() {
    global $wpdb;

    $query = "SELECT prosjektstart FROM " . getProsjekterDatabaseRef() . " ORDER BY prosjektstart ASC LIMIT 1";
    $startYear = $wpdb->get_results($query)[0]->prosjektstart;

    $query = "SELECT prosjektstart FROM " . getProsjekterDatabaseRef() . " ORDER BY prosjektstart DESC LIMIT 1";
    $endYear = $wpdb->get_results($query)[0]->prosjektstart;

    ?>
    <div class = "collapsibles" id = "displayCol">
        <?php
        for ($i = $startYear; $i <= $endYear; $i++) {

            $query = "SELECT id, project_name, undertittel, prosjektstart, bilde, prosjektstatus FROM " . getProsjekterDatabaseRef() .
                " WHERE prosjektstart >= " . $i .
                " AND prosjektstart < " . ($i + 1) .
                " ORDER BY project_name ASC LIMIT 5";

            $results =  $wpdb->get_results($query);
            $eventCounter = 0;

            if ($results != null) {
                ?>
                <button type="button" class="collapsible">
                    <?php echo "Prosjekter med oppstart i " . $i?>
                    <span class="material-icons">expand_more</span>
                </button>

                <div class="content artikkelKortHolder">
                    <?php
                    foreach($results as $result) {
                        $specialClass = "";
                        if ($result->prosjektstatus != 1 && $result->prosjektstatus != 2) {
                            $specialClass = "inaktiv";
                        }

                        $eventCounter++;
                        createSmallListItem($result->project_name,
                            $result->undertittel,
                            $result->prosjektstart,
                            $result->bilde,
                            "prosjektside/?prosjektID=" . $result->id,
                            $specialClass);
                        if ($eventCounter > 4) {
                            ?>
                            <center>
                                <a href = "aarstall?year=<?php echo $i ?>"><button class = "viewMore">Vis alle prosjekter fra <?php echo $i?></button></a>
                            </center>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
            }else {
                ?>
                <button type="button" class="collapsible">
                    <?php echo $i?>
                </button>

                <div class="content">
                    Ingen nye prosjekter ble startet dette året
                </div>
                <?php
            }
        }
        ?>
    </div>
    <?php
    makeCollapsiblesWork();
}