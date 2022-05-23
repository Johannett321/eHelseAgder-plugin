<?php
include "AarsSide.php";

add_shortcode( 'sc_arrangementarkiv', 'sc_arrangementarkiv');

function sc_arrangementarkiv() {
    if (areElementorBufferingObjects()) return;
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
        for ($i = $endYear; $i >= $startYear; $i--) {
            error_log($i . " " . $startYear . " " . $endYear);

            $query = "SELECT id, tittel, kort_besk, start_dato, start_klokkeslett, bilde FROM " . getArrangementerDatabaseRef() .
                " WHERE start_dato >= '" . intval($i) . "-01-01'" .
                " AND start_dato < '" . (intval($i) + 1) . "-01-01'" .
                " ORDER BY start_dato DESC LIMIT 3";

            $results =  $wpdb->get_results($query);
            $eventCounter = 0;

            if (sizeof($results) == 0) {
                ?>
                <center><h5>Fant ingen arrangementer</h5></center>
                <?php
                return;
            }

            if ($results != null) {
                ?>
                <button type="button" class="collapsible">
                    <?php echo $i?>
                    <span class="material-icons">expand_more</span>
                </button>

                <div class="content artikkelKortHolder">
                    <?php
                    foreach($results as $result) {
                        $specialClass = "";
                        if ($result->start_dato < date("Y-m-d")) {
                            $specialClass = "inaktiv";
                        }
                        $eventCounter++;
                        createSmallListItem($result->tittel,
                            $result->kort_besk,
                            getNoneImportantDisplayDateFormat($result->start_dato) . " kl " . $result->start_klokkeslett,
                            $result->bilde,
                            "vis-arrangement/?eventID=" . $result->id,
                            $specialClass);
                        if ($eventCounter >= 3) {
                            ?>
                            <center>
                                <a href = "aarstall?it=arrangementer&aar=<?php echo $i ?>"><button class = "viewMore">Vis alle arrangementer fra <?php echo $i?></button></a>
                            </center>
                            <?php
                        }
                    }
                    if ($eventCounter < 3 ) {
                        ?>
                        <h5>Det finnes ikke flere arrangementer i <?php echo $i ?></h5>
                        <?php
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