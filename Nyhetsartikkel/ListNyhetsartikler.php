<?php
add_shortcode( 'sc_list_nyhetsartikler', 'sc_list_nyhetsartikler');

function sc_list_nyhetsartikler() {
    error_log("Trying to get news");
    loadNyhetsartikler();
}

function getNyheterList($year) {
    global $wpdb;
    $query = "SELECT * FROM " . getNyhetsartiklerDatabaseRef() . " WHERE dato_skrevet > '01.01." . $year . "'";
    return $wpdb->get_results($query);
}

function loadNyhetsartikler() {
    $startYear = 2022;
    $endYar = 2030;

    ?>
    <div class = "collapsibles" id = "displayCol">
        <?php
        for ($i = $startYear; $i < $endYar; $i++) {
            ?>
            <div class = "collapsible">
                <button type="button" class="collapsible">
                    <?php echo $i?>
                </button>

                <div class="content">
                    <?php
                    global $wpdb;
                    $query = "SELECT * FROM " . getNyhetsartiklerDatabaseRef() .
                        " WHERE dato_skrevet > '" . $i . "-01-01'" .
                        " AND dato_skrevet < '" . ($i+1) . "-01-01'" .
                        " LIMIT 1";

                    error_log("Asking: " . $query);
                    $results =  $wpdb->get_results($query);

                    error_log("Result length: " . sizeof($results));

                    foreach($results as $result) {
                        ?>
                        <h5>Date: <?php echo $result->dato_skrevet?></h5>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <script type = "text/javascript">
        var coll = document.getElementsByClassName("collapsible");

        for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                    content.style.display = "none";
                } else {
                    content.style.display = "block";
                }
            });
        }
    </script>

    <?php
}