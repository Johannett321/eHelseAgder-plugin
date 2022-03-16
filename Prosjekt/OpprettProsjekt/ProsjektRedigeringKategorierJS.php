<?php
require 'Tools/ProsjektLoader.php';
require 'Tools/KategorierTool.php';
require 'Tools/KategorierSaverTool.php';

include "Collapsibles/LeverandorerCol.php";
include "Collapsibles/ProsjektTeamCol.php";
include "Collapsibles/MilepaelerCol.php";
include "Collapsibles/CustomCatCol.php";
include "Collapsibles/MerInfoCol.php";

function prosjektRedigeringKategorierJS() {
    addKategorierTools();
    addKategorierSaverTool();

    //Collapsibles
    addLeverandorerCol();
    addProsjektTeamCol();
    addMilepaelerCol();
    addCustomCatCol();
    addMerInfoCol();

    ?>
    <script type="text/javascript">
        (function () {
            const collapsibles = document.getElementById('collapsibles');
            const categoryChooser = document.getElementById('collapsibleChooser');
            const addCategoryButton = document.getElementById('addCategoryButton');

            const categoryAlreadyAdded = document.getElementById('categoryAlreadyAdded');
            const categoryAlreadyAddedText = document.getElementById('categoryAlreadyAddedText');

            $("#collapsibleChooser").change(function () {
                selectionOptionChanged();
            });

            addCategoryButton.addEventListener("click", function () {
                if (categoryChooser.value == 'cleverandorer') {
                    removeCategoryFromRemovedCollapsibles('cleverandorer');
                    createLeverandorerCol();
                    selectionOptionChanged();
                }else if (categoryChooser.value == 'cprosjektteam') {
                    createProsjektTeamCol();
                    selectionOptionChanged();
                }else if (categoryChooser.value == 'cegenkategori') {
                    createCustomCatCol();
                    selectionOptionChanged();
                }else if (categoryChooser.value == 'cmerinfo') {
                    createMerInfoCol();
                    selectionOptionChanged();
                }else if (categoryChooser.value == 'cmilepaeler') {
                    createMilepaelerCol();
                    selectionOptionChanged();
                }
            });

            function selectionOptionChanged() {
                if (isCategoryAlreadyAdded(categoryChooser.value)) {
                    addCategoryButton.classList.add('hidden');
                    categoryAlreadyAdded.classList.remove('hidden');
                    categoryAlreadyAddedText.innerText = categoryChooser.options[categoryChooser.selectedIndex].text + " lagt til";
                }else {
                    addCategoryButton.classList.remove('hidden');
                    categoryAlreadyAdded.classList.add('hidden');
                }
            }

            <?php
            //Henter prosjektet fra databasen dersom vi redigerer et prosjekt
            shallWeLoadProsjekt();
            ?>

            //TODO: HER KAN VI LOADE LISTEN MED COLLAPSIBLES SOM ER LAGT TIL PÅ DEN LOKALE SAVEN, OG LAGE DISSE
        })();
    </script>
    <?php
}