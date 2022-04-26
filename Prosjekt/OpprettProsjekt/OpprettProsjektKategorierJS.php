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
include "Collapsibles/NedlastbareDokumenter.php";

function prosjektRedigeringKategorierJS() {
    ?>
    <script type="text/javascript">
        const categoryChooser = document.getElementById('collapsibleChooser');
        const addCategoryButton = document.getElementById('addCategoryButton');
    </script>
    <?php
    addKategorierTools();

    $editingProjectRevision = "null";
    if (isset($_GET['editProsjektID'])) {
        $editingProjectRevision = getProjectRevision($_GET['editProsjektID']);
    }
    addKategorierSaverTool($editingProjectRevision);

    //Collapsibles
    addLeverandorerCol();
    addProsjektTeamCol();
    addMilepaelerCol();
    addCustomCatCol();
    addMerInfoCol();
    addNedlastbareDokCol();

    addCategoryCreatorIndex();

    ?>
    <script type="text/javascript">
        (function () {
            selectionOptionChanged();
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

            loadAddedCollapsibles()
        })();
    </script>
    <?php
}