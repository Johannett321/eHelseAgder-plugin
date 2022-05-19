<?php
include "AarsSide.php";

add_shortcode( 'sc_nyhetsarkiv', 'sc_nyhetsarkiv');

function sc_nyhetsarkiv() {
    if (areElementorBufferingObjects()) return;
    loadNyhetsartikler();
}

function loadNyhetsartikler() {
    global $wpdb;
    $startYear = $wpdb->get_results("SELECT dato_skrevet FROM " . getNyhetsartiklerDatabaseRef() . " ORDER BY dato_skrevet ASC LIMIT 1")[0]->dato_skrevet;
    $endYear = $wpdb->get_results("SELECT dato_skrevet FROM " . getNyhetsartiklerDatabaseRef() . " ORDER BY dato_skrevet DESC LIMIT 1")[0]->dato_skrevet;

    error_log("Start: " . $startYear);
    error_log("End: " . $endYear);
    $startYear = date_create($startYear);
    $endYear = date_create($endYear);
    $startYear = date_format($startYear, "Y");
    $endYear = date_format($endYear, "Y");
    error_log("Start: " . $startYear);
    error_log("End: " . $endYear);

    ?>
    <div class = "collapsibles" id = "displayCol">
        <?php
        for ($i = $startYear; $i <= $endYear; $i++) {
            error_log("Year: " . $i);
            ?>
            <button type="button" class="collapsible">
                <?php echo $i?>
                <span class="material-icons">expand_more</span>
            </button>

            <div class="content">
                <?php
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
                            <a href = "../aarstall?it=nyhetsartikler&aar=<?php echo $i ?>"><button class = "viewMore">Vis alle nyheter fra <?php echo $i?></button></a>
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