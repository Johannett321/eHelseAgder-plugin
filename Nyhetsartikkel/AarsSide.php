<?php
add_shortcode('sc_nyheter_fra_aar', 'sc_nyheter_fra_aar');
add_shortcode('sc_mest_populaere_nyheter', 'sc_mest_populaere_nyheter');

function sc_nyheter_fra_aar() {
    if (areElementorBufferingObjects()) return;
    if (areWeEditingWithElementor()) {
        ?>
        <h5>Her vil alle nyheter/prosjekter/arrangementer fra årstallet leseren velger vises</h5>
        <?php
        return;
    }
    if (!isset($_GET['year']) || !isset($_GET['it'])) {
        showErrorMessage("Siden har ikke blitt lastet inn på riktig måte!");
        return;
    }
    $year = $_GET['year'];
    $it = $_GET['it'];

    switch ($it) {
        case "nyhetsartikler":
            ?>
            <center><h3>Alle nyhetsartikler <?php if (isset($_GET['year'])) echo "fra " . $year ?></h3></center>
            <?php
            createYearNyhetsartikler($year);
            break;
        case "arrangementer":
            ?>
            <center><h3>Alle arrangementer <?php if (isset($_GET['year'])) echo "fra " . $year ?></h3></center>
            <?php
            createYearArrangementer($year);
            break;
        case "prosjekter":
            ?>
            <center><h3>Alle prosjekter <?php if (isset($_GET['year'])) echo "fra " . $year ?></h3></center>
            <?php
            createYearProsjekter($year);
            break;
    }
}

function createYearNyhetsartikler($year) {
    global $wpdb;
    $query = "SELECT * FROM " . getNyhetsartiklerDatabaseRef() .
        " WHERE dato_skrevet > '" . $year . "-01-01'" .
        " AND dato_skrevet < '" . ($year+1) . "-01-01'" .
        " ORDER BY dato_skrevet";

    $results = $wpdb->get_results($query);

    ?>
    <div class = "artikkelKortHolder">
        <?php
        foreach ($results as $result) {
            createShortArticle($result);
        }
        ?>
    </div>
    <?php
}

function createYearArrangementer($year) {
    global $wpdb;
    $query = "SELECT * FROM " . getArrangementerDatabaseRef() .
        " WHERE start_dato > '" . $year . "-01-01'" .
        " AND start_dato < '" . ($year+1) . "-01-01'" .
        " ORDER BY start_dato DESC";

    $results = $wpdb->get_results($query);

    ?>
    <div class = "artikkelKortHolder">
        <?php
        foreach ($results as $result) {
            createLargeListItem($result->tittel,
                $result->kort_besk,
                getNoneImportantDisplayDateFormat($result->start_dato) . " kl " . $result->start_klokkeslett,
                $result->sted,
                $result->bilde,
                "arrangementer/vis-arrangement/?eventID=" . $result->id);
        }
        ?>
    </div>
    <?php
}

function createYearProsjekter($year) {
    global $wpdb;
    $query = "SELECT * FROM " . getProsjekterDatabaseRef() .
        " WHERE prosjektstart >= " . $year .
        " AND prosjektstart < " . ($year+1) .
        " ORDER BY project_name DESC";

    $results = $wpdb->get_results($query);

    ?>
    <div class = "artikkelKortHolder">
        <?php
        foreach ($results as $result) {
            createLargeListItem($result->project_name,
                $result->undertittel,
                "Prosjektstart: " . $result->prosjektstart,
                "Prosjekteier: " . $result->prosjekteierkommuner,
                $result->bilde,
                "/prosjekter/prosjektside/?prosjektID=" . $result->id);
        }
        ?>
    </div>
    <?php
}

function sc_mest_populaere_nyheter() {
    if (!(isset($_GET['it']) && $_GET['it'] == "nyhetsartikler")) {
        return;
    }
    if (areElementorBufferingObjects()) return;
    if (areWeEditingWithElementor()) {
        ?>
        <h5>Her vil de mest populære nyhetene fra årstallet leseren velger vises</h5>
        <?php
        return;
    }
    if (!isset($_GET['year'])) {
        showErrorMessage("Siden har ikke blitt lastet inn på riktig måte!");
        return;
    }

    $year = $_GET['year'];
    ?>
    <center><h3>Mest leste nyhetsartikler <?php if (isset($_GET['year'])) echo "fra " . $year ?></h3></center>
    <?php
    $query = "SELECT * FROM " . getNyhetsartiklerDatabaseRef();

    if (isset($_GET['year'])) {
        $year = $_GET['year'];
        $query .= " WHERE dato_skrevet > '" . $year . "-01-01'" .
            " AND dato_skrevet < '" . ($year+1) . "-01-01'";
    }

    $query .= " ORDER BY antall_lesere DESC" .
    " LIMIT 3";

    global $wpdb;
    $results = $wpdb->get_results($query);

    ?>
    <div class = "artikkelKortHolder">
        <?php
        foreach ($results as $result) {
            createShortArticle($result);
        }
        ?>
    </div>
    <?php
}