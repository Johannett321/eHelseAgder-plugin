<?php
include "AarsSide.php";

add_shortcode( 'sc_nyhetsarkiv', 'sc_nyhetsarkiv');

function sc_nyhetsarkiv() {
    loadNyhetsartikler();
}

function loadNyhetsartikler() {
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
                $query = "SELECT * FROM " . getNyhetsartiklerDatabaseRef() .
                    " WHERE dato_skrevet >= '" . $i . "-01-01'" .
                    " AND dato_skrevet < '" . ($i+1) . "-01-01'" .
                    " ORDER BY dato_skrevet DESC LIMIT 3";

                error_log("Asking: " . $query);
                $results =  $wpdb->get_results($query);

                error_log("Result length: " . sizeof($results));

                ?>
                <div class = "artikkelKortHolder">
                    <?php
                    $articleCounter = 0;
                    foreach($results as $result) {
                        $articleCounter++;
                        createShortArticle($result);
                    }
                    if ($articleCounter > 2) {
                        ?>
                        <center>
                            <a href = "aarstall?year=<?php echo $i ?>"><button class = "viewMore">Vis alle nyheter fra <?php echo $i?></button></a>
                        </center>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
    makeCollapsiblesWork();
}