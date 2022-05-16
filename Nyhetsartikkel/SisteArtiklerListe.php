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
    $nyheter = getLastNyheterList();

    if (sizeof($nyheter) > 0 && isset($_GET['prosjektID']) && $projectName != null) {
        ?>
        <div class = "nyheterProsjekt"><h4 class = "contentTitle" id="nyheterNederst">Siste nyheter for: <?php echo $projectName?></h4>
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
    if (sizeof($nyheter) > 0 && isset($_GET['prosjektID']) && $projectName != null) {
        ?>
        <a href = "../../nyheter/aarstall/?it=nyhetsartikler&id=<?php echo $_GET['prosjektID']?>&pn=<?php echo $projectName?>"><button class="button" id = "nyheterForProsjektKnapp">Vis alle nyheter for <?php echo $projectName?><i class="material-icons">arrow_forward</i></button></a>
        </div>
        <?php
    }
}