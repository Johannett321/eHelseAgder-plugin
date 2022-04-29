<?php
function addKategorierTools() {
    ?>
    <script type="text/javascript">
        //TODO her må vi fylle ut hvilke filer som skal slettes dersom en collapsible blir slettet
        function getFieldsForName(collapsibleName) {
            switch (collapsibleName) {
                case "cleverandorer":
                    return ["cleverandorer_ls", "cleverandorer_ls_time"];
                    break;
                case "cmilepaeler":
                    return ["milepaeler", "milepaeler_time", "cmdropdown1", "cmdropdown1_time",
                        "cmdropdown2", "cmdropdown2_time", "cmdropdown3", "cmdropdown3_time",
                        "cmdropdown4", "cmdropdown4_time", "cmdropdown5", "cmdropdown5_time"];
                    break;
                case "cprosjektteam":
                    return ["prosjektteam", "prosjektteam_time"];
                    break;
                case "cmerinfo":
                    return ["cmerinfo_ls", "cmerinfo_ls_time"];
                    break;
                case "cnedlastbaredokumenter":
                    return "";
                    break
            }
        }

        /*
        -------------------ANIMATIONS-------------------
         */

        function scrollToView(view) {
            view.scrollIntoView({
                behavior: "smooth",
                block: "center",
                inline: "nearest"
            });
        }

        const categoryAlreadyAdded = document.getElementById('categoryAlreadyAdded');
        const categoryAlreadyAddedText = document.getElementById('categoryAlreadyAddedText');

        function selectionOptionChanged() {
            if (categoryChooser.value === "") {
                addCategoryButton.classList.add('hidden');
            }else if (isCategoryAlreadyAdded(categoryChooser.value)) {
                addCategoryButton.classList.add('hidden');
                categoryAlreadyAdded.classList.remove('hidden');
                categoryAlreadyAddedText.innerText = categoryChooser.options[categoryChooser.selectedIndex].text + " lagt til";
            }else {
                addCategoryButton.classList.remove('hidden');
                categoryAlreadyAdded.classList.add('hidden');
            }
        }

        /*
        -------------------CREATING COLLAPSIBLES-------------------
         */

        function isCategoryAlreadyAdded(categoryName, shouldAlert) {
            for (let i = 0; i < collapsibles.children.length; i++) {
                if (collapsibles.children[i].name == categoryName) {
                    if (shouldAlert) {
                        alert("Denne kategorien er allerede lagt til. Den kan ikke legges til to ganger.");
                    }
                    return true;
                }else {
                    console.log(collapsibles.children[i].name + " is not the same as " + categoryName);
                }
            }
            return false;
        }

        function createCollapsibleWithTitle(titleText, name) {
            if (isCategoryAlreadyAdded(name, true)) return null;

            const collapsible = createCollapsibleWithoutTitle();
            collapsible.name = name;

            const title = document.createElement('h5');
            title.innerText = titleText;

            collapsible.appendChild(title);
            return collapsible;
        }

        function createCollapsibleWithoutTitle() {
            const collapsible = document.createElement('div');
            collapsible.classList.add('collapsible');

            const removeCollapsibleButton = document.createElement('button');
            removeCollapsibleButton.type = "button";
            removeCollapsibleButton.innerHTML = '<img src="https://www.nicepng.com/png/full/242-2425648_close-remove-delete-exit-cross-cancel-trash-comments.png" />';
            removeCollapsibleButton.classList.add('removeCollapsibleButton');
            $(removeCollapsibleButton).click(function (e) {
                if (confirm("Er du sikker?") == true) {
                    $(collapsible).animate({opacity: '0%', height: '0px'}, function (){$(collapsible).remove(); selectionOptionChanged();saveDeletedCollapsible(collapsible.name, getFieldsForName(collapsible.name));});
                }
            });

            collapsible.appendChild(removeCollapsibleButton);
            return collapsible;
        }

        function createMultiSaverTextField(title, name, placeholder, fieldContent, arrayWithBrothers, textboxNumber, savedLabel, localSave) {
            if (fieldContent == null) fieldContent = "";

            const container = document.createElement('div');
            container.classList.add('textFieldContainer');

            const field = document.createElement('input');
            field.id = name;
            field.name = name;
            field.type = "text";
            field.value = fieldContent;
            if (placeholder != null) {
                field.placeholder = placeholder;
            }
            protectTextFieldFromCreepyCharacters(field);

            addSpecialSaver(arrayWithBrothers,field,textboxNumber,savedLabel,localSave);

            const label = document.createElement('label');
            label.for = name;
            label.innerText = title;

            container.appendChild(label);
            container.appendChild(field);
            return container;
        }



        function createTextFieldWithLabel(title, name, placeholder, fieldContent, savedTextLabel) {
            if (fieldContent == null) fieldContent = "";

            const container = document.createElement('div');
            container.classList.add('textFieldContainer');

            const field = document.createElement('input');
            field.id = name;
            field.name = name;
            field.type = "text";
            field.value = fieldContent;
            if (placeholder != null) {
                field.placeholder = placeholder;
            }

            addTextSaver(field, savedTextLabel, name);

            const label = document.createElement('label');
            label.for = name;
            label.innerText = title;

            container.appendChild(label);
            container.appendChild(field);
            return container;
        }

        var lastKeypress = 0;
    </script>
    <?php
}