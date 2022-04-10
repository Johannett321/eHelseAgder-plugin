<?php
include "AarsSide.php";
include "NyhetsSok.php";

add_shortcode( 'sc_nyhetsarkiv', 'sc_nyhetsarkiv');

function sc_nyhetsarkiv() {
    error_log("Trying to get news");
    loadNyhetsartikler();
}

function loadNyhetsartikler() {
    $startYear = 2022;
    $endYar = date("Y");

    ?>
    <div class = "collapsibles" id = "displayCol">
        <?php
        for ($i = $startYear; $i <= $endYar; $i++) {
            ?>
            <button type="button" class="collapsible">
                <?php echo $i?>
            </button>

            <div class="content">
                <?php
                global $wpdb;
                $query = "SELECT * FROM " . getNyhetsartiklerDatabaseRef() .
                    " WHERE dato_skrevet >= '" . $i . "-01-01'" .
                    " AND dato_skrevet < '" . ($i+1) . "-01-01'" .
                    " LIMIT 5";

                error_log("Asking: " . $query);
                $results =  $wpdb->get_results($query);

                error_log("Result length: " . sizeof($results));

                $articleCounter = 0;
                foreach($results as $result) {
                    $articleCounter++;
                    createShortArticle($result);
                }
                if ($articleCounter > 4) {
                    ?>
                    <center>
                        <a href = "aarstall?year=<?php echo $i ?>"><button class = "viewMore">Vis alle nyheter fra <?php echo $i?></button></a>
                    </center>
                    <?php
                }
                ?>
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