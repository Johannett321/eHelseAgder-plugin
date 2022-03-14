<?php
function addMerInfoCol() {
    ?>
    <script type="text/javascript">
        function createMerInfoCol(innhold) {
            if (innhold == null) innhold = "";

            const collapsible = createCollapsibleWithTitle("Mer informasjon om prosjektet", "cmerinfo");
            if (collapsible == null) return;

            const textField = document.createElement('textarea');
            textField.name = "cmerinfotekst"
            textField.value = innhold;

            collapsible.appendChild(textField);

            const savedTextInfo = getSavedText();
            addTextSaver(textField, savedTextInfo, "c" + "merinfo" + "_ls");
            collapsible.appendChild(savedTextInfo);

            collapsibles.appendChild(collapsible);
            scrollToView(collapsible);
        }
    </script>
    <?php
}