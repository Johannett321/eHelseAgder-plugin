<?php
add_shortcode( 'sc_siste_nyhetsartikler', 'sc_siste_nyhetsartikler');

function sc_siste_nyhetsartikler() {
    error_log("Trying to get news");
    loadSisteNyhetsartikler();
}

function getLastNyheterList() {
    global $wpdb;
    $query = "SELECT * FROM " . getNyhetsartiklerDatabaseRef() . " LIMIT 10";
    return $wpdb->get_results($query);
}

function loadSisteNyhetsartikler() {
    $nyheter = getLastNyheterList();
    foreach ($nyheter as $currentNyhet) {
        ?>
        <a href = <?php echo "vis-artikkel?artikkelID=" . $currentNyhet->id; ?>>
            <div class = "artikkelKort">
                <h5><?php echo $currentNyhet->tittel; ?></h5>
                <p><?php echo $currentNyhet->ingress; ?></p>
                <div><?php echo $currentNyhet->dato_skrevet; ?></div>
            </div>
        </a>
        <?php
    }
    ?>
    <style>
        .artikkelKort {
            background-color: #CCCCCC;
            padding: 10px;
            margin: 10px 0px;
            border-radius: 20px;
            box-shadow: 0px 2px 5px #898F9C;
        }
    </style>
    <?php
}