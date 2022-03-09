<?php
add_shortcode( 'sc_list_nyhetsartikler', 'sc_list_nyhetsartikler');

function sc_list_nyhetsartikler() {
    error_log("Trying to get news");
    loadNyhetsartikler();
}

function getNyheterList() {
    global $wpdb;
    $query = "SELECT * FROM " . getNyhetsartiklerDatabaseRef();
    return $wpdb->get_results($query);
}

function loadNyhetsartikler() {
    $nyheter = getNyheterList();
    foreach ($nyheter as $currentNyhet) {
        ?>
        <a href = <?php echo "vis-artikkel?artikkelID=" . $currentNyhet->id; ?>>
            <h5><?php echo $currentNyhet->tittel; ?></h5>
        </a>
        <?php
    }
    ?>
    <?php
}