<?php
function addLeverandorerCol() {
    ?>
    <script type="text/javascript">
        function createLeverandorerCol(savedText) {
            if (savedText == null) {
                savedText = "";
            }
            const collapsible = createCollapsibleWithTitle("Leverandører", "cleverandorer");
            if (collapsible == null) return;

            const textField = document.createElement('textarea');
            textField.name = "cleverandørtekst"
            textField.value = savedText;

            const savedTextInfo = getSavedText();
            addTextSaver(textField, savedTextInfo, "cleverandorer_ls");

            collapsible.appendChild(textField);
            collapsible.appendChild(savedTextInfo);

            collapsibles.appendChild(collapsible);
            scrollToView(collapsible);
        }
    </script>
    <?php
}