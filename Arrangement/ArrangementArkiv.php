<?php
include "AarsSide.php";

add_shortcode( 'sc_arrangementarkiv', 'sc_arrangementarkiv');

function sc_arrangementarkiv() {
    loadArrangementer();
}

function loadArrangementer() {
    global $wpdb;

    $query = "SELECT start_dato FROM " . getArrangementerDatabaseRef() . " ORDER BY start_dato ASC LIMIT 1";
    $startYear = date('Y', strtotime($wpdb->get_results($query)[0]->start_dato));

    $query = "SELECT start_dato FROM " . getArrangementerDatabaseRef() . " ORDER BY start_dato DESC LIMIT 1";
    $endYear = date('Y', strtotime($wpdb->get_results($query)[0]->start_dato));

    ?>
    <div class = "collapsibles" id = "displayCol">
        <?php
        for ($i = $startYear; $i <= $endYear; $i++) {

            $query = "SELECT id, tittel, kort_besk, start_dato, bilde FROM " . getArrangementerDatabaseRef() .
                " WHERE start_dato >= '" . $i . "-01-01'" .
                " AND start_dato < '" . $i + 1 . "-01-01'" .
                " ORDER BY start_dato ASC LIMIT 5";

            $results =  $wpdb->get_results($query);
            $eventCounter = 0;

            if ($results != null) {
                ?>
                <button type="button" class="collapsible">
                    <?php echo $i?>
                </button>

                <div class="content artikkelKortHolder">
                    <?php
                    foreach($results as $result) {
                        $eventCounter++;
                        createSmallListItem($result->tittel,
                            $result->kort_besk,
                            getDisplayDateFormat($result->start_dato),
                            $result->bilde,
                            "vis-arrangement/?eventID=" . $result->id);
                        if ($eventCounter > 4) {
                            ?>
                            <center>
                                <a href = "aarstall?year=<?php echo $i ?>"><button class = "viewMore">Vis alle arrangementer fra <?php echo $i?></button></a>
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
                    Det var ingen arrangementer som startet dette året
                </div>
                <?php
            }
        }
        ?>
    </div>
    <?php
    makeCollapsiblesWork();
}