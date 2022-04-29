<?php
add_shortcode('sc_nyheter_fra_aar', 'sc_nyheter_fra_aar');
add_shortcode('sc_mest_populaere_nyheter', 'sc_mest_populaere_nyheter');

function sc_nyheter_fra_aar() {
    if (areElementorBufferingObjects()) return;
    if (areWeEditingWithElementor()) {
        ?>
        <h5>Her vil alle nyhetene fra årstallet leseren velger vises</h5>
        <?php
        return;
    }
    if (!isset($_GET['year'])) {
        showErrorMessage("Siden har ikke blitt lastet inn på riktig måte!");
        return;
    }
    $year = $_GET['year'];
    ?>
    <center><h3>Alle nyhetsartikler  <?php if (isset($_GET['year'])) echo "fra " . $year ?></h3></center>
    <?php
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

function sc_mest_populaere_nyheter() {
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
    <center><h3>Mest populære nyhetsartikler <?php if (isset($_GET['year'])) echo "fra " . $year ?></h3></center>
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