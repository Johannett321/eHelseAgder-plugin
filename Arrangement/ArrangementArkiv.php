<?php
include "AarsSide.php";

add_shortcode( 'sc_arrangementarkiv', 'sc_arrangementarkiv');

function sc_arrangementarkiv() {
    loadArrangementer();
}

function loadArrangementer() {
    $startYear = 2022;
    $endYar = date("Y");

    ?>
    <div class = "collapsibles" id = "displayCol">
        <?php
        for ($i = $startYear; $i <= $endYar; $i++) {
            ?>
            <button type="button" class="collapsible">
                <?php echo $i?>
            </button>

            <div class="content">
                <?php
                global $wpdb;
                $query = "SELECT * FROM " . getArrangementerDatabaseRef() .
                    " WHERE start_dato >= '" . $i . "-01-01'" .
                    " AND start_dato < '" . ($i+1) . "-01-01'" .
                    " LIMIT 5";

                $results =  $wpdb->get_results($query);

                $eventCounter = 0;
                foreach($results as $result) {
                    $eventCounter++;
                    createSmallListItem($result->tittel,
                        $result->kort_besk,
                        getDisplayDateFormat($result->start_dato),
                        $result->bilde,
                        "vis-arrangement/?eventID=" . $result->id);
                }
                if ($eventCounter > 4) {
                    ?>
                    <center>
                        <a href = "aarstall?year=<?php echo $i ?>"><button class = "viewMore">Vis alle arrangementer fra <?php echo $i?></button></a>
                    </center>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    makeCollapsiblesWork();
}