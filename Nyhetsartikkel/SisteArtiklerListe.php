<?php
add_shortcode( 'sc_siste_nyhetsartikler', 'sc_siste_nyhetsartikler');

function sc_siste_nyhetsartikler($projectName) {
    if (areElementorBufferingObjects()) return;
    loadSisteNyhetsartikler($projectName);
}

function getLastNyheterList() {
    $limitToProject = "";
    if (isset($_GET['prosjektID'])) {
        $limitToProject = " WHERE tilknyttet_prosjekt = " . $_GET['prosjektID'];
    }
    global $wpdb;
    $query = "SELECT * FROM " . getNyhetsartiklerDatabaseRef() . $limitToProject . " ORDER BY dato_skrevet DESC LIMIT 4";
    return $wpdb->get_results($query);
}

function loadSisteNyhetsartikler($projectName) {
    if (isset($_GET['message']) && !isset($_GET['prosjektID'])) {
        showCompleteMessage($_GET['message']);
    }

    $nyheter = getLastNyheterList();

    if (sizeof($nyheter) > 0 && isset($_GET['prosjektID']) && $projectName != null) {
        ?>
        <center><h4 class = "contentTitle">Nyheter for <?php echo $projectName?></h4></center>
        <?php
    }
    ?>
    <div class = "artikkelKortHolder">
        <?php
        foreach ($nyheter as $currentNyhet) {
            createShortArticle($currentNyhet);
        }
        ?>
    </div>
    <?php
}