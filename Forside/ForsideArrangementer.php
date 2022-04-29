<?php

add_shortcode( 'sc_forside_arrangementer', 'sc_forside_arrangementer');

function sc_forside_arrangementer() {
    loadForsideArrangementer();
}

function loadForsideArrangementer() {
    if (areWeEditingWithElementor()) {
        ?>
        <center><h5>Her vil arrangementene vises</h5></center>
        <?php
        return;
    }
    global $wpdb;
    $dagensDato = date('Y-m-d');
    $arrangementer = $wpdb->get_results("SELECT * FROM " . getArrangementerDatabaseRef() . "  WHERE start_dato > '" . $dagensDato . "'  ORDER BY start_dato ASC LIMIT 5");
    ?>
    <div class = "arrangementer">
        <?php
        foreach ($arrangementer as $currentArrangement) {
            ?>
            <a href = "">
                <div class ="arrangement">
                    <h5><?php echo $currentArrangement->tittel ?></h5>
                    <div class = "datoBoks">
                        <h5><?php echo getNoneImportantDisplayDateFormat($currentArrangement->start_dato) . " kl " . $currentArrangement->start_klokkeslett ?></h5>
                    </div>
                    <p><?php echo $currentArrangement->kort_besk ?></p>
                    <div class = "LesMer">
                        Les mer <span class ="material-icons">chevron_right</span>
                    </div>
                </div>
            </a>
            <?php
        }
        ?>
    </div>
    <?php
}