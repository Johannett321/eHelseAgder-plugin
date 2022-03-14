<?php
function addCustomCatCol() {
    ?>
    <script type="text/javascript">
        var customColCounter = 0;

        function createCustomCatCol(egendefinertNavn, innhold) {
            if (innhold == null) innhold = "";
            if (egendefinertNavn == null) egendefinertNavn = "";

            const collapsible = createCollapsibleWithoutTitle();

            customColCounter += 1;

            collapsible.name = "cegenkategori" + customColCounter;

            const field = document.createElement('input');
            field.classList.add("collapsibleCustomTitle");
            field.id = "cvcustomtitle" + customColCounter;
            field.name = "cvcustomtitle" + customColCounter;
            field.type = "text";
            field.placeholder = "Hva skal kategorien hete?"
            field.value = egendefinertNavn;

            //oppdater 'name' feltet når brukeren skriver inn et navn
            $(document).ready(function(){
                $("#cvcustomtitle" + customColCounter).on("input", function(){
                    $(collapsible).attr('value', $(this).val());
                });
            });
            collapsible.appendChild(field);

            const textField = document.createElement('textarea');
            textField.name = "cvcustomdesc" + customColCounter;
            textField.value = innhold;
            collapsible.appendChild(textField);

            const savedTextInfo = getSavedText();
            addTextSaver(field, savedTextInfo, "c" + field.id + "_ls");
            addTextSaver(textField, savedTextInfo, "c" + textField.name + "_ls");
            collapsible.appendChild(savedTextInfo);

            collapsibles.appendChild(collapsible);
            scrollToView(collapsible);
        }
    </script>
    <?php
}