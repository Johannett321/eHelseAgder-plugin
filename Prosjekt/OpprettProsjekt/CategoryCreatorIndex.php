<?php
function addCategoryCreatorIndex() {
    ?>
    <script type="text/javascript">
        function createCollapsibleType(name) {
            if (name === 'cleverandorer') {
                removeCategoryFromRemovedCollapsibles('cleverandorer');
                createLeverandorerCol();
            }else if (name === 'cprosjektteam') {
                removeCategoryFromRemovedCollapsibles('cprosjektteam');
                createProsjektTeamCol();
            }else if (name === 'cmerinfo') {
                removeCategoryFromRemovedCollapsibles('cmerinfo');
                createMerInfoCol();
            }else if (name === 'cmilepaeler') {
                removeCategoryFromRemovedCollapsibles('cmilepaeler');
                createMilepaelerCol();
            }else if (name === 'cnedlastbaredokumenter') {
                removeCategoryFromRemovedCollapsibles('cnedlastbaredokumenter');
                createNedlastbareDokumenterCol();
            }else if (name.includes('cegenkategori')) {
                createCustomCatCol();
            }
        }
    </script>
    <?php
}