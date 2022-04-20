<?php
add_shortcode('sc_arrangementer_fra_aar', 'sc_arrangementer_fra_aar');

function sc_arrangementer_fra_aar() {
    if (!isset($_GET['year'])) {
        showErrorMessage("Siden har ikke blitt lastet inn på riktig måte!");
        return;
    }
    $year = $_GET['year'];
    ?>
    <center><h3>Alle arrangementer  <?php if (isset($_GET['year'])) echo "fra " . $year ?></h3></center>
    <div class = "artikkelKortHolder">
        <?php
        global $wpdb;
        $query = "SELECT * FROM " . getArrangementerDatabaseRef() .
            " WHERE start_dato > '" . $year . "-01-01'" .
            " AND start_dato < '" . ($year+1) . "-01-01'";

        $results = $wpdb->get_results($query);
        foreach($results as $result) {
            createLargeListItem($result->tittel,
            $result->kort_besk,
            getDisplayDateFormat($result->start_dato),
            $result->sted,
            $result->bilde,
            "vis-arrangement/?eventID=1");
        }
        ?>
    </div>
    <?php
}