<?php
require 'Tools/ProsjektLoader.php';
require 'Tools/KategorierTool.php';
require 'Tools/KategorierSaverTool.php';

include "CategoryCreatorIndex.php";
include "Collapsibles/LeverandorerCol.php";
include "Collapsibles/ProsjektTeamCol.php";
include "Collapsibles/MilepaelerCol.php";
include "Collapsibles/CustomCatCol.php";
include "Collapsibles/MerInfoCol.php";

function prosjektRedigeringKategorierJS() {
    ?>
    <script type="text/javascript">
        const categoryChooser = document.getElementById('collapsibleChooser');
        const addCategoryButton = document.getElementById('addCategoryButton');
    </script>
    <?php
    addKategorierTools();
    addKategorierSaverTool();

    //Collapsibles
    addLeverandorerCol();
    addProsjektTeamCol();
    addMilepaelerCol();
    addCustomCatCol();
    addMerInfoCol();

    addCategoryCreatorIndex();

    ?>
    <script type="text/javascript">
        (function () {
            const collapsibles = document.getElementById('collapsibles');

            $("#collapsibleChooser").change(function () {
                selectionOptionChanged();
            });

            addCategoryButton.addEventListener("click", function () {
                createCollapsibleType(categoryChooser.value);
                selectionOptionChanged();
                saveAddedCategory(categoryChooser.value);
            });

            <?php
            //Henter prosjektet fra databasen dersom vi redigerer et prosjekt
            shallWeLoadProsjekt();
            ?>

            //TODO: HER KAN VI LOADE LISTEN MED COLLAPSIBLES SOM ER LAGT TIL PÅ DEN LOKALE SAVEN, OG LAGE DISSE

            loadAddedCollapsibles()

        })();
    </script>
    <?php
}